<?php

namespace awcv\Assets;

use awcv\Helpers;

class CartVariationStyle extends Helpers\CreateStyle
{
    protected $nameScript;

    public function __construct()
    {
        $this->nameScript = "awcv_variation_cart_style";
        parent::__construct($this->options());
    }

    /**
     * @return array
     */
    public function options(): array
    {
        return array(
            'name' => $this->nameScript,
            'src' =>  plugins_url('public/dist/css/main_styles.css', AWCV_PLUGIN_DIR),
            'deps' => array(),
            'version' => AWCV_VERSION,
            'media' => 'screen'
        );
    }
}
