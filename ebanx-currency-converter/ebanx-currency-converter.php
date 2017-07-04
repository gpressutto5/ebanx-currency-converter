<?php
/**
 * Plugin Name: EBANX Currency Converter
 * Plugin URI: https://www.github.com/gpressutto5/ebanx-currency-converter
 * Description: This is a currency converter to use with EBANX Gateway.
 * Author: Guilherme Pressutto
 * Author URI: https://www.github.com/gpressutto5
 * Version: 0.0.1
 * License: MIT
 * Text Domain: ebanx-currency-converter
 * Domain Path: /languages
 *
 * @package WooCommerce_EBANX
 */

if (!defined('ABSPATH')) {
    die;
}

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

    $plugin = new Ebanx_Currency_Converter();
    $plugin->run();

}

run_ebanx_currency_converter();
