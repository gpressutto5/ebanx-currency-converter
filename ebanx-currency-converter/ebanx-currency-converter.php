<?php
/**
 * Plugin Name: EBANX Currency Converter
 * Plugin URI: https://www.github.com/gpressutto5/ebanx-currency-converter
 * Description: This is a currency converter to use with EBANX Payment Gateway for WooCommerce.
 * Author: Guilherme Pressutto
 * Author URI: https://www.github.com/gpressutto5
 * Version: 1.1.0
 * License: MIT
 * Text Domain: ebanx-currency-converter
 * Domain Path: /languages
 *
 * @package EBANX_Converter
 */

namespace Ebanx\Converter;

use Ebanx\Converter\Includes\Globals;
use Ebanx\Converter\Includes\Main;
use Ebanx\Converter\Includes\Notice;

if (!defined('ABSPATH')) {
    die;
}
if (class_exists('EbanxCurrencyConverter')) {
    return;
}

define('EBANX_CURRENCY_CONVERTER_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) . DIRECTORY_SEPARATOR);

require __DIR__ . '/lib/vendor/autoload.php';

class EbanxCurrencyConverter
{
    const DIR = __DIR__;

    /**
     * Singleton holder.
     *
     * @var EbanxCurrencyConverter
     */
    protected static $instance;

    /**
     * The singleton acessor.
     *
     * @return EbanxCurrencyConverter
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * EbanxCurrencyConverter constructor.
     */
    private function __construct()
    {
        $error = $this->check_requirements();

        if (strlen($error)) {
            $notice = new Notice();
            $notice->with_message($error)
                   ->with_type('error')
                   ->persistent()
                   ->enqueue();

            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
            deactivate_plugins(plugin_basename(__FILE__));

            return;
        }

        $this->initialize();
    }

    /**
     * @return string
     */
    private function check_requirements()
    {
        if (!Globals::is_ebanx_installed()) {
            return __('To use EBANX Currency Converter you need to install,', 'ebanx_currency_converter')
                   . ' <a href="http://wordpress.dev/wp-admin/plugins.php">'
                   . __('activate', 'ebanx_currency_converter')
                   . '</a> '
                   . __('and configure', 'ebanx_currency_converter')
                   . ' <a href="https://br.wordpress.org/plugins/ebanx-payment-gateway-for-woocommerce/">EBANX WooCommerce Gateway</a>.';
        }

        if (in_array(get_woocommerce_currency(), \WC_EBANX_Constants::$LOCAL_CURRENCIES)) {
            return __('To use EBANX Currency Converter your store must use USD or EUR.', 'ebanx_currency_converter');
        }

        return '';
    }

    private function initialize()
    {
        $plugin = new Main();
        $plugin->run();
    }
}

add_action('plugins_loaded', ['Ebanx\Converter\EbanxCurrencyConverter', 'getInstance'], 100);
