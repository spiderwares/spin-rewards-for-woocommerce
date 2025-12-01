'use strict ';

jQuery(function ($) {
    class SRWC_Frontend {

        constructor() {
            this.init();
        }

        init() {
            this.slides = [];
            this.modal = $('.srwc-wheel-modal');
            this.wheelInner = null;
            this.floatingBtn = $('.srwc-floating-btn');
            this.miniWheelInner = $('.srwc-mini-wheel-inner');
            this.afterspin = 'srwc_show_again_until';
            this.afterclose = 'srwc_close_until';
            this.cookieName = 'srwc_cookie';
            this.loadslides();
            this.bindEvents();
            this.floatingButton();
            this.popupTrigger();
            this.buildMiniWheel();

            window.srwcFrontendInstance = this;
        }

        /**
         * Get cookie value by name
         */
        getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) {
                return parts.pop().split(';').shift();
            }
            return null;
        }

        /**
         * Set cookie with name, value and expiry days
         */
        setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = `expires=${date.toUTCString()}`;
            document.cookie = `${name}=${value};${expires};path=/`;
        }

        bindEvents() {
            $(document.body).on('click', '.srwc-open-wheel, .srwc-floating-btn', this.openWheel.bind(this));
            $(document.body).on('click', '.srwc-close, .srwc-close-btn, .srwc-wheel-modal', this.closeWheel.bind(this));
            $(document.body).on('click', '.srwc-spin-btn', this.spinWheel.bind(this));
            $(document.body).on('click', '.srwc-option-link', this.handleNotDisplayOption.bind(this));
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
            const settings = srwc_frontend?.settings || {},
                trigger = settings.popup_trigger || 'show_wheel',
                initialDelay = parseFloat(settings.initial_delay) || 0;

            switch (trigger) {
                case 'popup_icon':
                    break;

                case 'show_wheel':
                    setTimeout(() => {
                        this.openWheel({ preventDefault: () => { } });
                    }, initialDelay * 1000);
                    break;
            }
        }

        buildWheel() {
            const canvas = document.getElementById('srwc_wheel_canvas'),
                settings = srwc_frontend?.settings || {};

            // Default base values
            let baseSize = 550,
                wheelSize = 100,
                fontSize = 20,
                textColor = "#fff",
                borderColor = '#d6d6d6',
                dotColor = '#000000',
                fontFamily = "Poppins";

            // Allow external filter hook
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction(
                    'srwcSpinWhel',
                    {
                        settings,
                        defaultPercent: wheelSize,
                        defaultSize: fontSize,
                        defaultColor: textColor,
                        defaultFontFamily: fontFamily,
                        defaultBorderColor: borderColor,
                        defaultDotColor: dotColor,
                    },
                    (data) => {
                        if (data) {
                            fontSize = parseInt(data.fontSize) || fontSize;
                            textColor = data.color || textColor;
                            fontFamily = data.fontFamily || fontFamily;
                            wheelSize = parseInt(data.wheelSize) || wheelSize;
                            borderColor = data.borderColor || borderColor;
                            dotColor = data.dotColor || dotColor;
                        }
                    }
                );
            }

            // Calculate scale
            const scale = wheelSize / 100,
                finalSize = baseSize * scale,
                dpr = window.devicePixelRatio || 1;
            canvas.width = finalSize * dpr;
            canvas.height = finalSize * dpr;

            const ctx = canvas.getContext('2d');
            ctx.scale(dpr, dpr);

            this.wheelInner = this.modal.find('.srwc-wheel-inner');
            this.wheelInner.empty().append(canvas);

            const total = this.slides.length,
                centerX = finalSize / 2,
                centerY = finalSize / 2,
                radius = (finalSize / 2) - (25 * scale),
                textRadius = radius - (80 * scale),
                centerColor = settings.wheel_center_color || '#ffffff';

            // === Draw slides ===
            for (let i = 0; i < total; i++) {
                const startAngle = (i * 2 * Math.PI) / total,
                    endAngle = ((i + 1) * 2 * Math.PI) / total;

                // Slice background
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius - (4 * scale), startAngle, endAngle);
                ctx.closePath();
                ctx.fillStyle = this.slides[i].color || this.randomColor();
                ctx.fill();

                // Draw text
                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(startAngle + (endAngle - startAngle) / 2);
                ctx.textAlign = "center";
                ctx.fillStyle = textColor;

                const dynamicFontSize = Math.max((fontSize * scale), 6);
                ctx.font = `${dynamicFontSize}px ${fontFamily}`;

                let label = this.slides[i].label || '';
                ctx.fillText(label, textRadius, 5);
                ctx.restore();
            }

            // === Border ===
            const borderOffset = 5 * scale;
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius + borderOffset, 0, Math.PI * 2);
            ctx.lineWidth = 18 * scale;
            ctx.strokeStyle = borderColor;
            ctx.stroke();

            // === Dots ===
            const dotOffset = 5 * scale,
                dotBaseSize = Math.max(finalSize * 0.011 * scale, 0.8);
            this.slides.forEach((s, idx) => {
                const start = (idx * 2 * Math.PI) / total,
                    dotX = centerX + Math.cos(start) * (radius + dotOffset),
                    dotY = centerY + Math.sin(start) * (radius + dotOffset);

                ctx.beginPath();
                ctx.arc(dotX, dotY, dotBaseSize, 0, 2 * Math.PI);
                ctx.fillStyle = dotColor;
                ctx.fill();
            });

            // === Center Circle ===
            ctx.save();
            const centerRadius = Math.max(50 * scale, 4);
            ctx.beginPath();
            ctx.arc(centerX, centerY, centerRadius, 0, Math.PI * 2);

            ctx.shadowColor = 'rgba(0, 0, 0, 0.25)';
            ctx.shadowBlur = 10 * scale;
            ctx.fillStyle = centerColor;
            ctx.fill();

            ctx.shadowColor = 'transparent';
            ctx.shadowBlur = 0;
            ctx.strokeStyle = centerColor;
            ctx.lineWidth = 1;
            ctx.stroke();
            ctx.restore();
        }

        buildMiniWheel() {
            if (!this.miniWheelInner || !this.miniWheelInner.length) return;
            if (!this.slides || !this.slides.length) return;

            // Get the existing canvas by ID
            const miniCanvas = document.getElementById('srwc-mini-wheel-canvas');
            if (!miniCanvas) return;

            const settings = srwc_frontend?.settings || {},
                borderColor = settings.wheel_border_color || '#d32f2f',
                centerColor = settings.wheel_center_color || '#ffffff',
                dotColor = settings.wheel_dot_color || '#000000',
                ctx = miniCanvas.getContext('2d'),
                size = miniCanvas.width,
                total = this.slides.length,
                centerX = size / 2,
                centerY = size / 2,
                radius = (size / 2) - 6,
                anglePer = (Math.PI * 2) / total;

            for (let i = 0; i < total; i++) {
                const start = i * anglePer,
                    end = start + anglePer;
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, start, end);
                ctx.closePath();
                ctx.fillStyle = this.slides[i].color || '#ffcc80';
                ctx.fill();
            }

            // Outer border
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius + 2, 0, Math.PI * 2);
            ctx.lineWidth = 5;
            ctx.strokeStyle = borderColor;
            ctx.stroke();

            this.slides.forEach((s, idx) => {
                const start = (idx * 2 * Math.PI) / total,
                    dotX = centerX + Math.cos(start) * (radius + 3),
                    dotY = centerY + Math.sin(start) * (radius + 3);

                ctx.beginPath();
                ctx.arc(dotX, dotY, 2, 0, 2 * Math.PI);
                ctx.fillStyle = dotColor;
                ctx.fill();
            });

            // Center circle
            ctx.beginPath();
            ctx.arc(centerX, centerY, 8, 0, Math.PI * 2);
            ctx.fillStyle = centerColor;
            ctx.fill();
        }

        openWheel(e) {
            e.preventDefault();

            // Check cookie first - if exists, don't show popup
            const cookieValue = this.getCookie(this.cookieName);
            if (cookieValue) {
                this.floatingBtn.toggleClass('srwc-hidden', true);
                localStorage.setItem('srwc_icon_hidden', 'true');
                return;
            }

            let delay = 0;

            const settings = srwc_frontend?.settings || {},
                showAgain = parseInt(settings.show_again, 10) || 0,
                timeOnClose = parseInt(settings.time_on_close, 10) || 0;

            let spinagain = 0, closeagain = 0;

            if (showAgain > 0) {
                spinagain = +localStorage.getItem(this.afterspin) || 0;
            } else {
                localStorage.removeItem(this.afterspin);
            }

            if (timeOnClose > 0) {
                closeagain = +localStorage.getItem(this.afterclose) || 0;
            } else {
                localStorage.removeItem(this.afterclose);
            }

            const nextAllowed = Math.max(spinagain, closeagain);

            if (Date.now() < nextAllowed) {
                const delay = nextAllowed - Date.now();
                this.floatingBtn.toggleClass('srwc-hidden', true);
                localStorage.setItem('srwc_icon_hidden', 'true');

                setTimeout(() => {
                    this.floatingBtn.toggleClass('srwc-hidden', false);
                    localStorage.setItem('srwc_icon_hidden', 'false');
                }, delay);
                return;
            }

            if (settings.initial_delay) {
                delay = parseFloat(settings.initial_delay) || 0;
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
            const settings = srwc_frontend?.settings || {},
                target = $(e.target);

            if (
                e.target.id === 'srwc-wheel-modal' ||
                target.hasClass('srwc-close') ||
                target.hasClass('srwc-close-btn') ||
                target.closest('.srwc-close-btn').length
            ) {
                this.performWheelClose(settings);
            }
        }

        handleNotDisplayOption(e) {
            e.preventDefault();
            const target = $(e.currentTarget),
                option = target.data('option'),
                settings = srwc_frontend?.settings || {};

            if (!option) {
                this.performWheelClose(settings);
                return;
            }

            // Handle different options with cookies
            switch (option) {
                case 'never':
                    // Set cookie "never_show_again" with 30 days expiry
                    this.setCookie(this.cookieName, 'never_show_again', 30);
                    this.floatingBtn.addClass('srwc-hidden');
                    localStorage.setItem('srwc_icon_hidden', 'true');
                    this.performWheelClose(settings, false);
                    break;

                case 'remind_later':
                    // Set cookie "reminder_later" with 1 day expiry
                    this.setCookie(this.cookieName, 'reminder_later', 1);
                    this.floatingBtn.addClass('srwc-hidden');
                    localStorage.setItem('srwc_icon_hidden', 'true');
                    this.performWheelClose(settings, false);
                    break;

                case 'no_thanks':
                    // Set cookie "closed" with expiry from time_on_close setting
                    let timeOnClose = parseInt(settings.time_on_close, 10) || 1,
                        unit = (settings.time_on_close_unit || 'days').toLowerCase(),
                        days = 1; // Default to 1 day

                    // Convert to days
                    if (unit === 'minutes') days = timeOnClose / (24 * 60);
                    else if (unit === 'hours') days = timeOnClose / 24;
                    else if (unit === 'days') days = timeOnClose;

                    // Minimum 1 day
                    days = Math.max(days, 1);

                    this.setCookie(this.cookieName, 'closed', days);
                    this.floatingBtn.addClass('srwc-hidden');
                    localStorage.setItem('srwc_icon_hidden', 'true');
                    this.performWheelClose(settings, false);
                    break;

                default:
                    this.performWheelClose(settings);
            }
        }

        performWheelClose(settings) {
            this.modal.find('.srwc-wheel-container').removeClass('slide-in').addClass('slide-out');
            srwc_frontend.form.removeBackgroundEffects();

            setTimeout(() => {
                this.modal.hide();
                this.modal.find('.srwc-wheel-container').removeClass('slide-out');
                this.handleIconHide();

                if (!this.hasSpin) {
                    let timeOnClose = parseInt(settings.time_on_close, 10),
                        unit = (settings.time_on_close_unit || 'minutes').toLowerCase(),
                        multiplier = 1000;

                    if (unit === 'minutes') multiplier = 60 * 1000;
                    else if (unit === 'hours') multiplier = 60 * 60 * 1000;
                    else if (unit === 'days') multiplier = 24 * 60 * 60 * 1000;

                    if (Number.isFinite(timeOnClose) && timeOnClose > 0) {
                        const until = Date.now() + (timeOnClose * multiplier);
                        localStorage.setItem(this.afterclose, String(until));
                        localStorage.setItem('srwc_icon_hidden', 'true');
                        this.floatingBtn.addClass('srwc-hidden');

                        setTimeout(() => {
                            this.floatingBtn.removeClass('srwc-hidden');
                            localStorage.setItem('srwc_icon_hidden', 'false');
                            this.openWheel({ preventDefault: () => { } });
                        }, timeOnClose * multiplier);
                    }
                }

                this.hasSpin = false;
            }, 800);
        }

        spinWheel(e) {
            e.preventDefault();
            if (!this.wheelInner || !this.slides.length || !srwc_frontend.form.validateForm()) return;

            const settings = srwc_frontend?.settings || {},
                lastSpinKey = 'srwc_last_spin_time',
                now = Date.now(),
                lastSpin = parseInt(localStorage.getItem(lastSpinKey)) || 0,
                waitTime = srwc_frontend.waitTime || 0;

            const customerEmail = $('.srwc-email').val().trim();
            if (customerEmail) {
                srwc_frontend.form.checkEmailLimit(customerEmail, () => {
                    this.proceedWithSpin(settings, lastSpinKey, now, lastSpin, waitTime);
                });
                return;
            }

            this.proceedWithSpin(settings, lastSpinKey, now, lastSpin, waitTime);
        }

        proceedWithSpin(settings, lastSpinKey, now, lastSpin, waitTime) {

            if (waitTime > 0 && now - lastSpin < waitTime) {
                const remainingTime = waitTime - (now - lastSpin),
                    unit = settings.time_spin_between_unit || 'hours';
                let remaining;

                switch (unit) {
                    case 'seconds': remaining = Math.ceil(remainingTime / 1000); break;
                    case 'minutes': remaining = Math.ceil(remainingTime / (60 * 1000)); break;
                    case 'hours': remaining = Math.ceil(remainingTime / (60 * 60 * 1000)); break;
                    case 'days': remaining = Math.ceil(remainingTime / (24 * 60 * 60 * 1000)); break;
                    default: remaining = Math.ceil(remainingTime / 1000);
                }

                const waitMsgTemplate = srwc_frontend.messages.wait_spin,
                    waitMessage = waitMsgTemplate.replace('{time}', `${remaining} ${unit}`);
                this.modal.find('.srwc-email-error').text(waitMessage).show();
                return;
            }

            localStorage.setItem(lastSpinKey, now);

            srwc_frontend.form.klaviyoSubscribe();
            srwc_frontend.form.mailchimpSubscribe();


            const spinBtn = this.modal.find('.srwc-spin-btn'),
                total = this.slides.length,
                degreesPer = 360 / total,
                speedMap = { one: 1, two: 2, three: 3, four: 4, five: 5, six: 6, seven: 7, eight: 8, nine: 9, ten: 10 },
                speed = speedMap[settings.wheel_speed_spin || 'three'] || 3,
                duration = settings.wheel_time_duration || 4,
                selectedslide = srwc_frontend.form.slideProbability(),
                slideCenter = (selectedslide * degreesPer) + (degreesPer / 2);

            let pointerAngle = 0;

            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcWheelPointer', { settings, selected: selectedslide, slideCenter: slideCenter }, (data) => {
                    pointerAngle = parseInt(data.pointerAngle) || 0;
                });
            }

            const rotateTo = (360 * speed) + (360 - slideCenter) - pointerAngle,
                loader = $('.srwc-loader:first').clone().removeAttr('style').show();
            spinBtn.prop('disabled', true).html(loader);


            this.wheelInner.css({
                transition: `transform ${duration}s cubic-bezier(0.33,1,0.68,1)`,
                transform: `rotate(${rotateTo}deg)`
            });

            setTimeout(() => {
                const chosen = this.slides[selectedslide],
                    label = this.labelDisplay(chosen.label || '', chosen);

                if (['existing', 'percent', 'fixed_product', 'fixed_cart'].includes(chosen.coupon_type)) {
                    this.generateCoupon(chosen, (success, updatedChosen) => {
                        if (success) {
                            this.showWinMessage(updatedChosen, label);
                            this.handleShowAgain(settings.show_again, settings.show_again_unit);
                        }
                    });
                } else {
                    srwc_frontend.form.recordLossSpin(chosen, label);
                    this.showWinMessage(chosen, label);
                    this.handleShowAgain(settings.show_again, settings.show_again_unit);
                }
            }, duration * 1000);
        }

        labelDisplay(label) {
            return label;
        }

        showWinMessage(chosen, label) {

            const settings = srwc_frontend?.settings || {},
                isWin = chosen.coupon_type !== 'none';

            let message;
            if (isWin) {
                message = settings.win_message
                    .replace('{coupon_label}', label ? '<b>' + label + '</b>' : '')
                    .replace('{checkout}', '<a href="' + srwc_frontend.checkout_url + '">checkout</a>');

                srwc_frontend.form.showFireworkAnimation();
            } else {
                message = settings.lose_message;
            }

            this.modal.find('.srwc-form-controls').hide();
            this.modal.find('.srwc-win-text').html(message);
            this.modal.find('.srwc-win-message').show();

            srwc_frontend.form.autoHideWheel(settings);

            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcApplyCoupon', chosen, label, this);
            }

        }

        handleShowAgain(delay, unit) {
            delay = parseInt(delay) || 0;
            if (delay <= 0) return;

            // Determine multiplier; default to minutes if unit missing
            let multiplier = 1000;
            if (unit === 'seconds') multiplier = 1000;
            else if (unit === 'minutes' || !unit) multiplier = 60 * 1000;
            else if (unit === 'hours') multiplier = 60 * 60 * 1000;
            else if (unit === 'days') multiplier = 24 * 60 * 60 * 1000;

            const until = Date.now() + (delay * multiplier);
            localStorage.setItem(this.afterspin, String(until));
            localStorage.setItem('srwc_icon_hidden', 'true');
            this.floatingBtn.addClass('srwc-hidden');

            setTimeout(() => {
                this.floatingBtn.removeClass('srwc-hidden');
                localStorage.setItem('srwc_icon_hidden', 'false');
            }, delay * multiplier);
        }

        generateCoupon(chosen, callback) {
            const countryCode = $('#srwc_country_code option:selected').data('phone-code') || '',
                phoneNumber = $('.srwc-mobile').val() || '',
                fullMobile = countryCode && phoneNumber ? countryCode + ' ' + phoneNumber : phoneNumber;

            $.ajax({
                type: 'POST',
                url: srwc_frontend.ajax_url,
                data: {
                    action: 'srwc_generate_coupon',
                    nonce: srwc_frontend.nonce,
                    coupon_type: chosen.coupon_type,
                    coupon_code: chosen.coupon_code || '',
                    customer_email: $('.srwc-email').val(),
                    customer_name: $('.srwc-name').val(),
                    customer_mobile: fullMobile,
                    country_code: countryCode,
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