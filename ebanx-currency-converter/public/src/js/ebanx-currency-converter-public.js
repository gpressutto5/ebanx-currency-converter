(function ($) {
    'use strict';
    const ls = require('localstorage-ttl');

    $(document).ready(function () {
        console.log(ls.get('last-country'));
        $('.ebanx-currency-converter--flag-link').each(function () {
            let countryCode = $(this).data('country');
            $(this).on('click', (e) => {
                e.preventDefault();
                ls.set('last-country', countryCode, 10000);
                console.log(ls.get('last-country'));
            });
        });
    });
})(jQuery);
