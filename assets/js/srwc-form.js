'use strict';

jQuery(function ($) {

    class SRWC_Form {

        validateForm() {
            const emailField = srwc_frontend.frontend.modal.find('.srwc-email'),
                nameField = srwc_frontend.frontend.modal.find('.srwc-name'),
                mobileField = srwc_frontend.frontend.modal.find('.srwc-mobile'),
                email = emailField.val().trim(),
                settings = srwc_frontend?.settings || {};

            srwc_frontend.frontend.modal.find('.srwc-error').hide().text('');

            // Name validation
            if (settings.user_name_require === 'yes' && nameField.length) {
                const name = nameField.val().trim();
                if (!name) {
                    nameField.next('.srwc-name-error').text(srwc_frontend.messages.name_required).show();
                    return false;
                }
            }

            if (typeof wp !== 'undefined' && wp.hooks) {
                const isValid = wp.hooks.applyFilters('srwcValidateMobile', true, mobileField, settings);
                if (!isValid) return false;
            }

            // Email required
            const isEmailRequired = settings.user_email_require !== 'no';

            if (isEmailRequired && !email) {
                emailField.next('.srwc-email-error').text(srwc_frontend.messages.email_required).show();
                return false;
            }

            const emailRegex = /^[^\s@]+@[a-zA-Z]+\.[A-Za-z]{2,}$/;
            if (email && !emailRegex.test(email)) {
                emailField.next('.srwc-email-error').text(srwc_frontend.messages.email_invalid).show();
                return false;
            }

            // GDPR validation
            const gdprCheckbox = srwc_frontend.frontend.modal.find('.srwc-gdpr-checkbox');
            const gdprRequired = settings.gdpr_required !== 'no';

            if (gdprCheckbox.length && gdprRequired && !gdprCheckbox.is(':checked')) {
                srwc_frontend.frontend.modal.find('.srwc-gdpr-error').text(srwc_frontend.messages.gdpr_required).show();
                return false;
            }

            return true;
        }

        autoHideWheel(settings) {
            const autoHideDelay = parseInt(settings.auto_hide_wheel) || 0;

            if (autoHideDelay > 0) {
                if (this.autoHideTimer) {
                    clearTimeout(this.autoHideTimer);
                }

                this.autoHideTimer = setTimeout(() => {
                    srwc_frontend.frontend.closeWheel({ target: { id: 'srwc-wheel-modal' } });
                }, autoHideDelay * 1000);
            }
        }

        recordLossSpin(chosen, label) {
            const countryCode = $('#srwc_country_code option:selected').data('phone-code') || '',
                phoneNumber = $('.srwc-mobile').val() || '',
                fullMobile = countryCode && phoneNumber ? countryCode + ' ' + phoneNumber : phoneNumber;

            $.ajax({
                type: 'POST',
                url: srwc_frontend.ajax_url,
                data: {
                    action: 'srwc_record_loss_spin',
                    nonce: srwc_frontend.nonce,
                    customer_email: $('.srwc-email').val(),
                    customer_name: $('.srwc-name').val(),
                    customer_mobile: fullMobile,
                    country_code: countryCode,
                }
            });
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
                        srwc_frontend.frontend.modal.find('.srwc-email-error').hide().text('');
                        if (typeof callback === 'function') callback();
                    } else {
                        const errorMessage = srwc_frontend.messages.spin_limit_exceeded;
                        srwc_frontend.frontend.modal.find('.srwc-email-error').text(errorMessage).show();
                    }
                }
            });
        }

        slideProbability() {
            const weightedslides = [];

            srwc_frontend.frontend.slides.forEach((slide, index) => {
                const probability = parseFloat(slide.probability) || 0;
                for (let i = 0; i < probability; i++) {
                    weightedslides.push(index);
                }
            });

            if (weightedslides.length === 0) {
                return Math.floor(Math.random() * srwc_frontend.frontend.slides.length);
            }

            const randomIndex = Math.floor(Math.random() * weightedslides.length);
            return weightedslides[randomIndex];
        }

        backgroundEffects() {
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcBackgroundEffects');
            }
        }

        removeBackgroundEffects() {
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcRemoveBackgroundEffects');
            }
        }

        showFireworkAnimation() {
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcFireworkAnimation');
            }
        }

        klaviyoSubscribe() {
            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcKlaviyoSubscribe');
            }
        }

        mailchimpSubscribe() {
            try {
                const email = $('.srwc-email').val().trim(),
                    name = $('.srwc-name').val().trim(),
                    countryCode = $('#srwc_country_code option:selected').data('phone-code') || '',
                    phoneNumber = $('.srwc-mobile').val() || '';

                if (email) {
                    $.ajax({
                        type: 'POST',
                        url: srwc_frontend.ajax_url,
                        data: {
                            action: 'srwc_mailchimp_subscribe',
                            nonce: srwc_frontend.nonce,
                            email: email,
                            name: name,
                            country_code: countryCode,
                            mobile: phoneNumber
                        }
                    });
                }
            } catch (e) { }
        }

    }

    srwc_frontend.form = new SRWC_Form();
});