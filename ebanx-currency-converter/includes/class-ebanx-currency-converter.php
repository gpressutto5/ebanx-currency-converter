<?php

class Ebanx_Currency_Converter
{
    protected $loader;
    protected $ebanx_currency_converter;
    protected $version;

    public function __construct()
    {
        $this->ebanx_currency_converter = 'ebanx-currency-converter';
        $this->version                  = '0.0.1';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_ajax_hooks();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ebanx-currency-converter-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ebanx-currency-converter-i18n.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ebanx-currency-converter-global-functions.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ebanx-currency-converter-ajax.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ebanx-currency-converter-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-ebanx-currency-converter-public.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ebanx-currency-converter-notice.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'interceptors/class-ebanx-currency-converter-settings-interceptor.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'widgets/class-ebanx-currency-converter-widget.php';

        $this->loader = new Ebanx_Currency_Converter_Loader();
    }

    private function set_locale()
    {
        $plugin_i18n = new Ebanx_Currency_Converter_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks()
    {
        $plugin_admin      = new Ebanx_Currency_Converter_Admin($this->get_ebanx_currency_converter(),
            $this->get_version());
        $ebanx_interceptor = new Ebanx_Currency_converter_Settings_Interceptor();

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
        $plugin_public = new Ebanx_Currency_Converter_Public($this->get_ebanx_currency_converter(),
            $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('widgets_init', $plugin_public, 'register_widget');
    }

    private function define_ajax_hooks()
    {
        $plugin_ajax = new Ebanx_Currency_Converter_Ajax();

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
