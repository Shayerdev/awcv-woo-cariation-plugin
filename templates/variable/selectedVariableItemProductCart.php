<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    global $woocommerce;

    $items = $woocommerce->cart->get_cart_item( $attr['cart_item_key'] );
    $selectedVariation = $items['variation'];
    $selectedQuantity = $items['quantity'];
    ?>

<div class="product-variables-selected">
    <?php if(!empty($selectedVariation)) {
        foreach ($selectedVariation as $name => $val){
            $attrVar = get_term_by('slug', $val, explode('attribute_', $name)[1]);
            ?>
            <div class="product-variable-selected">
                <div class="product-variable__label" data-value-attr="<?php echo $name?>"><?php echo wc_attribute_label( explode('attribute_', $name)[1] );?></div>
                <div class="product-variable__value" data-value-attr="<?php echo $val?>"><?php echo $attrVar->name?></div>
            </div>
            <?php
        }
    }
    ?>
    <div class="product-variable-selected">
        <div class="product-variable__label"><?php echo $attr['quantity_label']?></div>
        <div class="product-variable__value" data-value-attr="<?php echo $selectedQuantity?>"><?php echo $selectedQuantity?></div>
    </div>
</div>
