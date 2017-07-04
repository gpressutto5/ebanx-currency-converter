<?php
function ebanx_currency_converter_get_template($path, $args = [], $echo = true)
{
    return Ebanx_Currency_Converter_Globals::get_template($path, $args, $echo);
}

class Ebanx_Currency_Converter_Globals
{
    public function get_template($path, $args = [], $echo = true)
    {
        $path = plugin_dir_path( dirname( __FILE__ ) ) . $path . '.php';
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
}
