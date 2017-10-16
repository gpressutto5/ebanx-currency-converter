<?php
namespace Ebanx\Converter\Interceptors;

class Settings
{
    /**
     * Identify interceptor instances
     *
     * @var string
     */
    public $id = "settings";

    /**
     * Removes some form fields from settings to prevent use
     *
     * @param  array $fields The original form fields from EBANX plugin
     *
     * @return array The modified form fields
     */
    public function form_fields($fields)
    {
        /**
         * Add a field to EBANX settings
         * $fields['field'] = [
         * 'title' => __('Title', 'ebanx-currency-converter'),
         * 'label' => __('Label', 'ebanx-currency-converter'),
         * 'type' => 'checkbox',
         * ];
         */

        return $fields;
    }
}
