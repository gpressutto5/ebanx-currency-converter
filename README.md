# EBANX Currency Converter

This is a currency converter to use with EBANX Payment Gateway for WooCommerce. This plugin is a unnoficial plugin.

## Requirements
* PHP 5.6+
* Wordpress 4.0+
* WooCommerce 2.6+
* EBANX Payment Gateway for WooCommerce 1.10.0+

> EBANX only supports currency exchange when processing with USD or EUR, so this plugin requires that your store process one of these two currencies.

## Getting Started

The easiest way to use this plugin is using the included Widget.

1. On WordPress Admin Dashboard go to Appearence » Widgets.
2. Drag and drop EBANX Currency Converter widget into any layout area.
3. Choose the countries you process with EBANX and save.
4. That's it!

## Customizing

You can make your own design and use this plugin in your theme! Just make sure you add the following attributes to the elements you want to use as currency switch:

* `class`: `ebanx-currency-converter--flag-link`
This class has no styling. It is used for javescript to find the flag elements.
* `data-currency`: `USD`, `EUR`, `BRL`, `MXN`, `COL`, `CLP` or `PEN`
The currency this link switches to.

Also, for styling purposes, the selected currency will automatically get the class `active`.
