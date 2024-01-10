<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    $icon = $attr['icon'];
    $class = $attr['class'];
    $label = $attr['label'];
    $cartKey = $attr['cart_item_key'];
    $cartItem = $attr['cart_item'];
?>

<button
    class="<?php echo $class?>"
    data-product-id="<?php echo $cartItem['product_id']?>"
    data-variable-action="edit"
    data-cart-item-key="<?php echo $cartKey?>"
>
    <?php
        if(!empty($icon))
            echo "<span class='edit-variable-product-cart-icon'>". htmlspecialchars($icon) ."</span>"
    ?>
    <span><?php echo $label?></span>
</button>
