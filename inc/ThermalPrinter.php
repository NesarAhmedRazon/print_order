<?php

namespace TPRINTER;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class ThermalPrinter
{
    public function __construct()
    {
        add_filter('manage_edit-shop_order_columns', [$this, 'printer']);
        add_action('manage_shop_order_posts_custom_column', [$this, 'printer_data'], 10, 2);
    }
    public function printer($data)
    {
        $data['printer']     = __('Print Order', 'thermal-printer');
        return $data;
    }
    public function printer_data($data, $order_id)
    {
        $url = esc_url(site_url());
        switch ($data) {
            case 'printer':
                $dc = '<a href="my.bluetoothprint.scheme://' . $url . '/wp-json/wp/v2/printer/order/' . $order_id . '"><span class="dashicons dashicons-printer"></span></a>';
                echo $dc;
        }
    }
}
new ThermalPrinter();
