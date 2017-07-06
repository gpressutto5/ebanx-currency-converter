(function ($) {
    'use strict';
    // criar ebanx_currency_converter_params em um script inline passando as variáveis do php
    $(document).ready(function () {
        $('.ebanx-currency-converter--flag-link').each(function () {
            let countryCode = $(this).data('country');
            $(this).on('click', (e) => {
                e.preventDefault();
                console.log(countryCode);
            });
        });
    });
})(jQuery);
