<?php

/**
 * Plugin Name: Woo Variation for Cart
 * Plugin URI: https://github.com/Shayerdev/awcv-woo-cariation-plugin
 * Description: Simple plugin for WooCommerce Update Variations In Cart.
 * Version: 1.0
 * Requires PHP: 5.6
 * Author: Shayer Developer
 * Text Domain: example.com
 * Domain Path: /src/lang
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once 'vendor/autoload.php';
include_once ABSPATH . 'wp-admin/includes/plugin.php';

use awcv\AprilWooCartVariation;
use awcv\Helpers;

# Root folder
const AWCV_PLUGIN_DIR = __FILE__;
const AWCV_SLUG = "awcv";
const AWCV_VERSION = "1.0";
const AWCV_LOCALE_STR = "awcv";

# Check active WooCommerce
if (!is_plugin_active('woocommerce/woocommerce.php')) {
    # Display Notice Error if WooCommerce not active or not found
    new Helpers\CreateNotice(
        "WooCommerce plugin not active. Current plugin need installed or active WooCommerce plugin",
        "error"
    );

    # Diactivate plugin
    deactivate_plugins(plugin_basename(__FILE__));

    # exit
    exit;
}

AprilWooCartVariation::initAssets();
AprilWooCartVariation::initLocalize();
AprilWooCartVariation::initAjax();
AprilWooCartVariation::initCustomizer();
