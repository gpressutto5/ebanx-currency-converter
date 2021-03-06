<?php

class Class_Ebanx_Currency_Converter_Widget extends WP_Widget
{
    private $instance;

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        parent::__construct('ebanx_currency_converter',
            __('Ebanx Currency Converter', 'ebanx_currency_converter'), [
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
        $data = [
            'args'      => $args,
            'title'     => apply_filters('widget_title', $instance['title']),
            'countries' => [
                [
                    'enabled' => $instance['brazil'],
                    'name'    => 'Brazil',
                    'country-code'    => 'br',
                    'currency-code'    => 'BRL',
                    'currency-name'    => 'Reais Brasileiros',
                ],
                [
                    'enabled' => $instance['mexico'],
                    'name'    => 'Mexico',
                    'country-code'    => 'mx',
                    'currency-code'    => 'MXN',
                    'currency-name'    => 'Pesos Mexicanos',
                ],
                [
                    'enabled' => $instance['argentina'],
                    'name'    => 'Argentina',
                    'country-code'    => 'ar',
                    'currency-code'    => 'ARS',
                    'currency-name'    => 'Pesos Argentinos',
                ],
                [
                    'enabled' => $instance['colombia'],
                    'name'    => 'Colombia',
                    'country-code'    => 'co',
                    'currency-code'    => 'COP',
                    'currency-name'    => 'Pesos Colombianos',
                ],
                [
                    'enabled' => $instance['chile'],
                    'name'    => 'Chile',
                    'country-code'    => 'cl',
                    'currency-code'    => 'CLP',
                    'currency-name'    => 'Pesos Chilenos',
                ],
                [
                    'enabled' => $instance['peru'],
                    'name'    => 'Peru',
                    'country-code'    => 'pe',
                    'currency-code'    => 'PEN',
                    'currency-name'    => 'Pesos Peruanos',
                ],
                [
                    'enabled' => get_woocommerce_currency() === 'USD' ? $instance['usa'] : null,
                    'name'    => 'United States',
                    'country-code'    => 'us',
                    'currency-code'    => 'USD',
                    'currency-name'    => 'Dollar',
                ],
                [
                    'enabled' => get_woocommerce_currency() === 'EUR' ? $instance['europe'] : null,
                    'name'    => 'Europe',
                    'country-code'    => 'eu',
                    'currency-code'    => 'EUR',
                    'currency-name'    => 'Euro',
                ],
            ],
        ];
        ebanx_currency_converter_get_template('widgets/templates/public', $data);
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     *
     * @return string
     */
    public function form($instance)
    {
        $this->instance = $instance;
        $data           = [
            'field' => [
                'title'    => $this->get_field(
                    'title',
                    __('Title:'),
                    __('Ebanx Currency Converter', 'ebanx_currency_converter')
                ),
                'brazil'   => $this->get_field(
                    'brazil',
                    __('Brazil'),
                    true
                ),
                'mexico'   => $this->get_field(
                    'mexico',
                    __('Mexico'),
                    true
                ),
                'argentina'   => $this->get_field(
                    'argentina',
                    __('Argentina'),
                    true
                ),
                'colombia' => $this->get_field(
                    'colombia',
                    __('Colombia'),
                    true
                ),
                'chile'    => $this->get_field(
                    'chile',
                    __('Chile'),
                    true
                ),
                'peru'     => $this->get_field(
                    'peru',
                    __('Peru'),
                    true
                ),
                'usa'     => $this->get_field(
                    'usa',
                    __('United States'),
                    true
                ),
                'europe'     => $this->get_field(
                    'europe',
                    __('Europe'),
                    true
                ),
            ],
        ];
        ebanx_currency_converter_get_template('widgets/templates/form', $data);

        return 'form';
    }

    private function get_field($name, $label, $default)
    {
        return [
            'id'    => $this->get_field_id($name),
            'name'  => $this->get_field_name($name),
            'value' => isset($this->instance[$name]) ? $this->instance[$name] : $default,
            'label' => $label,
        ];
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance             = $old_instance;
        $instance['title']    = $new_instance['title'];
        $instance['brazil']   = $new_instance['brazil'];
        $instance['mexico']   = $new_instance['mexico'];
        $instance['argentina']   = $new_instance['argentina'];
        $instance['colombia'] = $new_instance['colombia'];
        $instance['chile']    = $new_instance['chile'];
        $instance['peru']     = $new_instance['peru'];
        $instance['usa']      = get_woocommerce_currency() === 'USD' ? $new_instance['usa'] : null;
        $instance['europe']   = get_woocommerce_currency() === 'EUR' ? $new_instance['europe'] : null;

        return $instance;
    }
}
