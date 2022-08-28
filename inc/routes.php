<?php

/**
 * Create all Routes for WP Rest API Calls
 *
 * @param    object  $object The object to convert
 * @return      array
 *
 */

namespace TPRINTER\API;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


final class ApiRoutes
{
    public function __construct()
    {
        // Initialize the Menu Locations.
        //add_action('init', [$this, 'registe_menu_locations']);
        add_action('rest_api_init', [$this, 'register_api_routes']);
    }

    public function registe_menu_locations()
    {
        register_nav_menus(
            array(
                'cta' => __('CTA Buttons'),
                'copyright' => __('Copyright Menu'),
                'megaFooter' => __('SubMenu Footer Menu'),
            )
        );
    }
    public function register_api_routes()
    {
        register_rest_route('wp/v2', '/printer/order/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_order_data'],
        ));
        register_rest_route('wp/v2', '/aOrder/(?P<id>\w+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'aOrder'],
        ));
    }



    public function get_order_data($req)
    {
        $order_id  = $req['id'];
        $order = wc_get_order($order_id);
        $a = [
            (object) [
                'type'      => '1',
                'path'   => 'https://www.pcbbd.com/wp-content/uploads/2022/08/pcbbd_logo_1x.png',
                'align'     => '1',
            ],
            (object) [
                'type'      => '0',
                'content'   => 'Invoice: ' . $order->ID,
                'align'     => '1',
            ], (object) [
                'type'      => 4,
                'content'   => $this->aOrder($req),
                'align'     => 1,
            ],
        ];

        echo json_encode($a, JSON_FORCE_OBJECT);
    }

    public function aOrder($reqs)
    {
        $style = '.table{border-collapse:collapse;border-spacing:0;width:100%;margin:1rem 0}.table td,.table th{line-height:1;text-align:left;padding:.5rem .8rem}.table td:not(:first-child),.table th:not(:first-child){text-align:center;width:-webkit-fit-content;width:-moz-fit-content;width:fit-content}.table th{font-size:1.1rem;font-weight:600;color:#fff;background-color:#000}.table td{font-size:.8rem;font-weight:400;line-height:1;border-color:#888;border-right-color:#dfdfdf;border-width:0 1px 1px 0;padding:.5rem .8rem;border-style:solid}.table td:last-child{border-right:none}.table tbody tr:nth-of-type(odd){background-color:#efefef}';

        $html = '<style type="text/css">' . $style . '</style><table class="table"><thead><tr><th class="tg-4n2o">Item</th><th class="tg-4n2o">Cost</th><th class="tg-4n2o">Qty</th><th class="tg-4n2o">Total</th></tr></thead><tbody>';
        $order_id  = $reqs['id'];
        $order = wc_get_order($order_id);


        $order_items = $order->get_items();
        foreach ($order_items as $item_id => $item) {
            $item_id = $item->get_id();

            // methods of WC_Order_Item_Product class

            $item_name = $item->get_name(); // Name of the product
            $item_type = $item->get_type(); // Type of the order item ("line_item")

            $product_id = $item->get_product_id(); // the Product id
            $wc_product = $item->get_product();    // the WC_Product object

            // order item data as an array
            $item_data = $item->get_data();

            // echo $item_data['name'];
            // echo $item_data['product_id'];
            // echo $item_data['variation_id'];
            // echo $item_data['quantity'];
            // echo $item_data['tax_class'];
            // echo $item_data['subtotal'];
            // echo $item_data['subtotal_tax'];
            // echo $item_data['total'];
            // echo $item_data['total_tax'];

            $html .= '<tr><td class="tg-wo29">' . $item_data['name'] . '</td><td class="tg-wo29">' . ($item_data['total'] / $item_data['quantity']) . '</td><td class="tg-wo29">' . $item_data['quantity'] . '</td><td class="tg-wo29">' . $item_data['total'] . '</td></tr>';
        }

        $html .= "</tbody></table>";
        return $html;
    }
}
new ApiRoutes();
