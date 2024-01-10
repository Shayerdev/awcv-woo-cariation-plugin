<?php

namespace awcv\Ajax;

use awcv\Helpers;

class AjaxVariableForm extends Helpers\CreateAjax
{
    protected $nonce_query;

    /**
     * @param $nonce_query
     */
    public function __construct($nonce_query)
    {
        $this->nonce_query = $nonce_query;
        parent::__construct("ajax_variation_form", [$this, "callback"]);
    }

    /**
     * @return void
     */
    public function callback()
    {
        $data = json_decode(file_get_contents("php://input"));

        // Check security
        if (! wp_verify_nonce($data->nonce, $this->nonce_query)) {
            wp_send_json_error('Security. nonce is not valid');
        }

        // Validation field
        if (empty($data->product_key)) {
            wp_send_json_error('Validation. product_key not send');
        }

        if (empty($data->product_id)) {
            wp_send_json_error('Validation. product_id not send');
        }

        if (empty($data->cols)) {
            wp_send_json_error('Validation. cols not send');
        }

        ob_start();
        $product_get = wc_get_product($data->product_id);
        $post_thumbnail_id = $product_get->get_image_id();

        # Set global product for template
        global $product;
        global $woocommerce;
        $product = $product_get;

        if (!empty($post_thumbnail_id)) {
            $thumb = wc_get_gallery_image_html($post_thumbnail_id, true);
        } else {
            $thumb  = '<div class="woocommerce-product-gallery__image--placeholder">';
            $thumb .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
            $thumb .= '</div>';
        }

        add_action("woocommerce_before_variations_form", function () use ($product) {
            echo sprintf('<a href="%s">%s</a>', get_the_permalink($product->get_id()), $product->get_title());
        });

        // Before Variation Form
        add_action("woocommerce_before_add_to_cart_form", function () use ($data, $thumb) {
            echo "<td colspan='" . $data->cols . "'><table class='form_update_product_variation'><tbody><tr>";
            echo sprintf("<td class='product-thumbnail'>%s</td>", $thumb);
            echo "<td class='variations'>";
            echo sprintf("<script type='text/javascript' src='%s'></script>", plugins_url() . '/woocommerce/assets/js/frontend/add-to-cart-variation.min.js?ver=8.4.0');
        });

        // After Variation Form
        add_action("woocommerce_after_add_to_cart_form", function () use ($data) {
            echo "</td></tr></tbody></table></td>";
        });

        // Add action after single variation
        add_action('woocommerce_after_single_variation', function () use ($data) {
            echo sprintf(
                "<div class='%s'><button data-action='cancel' data-product-key='%s'>%s</button><button data-action='update' data-product-id='%s' data-product-key='%s'>%s</button></div>",
                'product-variables-actions',
                $data->product_key,
                apply_filters(AWCV_SLUG . '_product_variables_action_cancel_label', __('Cancel', AWCV_LOCALE_STR)),
                $data->product_id,
                $data->product_key,
                apply_filters(AWCV_SLUG . '_product_variables_action_update_label', __('Update', AWCV_LOCALE_STR))
            );
        });

        // Get variable template
        wc_get_template(
            'single-product/add-to-cart/variable.php',
            array(
                'available_variations' => $product_get->get_available_variations(),
                'attributes' => $product_get->get_variation_attributes()
            )
        );
        $template_content = ob_get_clean();

        // Send response to front
        wp_send_json_success(array(
            'form' => $template_content,
            'selected_qty' => $woocommerce->cart->get_cart_item($data->product_key)['quantity'],
            'selected_variation' => $woocommerce->cart->get_cart_item($data->product_key)['variation']
        ));
    }
}
