<?php

namespace awcv\Customizer;

use awcv\Helpers;

class Cart
{
    /**
     * Customize cart: Add edit after name product in cart item product
     *
     * @return void
     */
    public static function addButtonEditVariable()
    {
        add_action("woocommerce_after_cart_item_name", function ($cart_item, $cart_item_key) {
            try {
                $initFilter = (new Helpers\CreateFilter("button_edit_cart_variable", array(
                    "icon" => "",
                    "class" => "edit-variable-product-cart-icon",
                    "label" => __("Edit", AWCV_SLUG)
                )))->get();

                $attr = array_merge($initFilter, array(
                    'cart_item' => $cart_item,
                    'cart_item_key' => $cart_item_key
                ));

                $plugin_file_path = plugin_dir_path(AWCV_PLUGIN_DIR) . "templates/buttons/buttonEditVariableProductCart.php";
                if (file_exists($plugin_file_path)) {
                    include $plugin_file_path;
                } else {
                    throw new \Exception("File template buttonEditVariableProductCart not detect", 0);
                }
            } catch (\Exception $e) {
                error_log($e);
            }
        }, 10, 2);
    }

    /**
     * Customize cart: Remove attributes from title in product cart row
     *
     * @return void
     */
    public static function changeTitleItem()
    {
        add_filter("woocommerce_cart_item_name", function (
            $product_name,
            $cart_item,
            $cart_item_key
        ) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_permalink = apply_filters(
                'woocommerce_cart_item_permalink',
                $_product->is_visible()
                    ? $_product->get_permalink($cart_item)
                    : '',
                $cart_item,
                $cart_item_key
            );

            // Get default title -> $_product->get_title()
            // Get title with variable -> $_product->get_name() || $product_name
            return sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_title());
        }, 10, 3);
    }

    /**
     * Customize cart: Show selected variable product after title product
     *
     * @return void
     */
    public static function selectedVariablesItems()
    {
        add_action("woocommerce_after_cart_item_name", function ($cart_item, $cart_item_key) {
            try {
                $label = self::addStaticLabelQuantity();

                $attr = array(
                    'quantity_label' => $label,
                    'cart_item' => $cart_item,
                    'cart_item_key' => $cart_item_key
                );

                $plugin_file_path = plugin_dir_path(AWCV_PLUGIN_DIR) . "templates/variable/selectedVariableItemProductCart.php";
                if (file_exists($plugin_file_path)) {
                    include $plugin_file_path;
                } else {
                    throw new \Exception("File template selectedVariableItemProductCart not detect", 0);
                }
            } catch (\Exception $e) {
                error_log($e);
            }
        }, 10, 2);
    }

    /**
     * Customize cart: Add static label quantity before input  count product
     * @return void
     */
    public static function addStaticLabelQuantity(): string
    {
        return apply_filters(AWCV_SLUG . '_quantity_label', __('Quantity', 'awcv'));

    }

    /**
     * Customize cart: Add Price after name product
     * @return void
     */
    public static function addPriceProductAfterName()
    {
        add_action("woocommerce_after_cart_item_name", function ($cart_item, $cart_item_key) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            echo sprintf(
                "<div class='product-price__subtotal'>%s</div>",
                apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key) // PHPCS: XSS ok.
            );
        }, 10, 2);
    }

    /**
     * Customize cart: Remove quantity column from table products
     * @return void
     */
    public static function removeQuantityColumn()
    {
        add_filter('woocommerce_cart_item_quantity', '__return_false');
    }
}
