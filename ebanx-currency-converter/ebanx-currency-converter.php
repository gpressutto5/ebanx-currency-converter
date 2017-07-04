<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ebanx-currency-converter-activator.php
 */
function activate_ebanx_currency_converter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ebanx-currency-converter-activator.php';
	Ebanx_Currency_Converter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ebanx-currency-converter-deactivator.php
 */
function deactivate_ebanx_currency_converter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ebanx-currency-converter-deactivator.php';
	Ebanx_Currency_Converter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ebanx_currency_converter' );
register_deactivation_hook( __FILE__, 'deactivate_ebanx_currency_converter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ebanx-currency-converter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_ebanx_currency_converter() {

	$plugin = new Ebanx_Currency_Converter();
	$plugin->run();

}
run_ebanx_currency_converter();
