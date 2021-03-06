<?php
function ebanx_currency_converter_get_template($path, $args = [], $echo = true)
{
    return Ebanx_Currency_Converter_Globals::get_template($path, $args, $echo);
}

function ebanx_currency_converter_is_ebanx_installed()
{
    return Ebanx_Currency_Converter_Globals::is_ebanx_installed();
}

class Ebanx_Currency_Converter_Globals
{
    public static function get_template($path, $args = [], $echo = true)
    {
        $path = plugin_dir_path(dirname(__FILE__)) . $path . '.template.php';
        if (!empty($args)) {
            extract($args);
        }

        if ($echo) {
            include $path;

            return;
        }

        ob_start();
        include $path;

        return ob_get_clean();
    }

    public static function is_ebanx_installed()
    {
        return class_exists('WC_EBANX_Gateway');
    }
}
