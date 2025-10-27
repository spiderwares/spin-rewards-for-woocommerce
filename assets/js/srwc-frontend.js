'use strict ';

jQuery(function($) {
    class SRWC_Frontend {

        constructor() {
            this.init();
        }

        init() {
            this.slides      = [];
            this.modal       = $('.srwc-wheel-modal');
            this.wheelInner  = null;
            this.floatingBtn = $('.srwc-floating-btn');
            this.loadslides();
            this.bindEvents();
            this.floatingButton();
            this.popupTrigger();
            
            window.srwcFrontendInstance = this;
        }

        bindEvents() {
            $(document.body).on( 'click', '.srwc-open-wheel, .srwc-floating-btn', this.openWheel.bind(this) );
            $(document.body).on( 'click', '.srwc-close, .srwc-close-btn, .srwc-wheel-modal', this.closeWheel.bind(this) );
            $(document.body).on( 'click', '.srwc-spin-btn', this.spinWheel.bind(this) );
        }

        loadslides() {
            try {
                if (typeof srwc_frontend !== 'undefined' && srwc_frontend.slides) {
                    this.slides = srwc_frontend.slides;
                }
            } catch (e) {
                this.slides = [];
            }
        }

        popupTrigger() {
            const settings   = srwc_frontend?.settings || {},
                trigger      = settings.popup_trigger || 'show_wheel',
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
            const canvas = document.getElementById('srwc_wheel_canvas'),
                settings = srwc_frontend?.settings || {};
        
            // Default base values
            let baseSize   = 550,
                wheelSize  = 100,
                fontSize   = 20,
                textColor  = "#fff",
                fontFamily = "Poppins";
        
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction(
                    'srwcSpinWhel',
                    {
                        settings,
                        defaultWheelSize: baseSize,
                        defaultPercent: wheelSize,
                        defaultSize: fontSize,
                        defaultColor: textColor,
                        defaultFontFamily: fontFamily
                    },
                    (data) => {
                        if (data) {
                            fontSize   = parseInt(data.fontSize) || fontSize;
                            textColor  = data.color || textColor;
                            fontFamily = data.fontFamily || fontFamily;
                            wheelSize  = parseInt(data.wheelSize) || wheelSize;
                        }
                    }
                );
            }
        
            // Apply wheel size dynamically
            const finalSize = (baseSize * wheelSize) / 100;
            canvas.width = finalSize;
            canvas.height = finalSize;
        
            this.wheelInner = this.modal.find('.wheel-inner');
            this.wheelInner.empty().append(canvas);
        
            const ctx       = canvas.getContext('2d'),
                total       = this.slides.length,
                centerX     = canvas.width / 2,
                centerY     = canvas.height / 2,
                radius      = (finalSize / 2) - 25,
                textRadius  = radius - 80;
        
            const borderColor = settings.wheel_border_color || '#ffffff',
                  dotColor = settings.wheel_dot_color || '#000000';
        
            // Shadow + Border
            ctx.save();
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.strokeStyle = borderColor;
            ctx.lineWidth = 15;
            ctx.stroke();
            ctx.restore();
        
            // Draw slides
            for (let i = 0; i < total; i++) {
                const startAngle = (i * 2 * Math.PI) / total,
                    endAngle = ((i + 1) * 2 * Math.PI) / total;
        
                // slide background
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius - 4, startAngle, endAngle);
                ctx.closePath();
                ctx.fillStyle = this.slides[i].color || this.randomColor();
                ctx.fill();
        
                // slide border dots
                const dotX = centerX + Math.cos(startAngle) * radius,
                    dotY = centerY + Math.sin(startAngle) * radius;
                ctx.beginPath();
                ctx.arc(dotX, dotY, 4, 0, 2 * Math.PI);
                ctx.fillStyle = dotColor;
                ctx.fill();
        
                // Draw text
                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(startAngle + (endAngle - startAngle) / 2);
                ctx.textAlign = "center";
                ctx.fillStyle = textColor;
                ctx.font = `${fontSize}px ${fontFamily}`;
                let label = this.slides[i].label || '';
                ctx.fillText(label, textRadius, 5);
                ctx.restore();
            }
        }
        
        openWheel(e) {
            e.preventDefault();
        
            const settings = srwc_frontend?.settings || {};
            let delay      = 0;
        
            if (settings.initial_delay) {
                const parts = settings.initial_delay.split(','),
                    min     = parseFloat(parts[0]) || 0,
                    max     = parseFloat(parts[1]) || 0;
        
                delay = Math.random() * (max - min) + min;
            }
        
            // Delay popup show
            setTimeout(() => {
                this.buildWheel();
                this.modal.show();
                srwc_frontend.form.backgroundEffects();

                setTimeout(() => {
                    this.modal.find('.srwc-wheel-container').addClass('slide-in');
                }, 50);
            }, delay * 1000);
        }

        closeWheel(e) {
            const settings = srwc_frontend?.settings || {};
        
            if (e.target.id === 'srwc-wheel-modal' || $(e.target).hasClass('srwc-close') || $(e.target).hasClass('srwc-close-btn') || $(e.target).closest('.srwc-close-btn').length) {
        
                if (this.autoHideTimer) {
                    clearTimeout(this.autoHideTimer);
                    this.autoHideTimer = null;
                }
        
                this.modal.find('.srwc-wheel-container').removeClass('slide-in').addClass('slide-out');
                
                srwc_frontend.form.removeBackgroundEffects();
        
                setTimeout(() => {
                    this.modal.hide();
                    this.modal.find('.srwc-wheel-container').removeClass('slide-out');
                    this.handleIconHide();
        
                    if (!this.hasSpin) {
                        let timeOnClose = parseInt(settings.time_on_close) || 0,
                            unit        = settings.time_on_close_unit || 'minutes',
                            multiplier  = 1000; 

                        if (unit === 'minutes') multiplier = 60 * 1000;
                        else if (unit === 'hours') multiplier = 60 * 60 * 1000;
                        else if (unit === 'days') multiplier = 24 * 60 * 60 * 1000;
        
                        if (timeOnClose > 0) {
                            setTimeout(() => {
                                this.openWheel({ preventDefault: () => {} });
                            }, timeOnClose * multiplier);
                        }
                    }
        
                    this.hasSpin = false;
                }, 800);
            }
        }
        
        spinWheel(e) {
            e.preventDefault();
            if (!this.wheelInner || !this.slides.length || !srwc_frontend.form.validateForm()) return;
        
            const settings      = srwc_frontend?.settings || {},
                  lastSpinKey   = 'srwc_last_spin_time',
                  now           = Date.now(),
                  lastSpin      = parseInt(localStorage.getItem(lastSpinKey)) || 0,
                  waitTime      = srwc_frontend.waitTime || 0;
        
            const customerEmail = $('.srwc-email').val().trim();
            if (customerEmail) {
                this.checkEmailLimit(customerEmail, () => {
                    this.proceedWithSpin(settings, lastSpinKey, now, lastSpin, waitTime);
                });
                return;
            }
        
            this.proceedWithSpin(settings, lastSpinKey, now, lastSpin, waitTime);
        }
        
        checkEmailLimit(email, callback) {
            $.ajax({
                type: 'POST',
                url: srwc_frontend.ajax_url,
                data: {
                    action: 'srwc_check_email_limit',
                    nonce: srwc_frontend.nonce,
                    customer_email: email
                },
                success: (response) => {
                    if (response.success) {
                        this.modal.find('.srwc-email-error').hide().text('');
                        if (typeof callback === 'function') callback();
                    } else { 
                        const settings = srwc_frontend?.settings || {},
                            spinLimit  = settings.spin_per_email;
                        let errorMessage = srwc_frontend.messages.spin_limit_exceeded;
                        errorMessage     = errorMessage.replace('{limit}', spinLimit);
                        this.modal.find('.srwc-email-error').text(errorMessage).show();
                    }
                }
            });
        }

        proceedWithSpin(settings, lastSpinKey, now, lastSpin, waitTime) { 
        
            if (waitTime > 0 && now - lastSpin < waitTime) {
                const remainingTime = waitTime - (now - lastSpin),
                    unit            = settings.time_spin_between_unit || 'hours';
                let remaining;
            
                switch (unit) {
                    case 'seconds':
                        remaining = Math.ceil(remainingTime / 1000);
                        break;
                    case 'minutes':
                        remaining = Math.ceil(remainingTime / (60 * 1000));
                        break;
                    case 'hours':
                        remaining = Math.ceil(remainingTime / (60 * 60 * 1000));
                        break;
                    case 'days':
                        remaining = Math.ceil(remainingTime / (24 * 60 * 60 * 1000));
                        break;
                    default:
                        remaining = Math.ceil(remainingTime / 1000);
                }
            
                const waitMsgTemplate = srwc_frontend.messages.wait_spin,
                    waitMessage       = waitMsgTemplate.replace('{time}', `${remaining} ${unit}`);
                this.modal.find('.srwc-email-error').text(waitMessage).show();
                return;
            }

            localStorage.setItem(lastSpinKey, now);
        
            const spinBtn     = this.modal.find('.srwc-spin-btn'),
                total         = this.slides.length,
                degreesPer    = 360 / total,
                speedMap      = { one: 1, two: 2, three: 3, four: 4, five: 5, six: 6, seven: 7, eight: 8 },
                speed         = speedMap[settings.wheel_speed_spin || 'three'] || 3,
                duration      = settings.wheel_time_duration || 4,
                selectedslide = this.slideProbability(),
                slideCenter   = (selectedslide * degreesPer) + (degreesPer / 2),
                rotateTo      = (360 * speed) + (360 - slideCenter);
        
            spinBtn.prop('disabled', true).html('<span class="srwc-loader"></span>');
        
            this.wheelInner.css({
                transition: `transform ${duration}s cubic-bezier(0.33,1,0.68,1)`,
                transform: `rotate(${rotateTo}deg)`
            });
        
            setTimeout(() => {
                // Use the selected slide directly since we calculated the rotation to point to it
                const chosen = this.slides[selectedslide],
                    label    = this.labelDisplay(chosen.label || '', chosen);
        
                if (['percent', 'fixed_product', 'fixed_cart'].includes(chosen.coupon_type)) {
                    this.generateCoupon(chosen, (success, updatedChosen) => {
                        if (success) {
                            srwc_frontend.form.showWinMessage(updatedChosen, label);
                            this.handleShowAgain(settings.show_again);
                        }
                    });
                } else {
                    this.recordLossSpin(chosen, label);
                    srwc_frontend.form.showWinMessage(chosen, label);
                    this.handleShowAgain(settings.show_again);
                }
            }, duration * 1000);
        }

        labelDisplay(label) {
            return label;
        }

        slideProbability() {
            const weightedslides = [];
            
            this.slides.forEach((slide, index) => {
                const probability = parseFloat(slide.probability) || 0;
                for (let i = 0; i < probability; i++) {
                    weightedslides.push(index);
                }
            });
            
            if (weightedslides.length === 0) {
                return Math.floor(Math.random() * this.slides.length);
            }
            
            const randomIndex = Math.floor(Math.random() * weightedslides.length);
            return weightedslides[randomIndex];
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
                    customer_mobile: $('.srwc-mobile').val(),
                    win_label: chosen.label || '',
                    value: chosen.value
                },
                success: (response) => {
                    if (response.success && response.data) {
                        chosen.generated_coupon = response.data.coupon_code;
                        if (typeof callback === 'function') callback(true, chosen);
                    } else {
                        this.modal.find('.srwc-email-error').text(srwc_frontend.messages.failed_generate_coupon || 'Failed to generate coupon.').show();
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
                    customer_mobile: $('.srwc-mobile').val(),
                }
            });
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

    }

    srwc_frontend.frontend = new SRWC_Frontend();
});