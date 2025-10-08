    jQuery(function($) {
        class SRWC_Frontend {

            constructor() {
                this.init();
            }

            init() {
                this.slides = [];
                this.modal = $('.srwc-wheel-modal');
                this.wheelInner = null;
                this.floatingBtn = $('.srwc-floating-btn');
                this.loadSlides();
                this.bindEvents();
                this.initFloatingButton();
            }

            bindEvents() {
                $(document.body).on( 'click', '.srwc-open-wheel, .srwc-floating-btn', this.openWheel.bind(this) );
                $(document.body).on( 'click', '.srwc-close, .srwc-wheel-modal', this.closeWheel.bind(this) );
                $(document.body).on( 'click', '.srwc-spin-btn', this.spinWheel.bind(this) );
            }

            loadSlides() {
                try {
                    if (typeof srwc_frontend !== 'undefined' && srwc_frontend.slides) {
                        this.slides = srwc_frontend.slides;
                        console.log('Slides loaded:', this.slides);
                    }
                } catch (e) {
                    this.slides = [];
                }
            }

            // Build wheel SVG dynamically
            buildWheel() {
                const canvas = document.getElementById('srwc_wheel_canvas');
                canvas.width = 500;
                canvas.height = 500;
                this.wheelInner = this.modal.find('.wheel-inner');
                this.wheelInner.empty().append(canvas);
            
                const ctx = canvas.getContext('2d');
                const total = this.slides.length;
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;
                const radius = 230;
                const textRadius = 150;
            
                for (let i = 0; i < total; i++) {
                    const startAngle = (i * 2 * Math.PI) / total;
                    const endAngle = ((i + 1) * 2 * Math.PI) / total;
            
                    // Draw slice
                    ctx.beginPath();
                    ctx.moveTo(centerX, centerY);
                    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                    ctx.closePath();
                    ctx.fillStyle = this.slides[i].color || this.randomColor();
                    ctx.fill();
            
                    // Draw text
                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.rotate(startAngle + (endAngle - startAngle) / 2);
                    ctx.textAlign = "center";
                    ctx.fillStyle = "#fff";
                    ctx.font = "20px Helvetica";
            
                    let label = this.slides[i].label || '';
                    label = label.replace('{coupon_amount}', this.slides[i].value || '');
                    ctx.fillText(label, textRadius, 5);
                    ctx.restore();
                }
            }

            // Open spin
            openWheel(e) {
                e.preventDefault();
                this.buildWheel();
                this.modal.show();
                
                setTimeout(() => {
                    this.modal.find('.srwc-wheel-container').addClass('slide-in');
                }, 50);
            }

            // Close spin
            closeWheel(e) {
                if (e.target.id === 'srwc-wheel-modal' || $(e.target).hasClass('srwc-close')) {
                    this.modal.find('.srwc-wheel-container').removeClass('slide-in').addClass('slide-out');
                    
                    setTimeout(() => {
                        this.modal.hide();
                        this.modal.find('.srwc-wheel-container').removeClass('slide-out');
                        this.handleIconHide();
                    }, 800);
                }
            }

            spinWheel(e) {
                e.preventDefault();
                if (!this.wheelInner || !this.slides.length || !this.validateForm()) return;
            
                const spinBtn = this.modal.find('.srwc-spin-btn'),
                      total = this.slides.length,
                      degreesPer = 360 / total,
                      settings = srwc_frontend?.settings || {},
                      speedMap = { one: 1, two: 2, three: 3, four: 4, five: 5 },
                      speed = speedMap[settings.wheel_speed_spin || 'three'] || 3,
                      duration = 4,
                      rotateTo = (360 * speed) + Math.random() * 360;
            
                spinBtn.prop('disabled', true).html('<span class="srwc-loader"></span>');
            
                this.wheelInner.css({
                    transition: `transform ${duration}s cubic-bezier(0.33,1,0.68,1)`,
                    transform: `rotate(${rotateTo}deg)`
                });
            
                setTimeout(() => {
                    const index = Math.floor((360 - (rotateTo % 360)) / degreesPer) % total;
                    const chosen = this.slides[index];
                    const label = (chosen.label || '').replace('{coupon_amount}', chosen.value || '');
            
                    if (['percent', 'fixed_product', 'fixed_cart'].includes(chosen.coupon_type)) {
                        this.generateCoupon(chosen, (success, updatedChosen) => {
                            if (success) {
                                this.showWinMessage(updatedChosen, label);
                            }
                        });
                    } else {
                        this.showWinMessage(chosen, label);
                    }
                }, duration * 1000);
            }

            generateCoupon(chosen, callback) {
                $.ajax({
                    type: 'POST',
                    url: srwc_frontend.ajax_url,
                    data: {
                        action: 'srwc_generate_coupon',
                        nonce: srwc_frontend.srwc_nonce,
                        coupon_type: chosen.coupon_type,
                        value: chosen.value
                    },
                    success: (response) => {
                        if (response.success && response.data) {
                            chosen.generated_coupon = response.data.coupon_code;
                            if (typeof callback === 'function') callback(true, chosen);
                        } else {
                            alert(srwc_frontend.messages.failed_generate_coupon || 'Failed to generate coupon.');
                            if (typeof callback === 'function') callback(false, chosen);
                        }
                    },
                    error: () => {
                        alert(srwc_frontend.messages.failed_generate_coupon || 'Failed to generate coupon.');   
                        if (typeof callback === 'function') callback(false, chosen);
                    }
                });
            }

            validateForm() {
                const emailField = this.modal.find('.srwc-email'),
                    nameField = this.modal.find('.srwc-name'),
                    email = emailField.val().trim(),
                    settings = srwc_frontend?.settings || {};

                if (!email) {
                    alert(srwc_frontend.messages.email_required);
                    emailField.focus();
                    return false;
                }
            
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert(srwc_frontend.messages.email_invalid);
                    emailField.focus();
                    return false;
                }
            
                if (settings.user_name_require === 'yes' && nameField.length) {
                    const name = nameField.val().trim();
                    if (!name) {
                        alert(srwc_frontend.messages.name_required);
                        nameField.focus();
                        return false;
                    }
                }
            
                return true;
            }

            initFloatingButton() {
                const isHidden = localStorage.getItem('srwc_icon_hidden');
                if (isHidden === 'true') {
                    this.floatingBtn.addClass('srwc-hidden');
                }
            }

            handleIconHide() {
                const hideIcon = this.floatingBtn.data('hide-icon');
                if (hideIcon === 'yes') {
                    this.floatingBtn.addClass('srwc-hidden');
                    localStorage.setItem('srwc_icon_hidden', 'true');
                }
            }

            showWinMessage(chosen, label) {
                const settings = srwc_frontend?.settings || {};
                
                // Check if it's a win or lose
                const isWin = chosen.coupon_type !== 'none';
                
                let message;
                if (isWin) {
                    message = settings.win_message || 'Congratulations! You have won a {coupon_label} discount coupon.';
                
                    const couponText = chosen.generated_coupon
                        ? `<br><strong>Coupon Code:</strong> <span class="srwc-coupon-code">${chosen.generated_coupon}</span>`
                        : '';
                
                    message = message
                        .replace('{coupon_label}', label ? '<b>' + label + '</b>' : '')
                        .replace('{checkout}', '<a href="' + srwc_frontend.checkout_url + '">checkout</a>')
                        + couponText;
                } else {
                    message = settings.lose_message || 'Oops! No luck this time. Try again!';
                }
                
                
                // Hide the form and show message
                this.modal.find('.srwc-wheel-controls').hide();
                this.modal.find('.srwc-win-text').html(message);
                this.modal.find('.srwc-win-message').show();
                
                // Re-enable spin button for potential future spins
                this.modal.find('.srwc-spin-btn').prop('disabled', false).text(
                    settings.spin_button_text || 'Spin Now'
                );
            }       

        }

        new SRWC_Frontend();
    });