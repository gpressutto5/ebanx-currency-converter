<?php

class Ebanx_Currency_Converter_Ajax
{
    public function get_exchange_rate()
    {
        if (!class_exists('WC_EBANX_Gateway')) {
            echo json_encode([
                'status' => 'ERROR'
            ]);
            wp_die();
        }

        $ebanx = new WC_EBANX_Gateway();
        $data = [
            'status' => 'SUCCESS',
            'exchange_rate' => $ebanx->get_currency_rate($_GET['currency']),
            'store_currency' => $ebanx->merchant_currency,
            'current_currency' => $_GET['currency'],
        ];
        echo json_encode($data);
        wp_die();
    }
}
