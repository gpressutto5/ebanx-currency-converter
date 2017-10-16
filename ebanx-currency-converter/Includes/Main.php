<?php
namespace Ebanx\Converter\Includes;

use Ebanx\Converter\Admin\Admin;
use Ebanx\Converter\Front\Front;
use Ebanx\Converter\Interceptors\Settings;

class Main
{
    protected $loader;
    protected $ebanx_currency_converter;
    protected $version;

    public function __construct()
    {
        $this->ebanx_currency_converter = 'ebanx-currency-converter';
        $this->version                  = '1.0.2';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_ajax_hooks();
    }

    private function load_dependencies()
    {
        $this->loader = new Loader();
    }

    private function set_locale()
    {
        $plugin_i18n = new I18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks()
    {
        $plugin_admin      = new Admin($this->get_ebanx_currency_converter(),
            $this->get_version());
        $ebanx_interceptor = new Settings();

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_filter('ebanx_settings_form_fields', $ebanx_interceptor, 'form_fields');
    }

    public function get_ebanx_currency_converter()
    {
        return $this->ebanx_currency_converter;
    }

    public function get_version()
    {
        return $this->version;
    }

    private function define_public_hooks()
    {
        $plugin_public = new Front($this->get_ebanx_currency_converter(),
            $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('widgets_init', $plugin_public, 'register_widget');
    }

    private function define_ajax_hooks()
    {
        $plugin_ajax = new Ajax();

        $this->loader->add_action('wp_ajax_ebanx_currency_converter_get_exchange_rate', $plugin_ajax, 'get_exchange_rate');
        $this->loader->add_action('wp_ajax_nopriv_ebanx_currency_converter_get_exchange_rate', $plugin_ajax, 'get_exchange_rate');
    }

    public function run()
    {
        $this->loader->run();
    }

    public function get_loader()
    {
        return $this->loader;
    }
}
