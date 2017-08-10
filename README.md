# EBANX Currency Converter

This is a currency converter to use with EBANX Payment Gateway for WooCommerce. This is an unnoficial plugin.

## Requirements
* PHP 5.6+
* Wordpress 4.0+
* WooCommerce 2.6+
* EBANX Payment Gateway for WooCommerce 1.10.0+

> EBANX only supports currency exchange when processing with USD or EUR, so this plugin requires that your store process one of these two currencies.

## Getting Started

The easiest way to use this plugin is using the included Widget.

1. On WordPress Admin Dashboard go to Appearence » Widgets.
![widgets](http://i.imgur.com/ozsOBjl.png)
2. Drag and drop EBANX Currency Converter widget into any layout area.
![layout area](http://i.imgur.com/8TCAQnT.png)
3. Choose the countries you process with EBANX and save.
![countries](http://i.imgur.com/kCYwtUD.png)
4. That's it!
![done!](http://i.imgur.com/NimxCNG.png)

## Customizing

You can make your own design and use this plugin in your theme! Just make sure you add the following attributes to the elements you want to use as currency switch:

* `class`: `ebanx-currency-converter--flag-link`
This class has no styling. It is used for javescript to find the flag elements.
* `data-currency`: `USD`, `EUR`, `BRL`, `MXN`, `COL`, `CLP` or `PEN`
The currency this link switches to.

Example:
```html
<a href="#" class="ebanx-currency-converter--flag-link" data-currency="BRL">Real</a>
<a href="#" class="ebanx-currency-converter--flag-link" data-currency="USD">Dollar</a>
```

Also, for styling purposes, the selected currency will automatically get the class `active`.
