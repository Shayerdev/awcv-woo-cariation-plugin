<?php

namespace awcv\ajax;

use awcv\Helpers;

class AjaxVariableUpdate extends Helpers\CreateAjax
{
    protected $nonce_query;
    public function __construct($nonce_query)
    {
        $this->nonce_query = $nonce_query;
        parent::__construct("ajax_variation_form_update", [$this, "callback"]);
    }

    public function callback()
    {

        $product_key = sanitize_text_field($_POST['cart-item-key']);
        $variation_id = sanitize_text_field($_POST['variation_id']);
        $new_variation_data = $this->sanitize_attribute_variable($_POST);

        if (empty($variation_id)) {
            wp_send_json_error('Validation. variation_id not send');
        }

        $cart = WC()->cart;

        $cart_item = $cart->get_cart_item($product_key);
        $cart_item_cache = $cart_item;

        if (isset($cart_item['variation_id'])) {
            foreach ($new_variation_data as $meta_key => $meta_value) {
                $cart_item['variation'][$meta_key] = $meta_value;
            }

            $cart_item['quantity'] = intval($_POST['quantity']);
            $cart->cart_contents[$product_key] = $cart_item;
            $cart->calculate_totals();

            if (!empty($diff_variable = array_diff($cart_item_cache['variation'], $cart_item['variation']))) {
                $cart->remove_cart_item($product_key);
            }

            wp_send_json_success(array('old-cart-item-key' => $product_key, 'cart' => $cart, 'variable_diff' => $diff_variable));
        } else {
            wp_send_json_error('Product is not variable');
        }
    }

    private function sanitize_attribute_variable($data): array
    {
        return array_filter($data, function ($key) {
            // Возвращаем true, если ключ начинается с "attribute_pa_"
            return strpos($key, 'attribute_pa_') === 0;
        }, ARRAY_FILTER_USE_KEY);
    }
}
