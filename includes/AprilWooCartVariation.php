<?php

namespace awcv;

use awcv\ajax;
use awcv\Assets;
use awcv\Customizer;
use awcv\Localize;

class AprilWooCartVariation
{
    public static $idCartMainScript = "cart_variation_script";

    public static function initAssets()
    {
        new Assets\CartVariationScript(self::$idCartMainScript);
        new Assets\CartVariationStyle();
    }

    public static function initLocalize()
    {
        new Localize\CartVariationLocalize(self::$idCartMainScript);
    }

    public static function initAjax()
    {
        new ajax\AjaxVariableForm(self::$idCartMainScript);
        new ajax\AjaxVariableUpdate(self::$idCartMainScript);
    }

    /**
     * @throws \Exception
     */
    public static function initCustomizer()
    {
        # Init Cart Product Item Customizer
        Customizer\Cart::changeTitleItem();
        Customizer\Cart::selectedVariablesItems();
        Customizer\Cart::addStaticLabelQuantity();
        Customizer\Cart::addPriceProductAfterName();
        Customizer\Cart::addButtonEditVariable();
        Customizer\Cart::removeQuantityColumn();
    }
}
