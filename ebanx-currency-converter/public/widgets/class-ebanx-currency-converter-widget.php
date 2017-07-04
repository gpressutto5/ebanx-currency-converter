<?php

class Class_Ebanx_Currency_Converter_Widget extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        parent::__construct('ebanx_currency_converter',
            __('Ebanx Currency Converter', 'ebanx_currency_converter'),[
                'description' => esc_html__('Ebanx Currency Converter Widget', 'ebanx_currency_converter'),
            ]
        );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        // Import display
        echo 'widget-test';
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     * @return string
     */
    public function form($instance)
    {
        // Import admin display
        return 'widget-admin';
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }
}
