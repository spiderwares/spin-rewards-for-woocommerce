'use strict';

jQuery(function($) {

    class SRWC_Form {

        validateForm() {
            const emailField = srwc_frontend.frontend.modal.find('.srwc-email'),
                nameField    = srwc_frontend.frontend.modal.find('.srwc-name'),
                mobileField  = srwc_frontend.frontend.modal.find('.srwc-mobile'),
                email        = emailField.val().trim(),
                settings     = srwc_frontend?.settings || {};
        
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
                const isValid = wp.hooks.applyFilters('srwcValidateMobile', true, mobileField, settings, srwc_frontend);
                if (!isValid) return false;
            }
        
            // Email required
            if (!email) {
                emailField.next('.srwc-email-error').text(srwc_frontend.messages.email_required).show();
                return false;
            }
        
            const emailRegex = /^[^\s@]+@[a-zA-Z]+\.[A-Za-z]{2,}$/;
            if (!emailRegex.test(email)) {
                emailField.next('.srwc-email-error').text(srwc_frontend.messages.email_invalid).show();
                return false;
            }

            // GDPR validation
            const gdprCheckbox = srwc_frontend.frontend.modal.find('.srwc-gdpr-checkbox');
            if (gdprCheckbox.length && !gdprCheckbox.is(':checked')) {
                srwc_frontend.frontend.modal.find('.srwc-gdpr-error').text(srwc_frontend.messages.gdpr_required).show();
                return false;
            }
            
            return true;
        }

        showWinMessage(chosen, label) {
            const settings = srwc_frontend?.settings || {},
                isWin      = chosen.coupon_type !== 'none';
            
            let message;
            if (isWin) {
                message = settings.win_message
                    .replace('{coupon_label}', label ? '<b>' + label + '</b>' : '')
                    .replace('{checkout}', '<a href="' + srwc_frontend.checkout_url + '">checkout</a>');
                
                // Show firework animation for wins
                this.showFireworkAnimation();
            } else {
                message = settings.lose_message;
            }
            
            // Hide the form and show message
            srwc_frontend.frontend.modal.find('.srwc-form-controls').hide();
            srwc_frontend.frontend.modal.find('.srwc-win-text').html(message);
            srwc_frontend.frontend.modal.find('.srwc-win-message').show();
            
            this.autoHideWheel(settings);

            if (typeof wp !== 'undefined' && wp.hooks) {
                wp.hooks.doAction('srwcShowWinMessage', chosen, label, this);
            }
            
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
    }

    srwc_frontend.form = new SRWC_Form();
});