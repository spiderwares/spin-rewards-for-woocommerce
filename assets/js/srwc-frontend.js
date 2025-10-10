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
            this.floatingButton();
            this.popupTrigger();
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
                }
            } catch (e) {
                this.slides = [];
            }
        }

        popupTrigger() {
            const settings = srwc_frontend?.settings || {},
                trigger = settings.popup_trigger || 'show_wheel',
                initialDelay = parseFloat(settings.initial_delay) || 0;
        
            switch (trigger) {
                case 'popup_icon':
                    break;
        
                case 'show_wheel':
                    setTimeout(() => {
                        this.openWheel({ preventDefault: () => {} });
                    }, initialDelay * 1000);
                    break;
            }
        }
    
        buildWheel() {
            const canvas = document.getElementById('srwc_wheel_canvas');
            canvas.width = 500;
            canvas.height = 500;
            this.wheelInner = this.modal.find('.wheel-inner');
            this.wheelInner.empty().append(canvas);
        
            const ctx = canvas.getContext('2d'),
                total = this.slides.length,
                centerX = canvas.width / 2,
                centerY = canvas.height / 2,
                radius = 230,
                textRadius = 150;
        
            for (let i = 0; i < total; i++) {
                const startAngle = (i * 2 * Math.PI) / total,
                    endAngle = ((i + 1) * 2 * Math.PI) / total;
        
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
                ctx.fillText(label, textRadius, 5);
                ctx.restore();
            }
        }

        labelDisplay(label) {
            return label;
        }

        openWheel(e) {
            e.preventDefault();
        
            const settings = srwc_frontend?.settings || {};
            let delay = 0;
        
            if (settings.initial_delay) {
                const parts = settings.initial_delay.split(','),
                    min = parseFloat(parts[0]) || 0,
                    max = parseFloat(parts[1]) || 0;
        
                delay = Math.random() * (max - min) + min;
            }
        
            // Delay popup show
            setTimeout(() => {
                this.buildWheel();
                this.modal.show();
        
                setTimeout(() => {
                    this.modal.find('.srwc-wheel-container').addClass('slide-in');
                }, 50);
            }, delay * 1000);
        }

        closeWheel(e) {
            const settings = srwc_frontend?.settings || {};
        
            if (e.target.id === 'srwc-wheel-modal' || $(e.target).hasClass('srwc-close')) {
        
                if (this.autoHideTimer) {
                    clearTimeout(this.autoHideTimer);
                    this.autoHideTimer = null;
                }
        
                this.modal.find('.srwc-wheel-container').removeClass('slide-in').addClass('slide-out');
        
                setTimeout(() => {
                    this.modal.hide();
                    this.modal.find('.srwc-wheel-container').removeClass('slide-out');
                    this.handleIconHide();
        
                    if (!this.hasSpin) {
                        let timeOnClose = parseInt(settings.time_on_close) || 0;
                        let unit = settings.time_on_close_unit || 'minutes';
        
                        let multiplier = 1000; 
                        if (unit === 'minutes') multiplier = 60 * 1000;
                        else if (unit === 'hours') multiplier = 60 * 60 * 1000;
                        else if (unit === 'days') multiplier = 24 * 60 * 60 * 1000;
        
                        if (timeOnClose > 0) {
                            setTimeout(() => {
                                this.openWheel({ preventDefault: () => {} });
                            }, timeOnClose * multiplier);
                        }
                    }
        
                    // Reset spin flag
                    this.hasSpin = false;
        
                }, 800);
            }
        }
        
        spinWheel(e) {
            e.preventDefault();
            if (!this.wheelInner || !this.slides.length || !this.validateForm()) return;
        
            const settings = srwc_frontend?.settings || {},
                lastSpinKey = 'srwc_last_spin_time',
                now = Date.now(),
                lastSpin = parseInt(localStorage.getItem(lastSpinKey)) || 0,
                waitMilliseconds = srwc_frontend.waitMilliseconds || (24 * 60 * 60 * 1000); 
        
            if (now - lastSpin < waitMilliseconds) {
                const remainingMs = waitMilliseconds - (now - lastSpin),
                    unit = settings.time_spin_between_unit || 'hours';
                let remaining;
            
                switch (unit) {
                    case 'seconds':
                        remaining = Math.ceil(remainingMs / 1000);
                        break;
                    case 'minutes':
                        remaining = Math.ceil(remainingMs / (60 * 1000));
                        break;
                    case 'hours':
                        remaining = Math.ceil(remainingMs / (60 * 60 * 1000));
                        break;
                    case 'days':
                        remaining = Math.ceil(remainingMs / (24 * 60 * 60 * 1000));
                        break;
                    default:
                        remaining = Math.ceil(remainingMs / 1000);
                }
            
                const waitMsgTemplate = srwc_frontend.messages.wait_spin || 'You must wait %s before spinning again.';
                alert(waitMsgTemplate.replace('%s', `${remaining} ${unit}`));
                return;
            }

            localStorage.setItem(lastSpinKey, now);
        
            const spinBtn = this.modal.find('.srwc-spin-btn'),
                total = this.slides.length,
                degreesPer = 360 / total,
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
                const index  = Math.floor((360 - (rotateTo % 360)) / degreesPer) % total,
                    chosen = this.slides[index],
                    label  = this.labelDisplay(chosen.label || '', chosen);
        
                if (['percent', 'fixed_product', 'fixed_cart'].includes(chosen.coupon_type)) {
                    this.generateCoupon(chosen, (success, updatedChosen) => {
                        if (success) {
                            this.showWinMessage(updatedChosen, label);
                            this.handleShowAgain(settings.show_again);
                        }
                    });
                } else {
                    // For loss results, still record the spin but don't send email
                    this.recordLossSpin(chosen, label);
                    this.showWinMessage(chosen, label);
                    this.handleShowAgain(settings.show_again);
                }
            }, duration * 1000);
        }

        handleShowAgain( delay, unit ) {
            delay = parseInt(delay) || 0;
            if (delay <= 0) return;
        
            let multiplier = 1000; 
            if (unit === 'minutes') multiplier = 60 * 1000;
            else if (unit === 'hours') multiplier = 60 * 60 * 1000;
            else if (unit === 'days') multiplier = 24 * 60 * 60 * 1000;
        
            this.floatingBtn.addClass('srwc-hidden');
        
            setTimeout(() => {
                this.floatingBtn.removeClass('srwc-hidden');
                localStorage.setItem('srwc_icon_hidden', 'false');
            }, delay * multiplier); 
        }

        generateCoupon(chosen, callback) {
            $.ajax({
                type: 'POST',
                url: srwc_frontend.ajax_url,
                data: {
                    action: 'srwc_generate_coupon',
                    nonce: srwc_frontend.nonce,
                    coupon_type: chosen.coupon_type,
                    customer_email: $('.srwc-email').val(),
                    customer_name: $('.srwc-name').val(),
                    win_label: chosen.label || '',
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
                }
            });
        }

        recordLossSpin(chosen, label) {
            $.ajax({
                type: 'POST',
                url: srwc_frontend.ajax_url,
                data: {
                    action: 'srwc_record_loss_spin',
                    nonce: srwc_frontend.nonce,
                    customer_email: $('.srwc-email').val(),
                    customer_name: $('.srwc-name').val(),
                }
            });
        }

        validateForm() {
            const emailField = this.modal.find('.srwc-email'),
                    nameField  = this.modal.find('.srwc-name'),
                    email      = emailField.val().trim(),
                    settings   = srwc_frontend?.settings || {};
        
            this.modal.find('.srwc-error').hide().text('');
        
            // Name validation
            if (settings.user_name_require === 'yes' && nameField.length) {
                const name = nameField.val().trim();
                if (!name) {
                    nameField.next('.srwc-name-error').text(srwc_frontend.messages.name_required || 'Please enter your name').show();
                    nameField.focus();
                    return false;
                }
            }
        
            // Email required
            if (!email) {
                emailField.next('.srwc-email-error').text(srwc_frontend.messages.email_required || 'Please enter your email').show();
                emailField.focus();
                return false;
            }
        
            const emailRegex = /^[^\s@]+@[a-zA-Z]+\.[A-Za-z]{2,}$/;
            if (!emailRegex.test(email)) {
                emailField.next('.srwc-email-error').text(srwc_frontend.messages.email_invalid || 'Please enter a valid email').show();
                emailField.focus();
                return false;
            }
        
            return true;
        }

        floatingButton() {
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
            const settings = srwc_frontend?.settings || {},
                isWin = chosen.coupon_type !== 'none';
            
            let message;
            if (isWin) {
                message = settings.win_message
                    .replace('{coupon_label}', label ? '<b>' + label + '</b>' : '')
                    .replace('{checkout}', '<a href="' + srwc_frontend.checkout_url + '">checkout</a>');
            } else {
                message = settings.lose_message;
            }
            
            // Hide the form and show message
            this.modal.find('.srwc-wheel-controls').hide();
            this.modal.find('.srwc-win-text').html(message);
            this.modal.find('.srwc-win-message').show();
            
            this.autoHideWheel(settings);
        }

        autoHideWheel(settings) {
            const autoHideDelay = parseInt(settings.auto_hide_wheel) || 0;
            
            if (autoHideDelay > 0) {
                if (this.autoHideTimer) {
                    clearTimeout(this.autoHideTimer);
                }
                
                this.autoHideTimer = setTimeout(() => {
                    this.closeWheel({ target: { id: 'srwc-wheel-modal' } });
                }, autoHideDelay * 1000); 
            }
        }       

    }

    new SRWC_Frontend();
});