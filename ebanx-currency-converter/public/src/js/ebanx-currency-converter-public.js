(function ($) {
    'use strict';
    const ls = require('localstorage-ttl');
    const timeToExpire = 2 * 60 * 1000; // 2 minutes
    const phpvars = ebanx_currency_converter_php_vars;

    let currentCurrency = ls.get('ebanx-currency-converter-last-currency');
    let hasSetUpFinished = false;

    $(document).ready(function () {
        !currentCurrency || currentCurrency === phpvars.original_currency || updatePrices();

        setUpPrices();
        setUpFlags();
        updatePrices();
    });

    let updatePrices = () => {
        if (!hasSetUpFinished) {
            return;
        }
        let spanAmount = $('span.amount');
        if (currentCurrency === phpvars.original_currency) {
            spanAmount.each(function () {
                $(this).html($(this).attr('data-original'));
            });
            return;
        }
        spanAmount.each(function () {
            $(this).html('test');
        });
        /*getExchangeRates().then((result) => {
            console.log(result);
        }, (error) => {
            console.log(error);
        });*/
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

    let setUpFlags = () => {
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
    };

    let setUpPrices = () => {
        $('span.amount').each(function () {
            //Original Code
            let originalCode = $(this).attr("data-original");
            if (typeof originalCode === 'undefined' || !originalCode) {
                $(this).attr("data-original", $(this).html());
            }

            //Original Price
            let originalPrice = $(this).attr("data-price");

            if (typeof originalPrice === 'undefined' || !originalPrice) {
                originalPrice = $(this).html();

                // Small hack to prevent errors with $ symbols
                $('<del></del>' + originalPrice).find('del').remove();

                // Remove formatting
                originalPrice = originalPrice.replace(phpvars.thousand_separator, '');
                originalPrice = originalPrice.replace(phpvars.decimal_separator, '.');
                originalPrice = originalPrice.replace(/[^0-9.]/g, '');
                originalPrice = parseFloat(originalPrice);

                // Store original price
                $(this).attr("data-price", originalPrice);
            }
        });
        hasSetUpFinished = true;
    };
})(jQuery);
