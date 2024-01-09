<?php

namespace awcv\Helpers;

class CreateLocalization
{
    public $relationScript, $varName, $data;

    public function __construct($relationScript, $varName, $data)
    {

        $this->relationScript = $relationScript;
        $this->varName = $varName;
        $this->data = $data;

        # Hook Init Localization
        add_action('init', array($this, "registrationLocalize"), 15);
    }

    public function registrationLocalize()
    {
        $data = array_merge($this->data, array(
            'nonce' => wp_create_nonce($this->relationScript)
        ));
        wp_localize_script(
            $this->relationScript,
            $this->varName,
            $data
        );
    }
}
