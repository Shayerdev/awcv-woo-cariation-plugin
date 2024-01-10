<h1>Simple plugin for display and change variable for product in Cart.</h1>
<p><b>Warning:</b> Current plugin work only with basic [woocommerce-cart] shortcode. And replace some moments in layout.</p>
<h2>Plugin actions</h2>

```php
add_action("awcv_quantity_label") # Add custom label
```
<h2>Plugin filters</h2>
```php

add_filter("awcv_quantity_label", function($label){
    return $label;
});

add_filter("awcv_product_variables_action_cancel_label", function($button_label){
    return $button_label;
});

add_filter("awcv_product_variables_action_update_label", function($button_label){
    return $button_label;
});

add_filter("awcv_button_edit_cart_variable", function($attr_btn){
    return array(
        "icon" => "",
        "class" => "edit-variable-product-cart-icon",
        "label" => __("Edit", AWCV_SLUG)
    );
});

```
<h2>Development guide</h2>
<h3>Composer guide</h3>
```bash
composer install # Install composer dependency
composer update  # Update dependency
composer build   # build app
```
<h3>CodeSniffer php</h3>
```bash
vendor/bin/phpcs --standard=PSR12 .  # Test code
vendor/bin/phpcbf --standard=PSR12 . # Autofix code
```
<h3>NPM guide</h3>
```bash
npm install # Install node dependency
npm update  # Update dependency
```
<h3>Webpack guide</h3>
```bash
npm run watch # Development mode
npm run build # Build app
```