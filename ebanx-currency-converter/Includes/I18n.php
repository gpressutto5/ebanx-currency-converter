<?php
namespace Ebanx\Converter\Includes;

class I18n
{
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'ebanx-currency-converter',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
