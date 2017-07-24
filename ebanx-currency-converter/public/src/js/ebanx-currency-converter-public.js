(function ($) {
    'use strict';
    const ls = require('localstorage-ttl');
    const timeToExpire = 2 * 60 * 1000; // 2 minutes
    const phpvars = ebanx_currency_converter_php_vars;
    const tax = 0.0038;
    const locale = {
        BRL: {
            currencySymbol: 'R$',
            decimalSeparator: ',',
            thousandSeparator: '.',
        },
        MXN: {
            currencySymbol: '$',
            decimalSeparator: ',',
            thousandSeparator: '.',
        },
        COP: {
            currencySymbol: '$',
            decimalSeparator: ',',
            thousandSeparator: '.',
        },
        CLP: {
            currencySymbol: '$',
            decimalSeparator: ',',
            thousandSeparator: '.',
        },
        PEN: {
            currencySymbol: 'S\\.',
            decimalSeparator: ',',
            thousandSeparator: '.',
        },
        USD: {
            currencySymbol: '$',
            decimalSeparator: '.',
            thousandSeparator: ',',
        },
        EUR: {
            currencySymbol: '€',
            decimalSeparator: '.',
            thousandSeparator: ',',
        },
    };

    let currentCurrency = ls.get('ebanx-currency-converter-last-currency');
    let hasSetUpFinished = false;

    $(document).ready(function () {
        setUpFlags();
        !currentCurrency || currentCurrency === phpvars.original_currency || updatePrices();

        $(document.body).bind('show_variation updated_checkout updated_shipping_method added_to_cart cart_page_refreshed cart_widget_refreshed updated_addons wc_fragments_refreshed wc_fragments_loaded cart_totals_refreshed', function() {
            updatePrices();
        });
    });

    let updatePrices = () => {
        setUpPrices();
        let spanAmount = $('span.amount');
        if (currentCurrency === phpvars.original_currency) {
            spanAmount.each(function () {
                if ($(this).parent().hasClass('ebanx-amount-total')) {
                    return;
                }
                $(this).html($(this).attr('data-original'));
            });
            return;
        }
        getExchangeRates().then((result) => {
            spanAmount.each(function () {
                if ($(this).parent().hasClass('ebanx-amount-total')) {
                    return;
                }
                let price;
                if (price = $(this).data('price')) {
                    $(this).html(getConvertedPrice(
                        price,
                        result
                    ));
                }
            });
        }, (error) => {
            currentCurrency = phpvars.original_currency;
        });
    };

    let getConvertedPrice = (amount, data) => {
        if (data.current_currency === 'BRL') {
            amount *= (1 + tax);
        }

        let price = Number(amount * data.exchange_rate).formatMoney(2, locale[data.current_currency].decimalSeparator, locale[data.current_currency].thousandSeparator);

        return locale[data.current_currency].currencySymbol + ' ' + price;
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
            if ($(this).parent().hasClass('ebanx-amount-total')) {
                return;
            }
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

    Number.prototype.formatMoney = function(c, d, t){
        let n = this;
        c = isNaN(c = Math.abs(c)) ? 2 : c;
        d = d === undefined ? "." : d;
        t = t === undefined ? "," : t;
        let s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
})(jQuery);
