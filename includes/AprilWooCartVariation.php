<?php

namespace awcv;

use awcv\Ajax;
use awcv\Assets;
use awcv\Customizer;
use awcv\Localize;

class AprilWooCartVariation
{
    public static $idCartMainScript = "cart_variation_script";

    /**
     * Connect assets for Cart variation
     * @return void
     */
    public static function initAssets()
    {
        new Assets\CartVariationScript(self::$idCartMainScript);
        new Assets\CartVariationStyle();
    }

    /**
     * Connect localize data for Cart variation
     * @return void
     */
    public static function initLocalize()
    {
        new Localize\CartVariationLocalize(self::$idCartMainScript);
    }

    /**
     * Connect ajax endpoint for Cart variation
     * @return void
     */
    public static function initAjax()
    {
        new Ajax\AjaxVariableForm(self::$idCartMainScript);
        new Ajax\AjaxVariableUpdate(self::$idCartMainScript);
    }

    /**
     * Connect Customize filters for cart. Replace basic layout
     * @return void
     */
    public static function initCustomizer()
    {
        # Init Cart Product Item Customizer
        Customizer\Cart::changeTitleItem();
        Customizer\Cart::selectedVariablesItems();
        Customizer\Cart::addPriceProductAfterName();
        Customizer\Cart::addButtonEditVariable();
        Customizer\Cart::removeQuantityColumn();
    }
}
