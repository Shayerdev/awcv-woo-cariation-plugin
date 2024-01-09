<?php

namespace awcv\Assets;

use awcv\Helpers;

class CartVariationScript extends Helpers\CreateScript
{
    protected $nameScript;
    public function __construct($nameScript)
    {
        $this->nameScript = $nameScript;
        $this->forAdmin = false;
        parent::__construct($this->options(), $this->forAdmin);
    }

    public function options(): array
    {
        return array(
           'name' => $this->nameScript,
           'src' =>  plugins_url('public/dist/js/main_scripts.js', AWCV_PLUGIN_DIR),
           'deps' => array('wc-add-to-cart-variation'),
           'version' => AWCV_VERSION,
           'in_footer' => true
        );
    }
}
