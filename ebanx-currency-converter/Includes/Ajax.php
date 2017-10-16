<?php
namespace Ebanx\Converter\Includes;

class Ajax
{
    public function get_exchange_rate()
    {
        if (!class_exists('WC_EBANX_Gateway')) {
            echo json_encode([
                'status' => 'ERROR'
            ]);
            wp_die();
        }

        $ebanx = new \WC_EBANX_Gateway();
        $data = [
            'status' => 'SUCCESS',
            'exchange_rate' => round(floatval($ebanx->get_local_currency_rate_for_site($_GET['currency'])), 2),
            'store_currency' => $ebanx->merchant_currency,
            'current_currency' => $_GET['currency'],
        ];
        echo json_encode($data);
        wp_die();
    }
}
