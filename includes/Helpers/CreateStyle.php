<?php

namespace awcv\Helpers;

class CreateStyle
{
    protected $options, $forAdmin;
    public function __construct(
        array $options,
        bool $forAdmin = false
    ) {
        $this->options = $options;
        $this->forAdmin = $forAdmin;

        # Init hook append File
        $this->connect();
    }

    public function connect()
    {
        if (is_admin() && !$this->forAdmin) {
            return;
        }

        (!$this->forAdmin)
            ? $this->enqueue()
            : add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function enqueue()
    {
        wp_enqueue_style(
            $this->options['name'],
            $this->options['src'],
            $this->options['deps'],
            $this->options['version'],
            $this->options['media']
        );
    }
}
