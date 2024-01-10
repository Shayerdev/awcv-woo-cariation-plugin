<?php

namespace awcv\Helpers;

class CreateLocalization
{
    public $relationScript, $varName, $data;

    /**
     * @param $relationScript
     * @param $varName
     * @param $data
     */
    public function __construct($relationScript, $varName, $data)
    {

        $this->relationScript = $relationScript;
        $this->varName = $varName;
        $this->data = $data;

        # Hook Init Localization
        add_action('init', array($this, "registrationLocalize"), 15);
    }

    /**
     * @return void
     */
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
