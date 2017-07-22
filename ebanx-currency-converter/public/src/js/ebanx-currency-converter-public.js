(function ($) {
    'use strict';
    const ls = require('localstorage-ttl');
    const timeToExpire = 2 * 60 * 1000; // 2 minutes
    const phpvars = ebanx_currency_converter_php_vars;

    let currentCurrency = ls.get('ebanx-currency-converter-last-currency');

    $(document).ready(function () {
        !currentCurrency || updatePrices();

        $('.ebanx-currency-converter--flag-link').each(function () {
            let currencyCode = $(this).data('currency');
            $(this).on('click', (e) => {
                e.preventDefault();
                $('.ebanx-currency-converter--flag-link').removeClass('active');
                $(this).addClass('active');
                ls.set('ebanx-currency-converter-last-currency', currencyCode);
                currentCurrency = ls.get('ebanx-currency-converter-last-currency');
                updatePrices();
            });
        });
    });

    let updatePrices = () => {
        getExchangeRates().then((result) => {
            console.log(result);
        }, (error) => {
            console.log(error);
        });
    };

    let getExchangeRates = () => {
        return new Promise((resolve, reject) => {
            let ls_name = 'ebanx-currency-converter-' + currentCurrency;
            if (ls.get(ls_name)) {
                resolve(ls.get(ls_name));
            }
            $.ajax({
                url: phpvars.ajaxurl,
                type: 'GET',
                data: {
                    action: 'ebanx_currency_converter_get_exchange_rate',
                    currency: currentCurrency,
                }
            }).done((data) => {
                data = JSON.parse(data);
                if (data.status !== 'SUCCESS') {
                    reject('error');
                }

                ls.set(ls_name, data, timeToExpire);
                resolve(ls.get(ls_name));
            });
        });
    };
})(jQuery);
