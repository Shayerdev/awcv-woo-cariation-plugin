<?php

namespace awcv\Localize;

use awcv\Helpers;

class CartVariationLocalize extends Helpers\CreateLocalization
{
    protected $nameScript;

    /**
     * @param $relationScript
     */
    public function __construct($relationScript)
    {
        $this->nameScript = $relationScript;
        $this->varName = "cart_variation_localize";
        parent::__construct($relationScript, $this->varName, $this->options());
    }

    /**
     * @return array
     */
    public function options(): array
    {
        return array(
            'url' => admin_url('admin-ajax.php')
        );
    }
}
