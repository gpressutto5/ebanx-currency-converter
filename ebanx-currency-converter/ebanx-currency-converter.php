<?php
/**
 * Plugin Name: EBANX Currency Converter
 * Plugin URI: https://www.github.com/gpressutto5/ebanx-currency-converter
 * Description: This is a currency converter to use with EBANX Payment Gateway for WooCommerce.
 * Author: Guilherme Pressutto
 * Author URI: https://www.github.com/gpressutto5
 * Version: 1.0.1
 * License: MIT
 * Text Domain: ebanx-currency-converter
 * Domain Path: /languages
 *
 * @package WooCommerce_EBANX
 */

if (!defined('ABSPATH')) {
    die;
}

define('EBANX_CURRENCY_CONVERTER_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ebanx-currency-converter-activator.php
 */
function activate_ebanx_currency_converter()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-ebanx-currency-converter-activator.php';
    Ebanx_Currency_Converter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ebanx-currency-converter-deactivator.php
 */
function deactivate_ebanx_currency_converter()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-ebanx-currency-converter-deactivator.php';
    Ebanx_Currency_Converter_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_ebanx_currency_converter');
register_deactivation_hook(__FILE__, 'deactivate_ebanx_currency_converter');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-ebanx-currency-converter.php';

/**
 * Begins execution of the plugin.
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_ebanx_currency_converter()
{
    require_once plugin_dir_path(__FILE__) . 'includes/ebanx-currency-converter-global-functions.php';

    $error = check_requirements();

    if (strlen($error)) {
        require_once plugin_dir_path(__FILE__) . 'includes/class-ebanx-currency-converter-notice.php';
        $notice = new Ebanx_Currency_Converter_Notice();
        $notice->with_message($error)
               ->with_type('error')
               ->persistent()
               ->enqueue();

        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        deactivate_plugins(plugin_basename(__FILE__));

        return;
    }

    $plugin = new Ebanx_Currency_Converter();
    $plugin->run();
}

/**
 * @return string
 */
function check_requirements()
{
    if (!ebanx_currency_converter_is_ebanx_installed()) {
        return __('To use EBANX Currency Converter you need to install,', 'ebanx_currency_converter')
               . ' <a href="http://wordpress.dev/wp-admin/plugins.php">'
               . __('activate', 'ebanx_currency_converter')
               . '</a> '
               . __('and configure', 'ebanx_currency_converter')
               . ' <a href="https://br.wordpress.org/plugins/ebanx-payment-gateway-for-woocommerce/">EBANX WooCommerce Gateway</a>.';
    }

    if (in_array(get_woocommerce_currency(), WC_EBANX_Constants::$LOCAL_CURRENCIES)) {
        return __('To use EBANX Currency Converter your store must use USD or EUR.', 'ebanx_currency_converter');
    }

    return '';
}

add_action('plugins_loaded', 'run_ebanx_currency_converter', 100);
