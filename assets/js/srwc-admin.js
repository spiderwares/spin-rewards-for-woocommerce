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
            this.initReports();
        }

        bindEvents() {
            $(document.body).on( 'click', '.srwc-add-repeater-row', this.addRepeaterRow.bind(this) );
            $(document.body).on( 'click', '.srwc-remove-repeater-row', this.removeRepeaterRow.bind(this) );
            $(document.body).on( 'change', '.srwc-switch-field input[type="checkbox"], select', this.toggleVisibility.bind(this) );
            $(document.body).on( 'click', '.srwc-media-upload', this.openMediaUploader.bind(this) );
            $(document.body).on( 'click', '.srwc-media-remove', this.removeMedia.bind(this) );
            $(document.body).on( 'change', '.srwc-coupon-type', this.toggleCouponSelect.bind(this) );
            $(document.body).on( 'change', '.srwc-coupon-select', this.loadCouponOptions.bind(this) );
        }

        initEvent() {
            $('.srwc-repeater-body').sortable({ 
                items: 'tr:not(.srwc-repeater-template)',
                update: function(event, ui) {
                    // Update index numbers after sorting
                    const table = ui.item.closest('table'),
                        admin = new SRWC_Admin();
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

        addRepeaterRow(e) {
            e.preventDefault();
            const table     = $(e.currentTarget).closest('table'),
                tbody       = table.find('tbody'),
                template    = table.find('.srwc-repeater-template').clone(),
                existingRows = tbody.find('tr.srwc-slide-row').length;

            // Restrict to 6 slides
            if (existingRows >= 6) {
                alert(srwc_admin.messages.max_slides);
                return false;
            }

            template.removeClass('srwc-repeater-template').addClass('srwc-slide-row').show();
            tbody.append(template);
            
            this.updateIndexNumbers(table);
        }

        removeRepeaterRow(e) {
            e.preventDefault();
        
            const table = $(e.currentTarget).closest('table'),
                  tbody = table.find('tbody'),
                  existingRows = tbody.find('tr.srwc-slide-row').length;
        
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
                
                // Skip if already initialized
                if (__this.is(':visible')) {
                    let width = '100%';
                    
                    if (__this.closest('.srwc-slides-table').length) {
                        width = '200px';
                    }
                    else {
                        width = '350px';
                    }
                    
                    __this.select2({
                        width: width,
                        placeholder: __this.data('placeholder') || '',
                    });
                }

            });
        }

        toggleVisibility(e) {
            var __this = $(e.currentTarget);

            if (__this.is('select')) {
                var target  = __this.find(':selected').data('show'),
                    hideElement = __this.data('hide');
                    $(document.body).find(hideElement).hide();
                    $(document.body).find(target).show();
            } else {
                var target = __this.data('show');
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
                preview     = __this.find('.srwc-media-preview');

            const frame = wp.media({ 
                title: 'Select Image', 
                multiple: false, 
                library: { type: 'image' } 
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                media.val(attachment.url);
                preview.html('<img src="' + attachment.url + '" alt="Preview" style="max-width: 250px; max-height: 250px;" />');
                
                if (!__this.find('.srwc-media-remove').length) {
                    __this.find('.srwc-media-upload').after('<button type="button" class="button srwc-media-remove">Remove</button>');
                }
            });

            frame.open();
        }
        
        removeMedia(e) {
            e.preventDefault();

            const __this = $(e.currentTarget).closest('.srwc-media');
            __this.find('.srwc-media-url').val('');
            __this.find('.srwc-media-preview').html('');
            $(e.currentTarget).remove();
        }

        toggleCouponSelect(e) {
            const __this = $(e.currentTarget).val(),
                row = $(e.currentTarget).closest('.srwc-slide-row'),
                value = row.find('.srwc-slide-value').hide(),
                coupon = row.find('.srwc-coupon-select').hide(),
                custom = row.find('.srwc-slide-custom-value').hide();
        
            coupon.next('.select2-container').hide();
        
             if (__this === 'existing') {
                coupon.show().next('.select2-container').show();
                this.loadCouponOptions({ currentTarget: coupon[0] });
            } else if (__this === 'custom') {
                custom.show();
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

            // AJAX request to get coupons
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
                            allowClear: true
                        });
                        
                        __this.next('.select2-container').show();
                    } else {
                        __this.html('<option value="">No coupons found</option>');
                    }
                }
            });
        }

        initReports() {
            const self = this;
        
            // Export emails
            $('#export-emails').on('click', function () {
                const fromDate = $('#from-date').val(),
                    toDate = $('#to-date').val();
        
                const form = $('<form>', {
                    method: 'POST',
                    action: srwc_admin.ajax_url,
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
            });
        }
        
    }

    new SRWC_Admin();
});
