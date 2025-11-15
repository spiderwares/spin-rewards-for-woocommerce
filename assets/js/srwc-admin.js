'use strict ';

jQuery(function($) {
    class SRWC_Admin {

        constructor() {
            this.init();
        }

        init() {
            this.initEvent();
            this.initSelect2();
            this.initColorPickers();
            this.bindEvents();
        }

        bindEvents() {
            $(document.body).on( 'click', '.srwc-add-repeater-row', this.addRepeaterRow.bind(this) );
            $(document.body).on( 'click', '.srwc-remove-repeater-row', this.removeRepeaterRow.bind(this) );
            $(document.body).on( 'change', '.srwc-switch-field input[type="checkbox"], select', this.toggleVisibility.bind(this) );
            $(document.body).on( 'click', '.srwc-media-upload', this.openMediaUploader.bind(this) );
            $(document.body).on( 'click', '.srwc-media-remove', this.removeMedia.bind(this) );
            $(document.body).on( 'change', '.srwc-coupon-type', this.toggleCouponSelect.bind(this) );
            $(document.body).on( 'change', '.srwc-coupon-select', this.loadCouponOptions.bind(this) );
			$(document.body).on( 'click', '#srwc-export-emails', this.exportEmails.bind(this) );
			$(document.body).on( 'click', '.srwc-preview-wheel', this.renderAdminPreview.bind(this) );
			$(document.body).on( 'click', '.srwc-preview-close', this.closeAdminPreview.bind(this) );
			$(document.body).on( 'submit', '.srwc-settings-form', this.totalProbability.bind(this));
        }

        initEvent() {
            $('.srwc-repeater-body').sortable({ 
                items: 'tr:not(.srwc-repeater-template)',
                update: function(event, ui) {
                    // Update index numbers after sorting
                    const table = ui.item.closest('table'),
                        admin   = new SRWC_Admin();
                    admin.updateIndexNumbers(table);
                }
            });
        }

        updateIndexNumbers(table) {
            const tbody = table.find('tbody');
            tbody.find('tr.srwc-slide-row').each(function(index) {
                $(this).find('.srwc-slide-index').text(index + 1);
            });
        }

		renderAdminPreview() {
			const slides = [];
			$('.srwc-slide-row').each(function() {
				const row       = $(this),
					label       = row.find('.srwc-slide-label').val() || 'Label',
					value       = parseFloat(row.find('.srwc-slide-value').val()) || 0,
					probability = parseFloat(row.find('.srwc-slide-probability').val()) || 0,
					color       = row.find('.srwc-slide-color').val() || '#ffcc80',
					couponType  = row.find('.srwc-coupon-type').val() || 'none';
				
				let processedLabel = label;

                if (!['none'].includes(couponType) && value > 0) {
                    const displayCurrency = srwc_admin?.settings?.display_currency,

                        formattedValue    = couponType === 'percent' ? `${value}%` :
                        ['existing', 'fixed_cart', 'fixed_product'].includes(couponType)
                            ? (displayCurrency === 'currency_code'
                                ? `${(srwc_admin?.currency_code || 'USD')} ${value.toFixed(2)}`
                                : `${(srwc_admin?.currency_symbol || '$')}${value.toFixed(2)}`)
                            : value.toString();

                    processedLabel = label.replace(/{coupon_amount}/g, formattedValue);
                }

				slides.push({ label: processedLabel, value, probability: probability, color });
			});

			if (!slides.length) return;

			const canvas = document.getElementById('srwc-admin-wheel-canvas');
			if (!canvas) return;
			const ctx  = canvas.getContext('2d'),
			    cx     = canvas.width / 2,
			    cy     = canvas.height / 2,
			    radius = Math.min(cx, cy) - 10;
			ctx.clearRect(0, 0, canvas.width, canvas.height);

			const total     = slides.length,
			    anglePer    = (Math.PI * 2) / total,
                settings    = srwc_admin?.settings || {},
                borderColor = settings.wheel_border_color || '#d6d6d6',
                dotColor    = settings.wheel_dot_color || '#000000',
                centerColor = settings.wheel_center_color || '#ffffff';

			slides.forEach((s, idx) => {
				const start = idx * anglePer,
					end     = start + anglePer;
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, radius, start, end);
				ctx.closePath();
				ctx.fillStyle = s.color || '#ffcc80';
				ctx.fill();

				// Text
				ctx.save();
				ctx.translate(cx, cy);
				ctx.rotate(start + anglePer / 2);
				ctx.textAlign = 'right';
				ctx.fillStyle = '#fff';
				ctx.font = '16px Arial';
				ctx.fillText(s.label || '', radius - 12, 4);
				ctx.restore();
			});

            ctx.beginPath();
            ctx.arc(cx, cy, radius + 5, 0, Math.PI * 2);
            ctx.lineWidth = 10;
            ctx.strokeStyle = borderColor;
            ctx.stroke();

            slides.forEach((s, idx) => {
                const start = idx * anglePer,
                    dotX = cx + Math.cos(start) * (radius + 5),
                    dotY = cy + Math.sin(start) * (radius + 5);
                
                ctx.beginPath();
                ctx.arc(dotX, dotY, 5, 0, 2 * Math.PI);
                ctx.fillStyle = dotColor;
                ctx.fill();
            });

			// Center circle
			ctx.beginPath();
			ctx.arc(cx, cy, 50, 0, Math.PI * 2);
			ctx.fillStyle = centerColor;
			ctx.fill();
            ctx.lineWidth = 1;
			ctx.strokeStyle = centerColor;
			ctx.stroke();

			// Show the preview
			$('.srwc-admin-preview').addClass('show');
		}

		closeAdminPreview() {
			$('.srwc-admin-preview').removeClass('show');
		}

		totalProbability(e) {
			const slidesTable = $('.srwc-slides-table:visible');
			if (!slidesTable.length) return;

			let total = 0;
			slidesTable.find('.srwc-slide-row .srwc-slide-probability').each(function() {
				total += parseFloat($(this).val()) || 0;
			});

			if (total !== 100) {
				e.preventDefault();
				alert(srwc_admin.messages.probability_error + total + '%');
			}
        }

        addRepeaterRow(e) {
            e.preventDefault();
        
            const table        = $(e.currentTarget).closest('table'),
                  tbody        = table.find('tbody'),
                  template     = table.find('.srwc-repeater-template').clone(),
                  existingRows = tbody.find('tr.srwc-slide-row').length,
                  slideLimit   = (typeof window.srwc_slide_limit !== "undefined");
        
            if (!slideLimit && existingRows >= 6) {
                alert(srwc_admin.messages.max_slides);
                return false;
            }
        
            template
                .removeClass('srwc-repeater-template')
                .addClass('srwc-slide-row')
                .show();
        
            tbody.append(template);
        
            this.updateIndexNumbers(table);
            this.initColorPickers();
        }

        removeRepeaterRow(e) {
            e.preventDefault();
        
            const table         = $(e.currentTarget).closest('table'),
                  tbody         = table.find('tbody'),
                  existingRows  = tbody.find('tr.srwc-slide-row').length;
        
            if (existingRows <= 3) {
                alert(srwc_admin.messages.min_slides);
                return false;
            }
        
            $(e.currentTarget).closest('tr').remove();
            this.updateIndexNumbers(table);
        }

        initSelect2() {
            $('.srwc-select2').each(function() {
                const __this = $(this);
                
                if (__this.is(':visible')) {
                    let width = '380px';
                    
                    if (__this.closest('.srwc-slides-table').length) {
                        width = '250px';
                    }
                    else {
                        width = '380px';
                    }
                    
                    __this.select2({
                        width: width,
                        placeholder: __this.data('placeholder') || '',
                        allowClear: __this.hasClass('srwc-coupon-select') || !!__this.data('placeholder')
                    });
                }

            });
        }

        toggleVisibility(e) {
            var __this = $(e.currentTarget);

            if (__this.is('select')) {
                var target      = __this.find(':selected').data('show'),
                    hideElement = __this.data('hide');
                    $(document.body).find(hideElement).hide();
                    $(document.body).find(target).show();
            } else {
                var target      = __this.data('show');
                $(document.body).find(target).toggle();
            }
        }

        initColorPickers() {
            if ($.fn.wpColorPicker) {
                $('.wp-color-picker').wpColorPicker();
            }
        }

        openMediaUploader(e) {
            e.preventDefault();

            const __this    = $(e.currentTarget).closest('.srwc-media'),
                media       = __this.find('.srwc-media-url'),
                preview     = __this.find('.srwc-media-preview'),
                frame       = wp.media({ 
                title: 'Select Image', 
                multiple: false, 
                library: { type: 'image' } 
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                media.val(attachment.url);
                const imgStyle = preview.data('img-style') || '';
                preview.html('<img src="' + attachment.url + '" alt="Preview" style="' + imgStyle + '" />');
                __this.find('.srwc-media-remove').show();
            });

            frame.open();
        }
        
        removeMedia(e) {
            e.preventDefault();

            const __this = $(e.currentTarget).closest('.srwc-media');
            __this.find('.srwc-media-url').val('');
            __this.find('.srwc-media-preview').html('');
            __this.find('.srwc-media-remove').hide();
        }

        toggleCouponSelect(e) {
            const __this = $(e.currentTarget).val(),
                row      = $(e.currentTarget).closest('.srwc-slide-row'),
                value    = row.find('.srwc-slide-value').hide(),
                coupon   = row.find('.srwc-coupon-select').hide();
        
            coupon.next('.select2-container').hide();
        
             if (__this === 'existing') {
                coupon.show().next('.select2-container').show();
                this.loadCouponOptions({ currentTarget: coupon[0] });
            } else {
                value.show();
            }

            this.initSelect2();
        }
        
        loadCouponOptions(e) {
            const __this = $(e.currentTarget);

            if (__this.val()) {
                return;
            }

            $.ajax({
                type: 'POST',
                url: srwc_admin.ajax_url,
                data: {
                    action: 'srwc_get_coupons',
                    nonce: srwc_admin.nonce
                },
                success: function(response) {
                    if (response.success && response.data) {
                        let options = '<option value="">Enter Code</option>';
                        response.data.forEach(function(coupon) {
                            options += '<option value="' + coupon.code.toUpperCase() + '">' + coupon.code.toUpperCase() + '</option>';
                        });
                        __this.html(options);
                        
                        __this.select2({
                            width: '100%',
                            placeholder: __this.data('placeholder') || 'Enter Code',
                            allowClear: true
                        });
                        
                        __this.next('.select2-container').show();
                    } else {
                        __this.html('<option value="">No coupons found</option>');
                    }
                }
            });
        }

        exportEmails() {
            // Export emails
            const fromDate = $('#srwc-from-date').val(),
                toDate     = $('#srwc-to-date').val(),
    
                form = $('<form>', {
                method: 'POST',
                action: srwc_admin.ajax_url
            });
    
            form.append($('<input>', { type: 'hidden', name: 'action', value: 'srwc_export_emails' }));
            form.append($('<input>', { type: 'hidden', name: 'nonce', value: srwc_admin.nonce }));
    
            if (fromDate) {
                form.append($('<input>', { type: 'hidden', name: 'from_date', value: fromDate }));
            }
    
            if (toDate) {
                form.append($('<input>', { type: 'hidden', name: 'to_date', value: toDate }));
            }
    
            $('body').append(form);
            form.submit();
            form.remove();
        }
        
    }

    new SRWC_Admin();
});
