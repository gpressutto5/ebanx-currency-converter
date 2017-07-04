<?php

class Ebanx_Currency_Converter_Public
{
    private $ebanx_currency_converter;
    private $version;

    public function __construct($ebanx_currency_converter, $version)
    {
        $this->ebanx_currency_converter = $ebanx_currency_converter;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->ebanx_currency_converter, plugin_dir_url(__FILE__) . 'dist/css/ebanx-currency-converter-public.min.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->ebanx_currency_converter, plugin_dir_url(__FILE__) . 'dist/js/ebanx-currency-converter-public.min.js', array('jquery'), $this->version, false);
    }

    public function register_widget()
    {
        register_widget('Class_Ebanx_Currency_Converter_Widget');
    }
}
