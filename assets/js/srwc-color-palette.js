'use strict ';

jQuery(function ($) {
    class SRWC_Coloer_Palette {

        constructor() {
            this.init();
        }

        init() {
            this.selectedThemeColor = null;
            this.bindEvents();
        }

        bindEvents() {
            $(document.body).on('click', '.srwc-color-palette', this.handleColorSelection.bind(this));
        }

        handleColorSelection(e) {
            e.preventDefault();
            const __this = $(e.currentTarget),
                selectedColor = __this.data('color');

            if (!selectedColor) return;
            // Update active state
            $('.srwc-color-palette').removeClass('active');
            __this.addClass('active');

            this.selectedThemeColor = selectedColor;

            const isGradient = selectedColor.includes('gradient') || selectedColor.includes('linear-gradient'),
                bgStyles     = isGradient ? { 'background': selectedColor } : { 'background-color': selectedColor };
            srwc_frontend.frontend.modal.find('.srwc-wheel-container').css(bgStyles);

            const slideColors = this.generateColorVariations(selectedColor, srwc_frontend.frontend.slides.length);
            srwc_frontend.frontend.slides.forEach((slide, index) => {
                slide.color = slideColors[index];
            });

            srwc_frontend.frontend.buildWheel();
            srwc_frontend.frontend.buildMiniWheel()
        }

        generateColorVariations(baseColor, count) {
            const colors = [],
                base = this.hexToRgb(baseColor);

            if (!base) {
                for (let i = 0; i < count; i++) {
                    colors.push(this.randomColor());
                }
                return colors;
            }

            for (let i = 0; i < count; i++) {
                const factor   = (i / count) * 0.6 + 0.4,
                    brightness = (i % 2.6) * 0.2;

                let r = Math.min(255, Math.max(0, base.r * factor + brightness * 255)),
                    g = Math.min(255, Math.max(0, base.g * factor + brightness * 255)),
                    b = Math.min(255, Math.max(0, base.b * factor + brightness * 255));

                // Add some variation
                const variation = (i % 2 === 0) ? 1.1 : 0.9;
                r = Math.min(255, Math.max(0, r * variation));
                g = Math.min(255, Math.max(0, g * variation));
                b = Math.min(255, Math.max(0, b * variation));

                colors.push(this.rgbToHex(Math.round(r), Math.round(g), Math.round(b)));
            }

            return colors;
        }

        hexToRgb(hex) {
            const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        rgbToHex(r, g, b) {
            return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }

        randomColor() {
            return '#' + Math.floor(Math.random() * 16777215).toString(16);
        }

    }

    new SRWC_Coloer_Palette();
});