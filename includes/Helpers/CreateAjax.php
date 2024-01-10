<?php

namespace awcv\Helpers;

class CreateAjax
{
    protected $prefix, $action, $callback, $front;

    /**
     * @param string $action
     * @param $callback
     * @param bool $front
     */
    public function __construct(string $action, $callback, bool $front = true)
    {
        $this->prefix = "wp_ajax_";
        $this->action = $action;
        $this->callback = $callback;
        $this->front = $front;

        # Hook Init Ajax
        $this->registration();
    }

    /**
     * @return void
     */
    public function registration()
    {
        # Add ajax for Register user
        add_action($this->prefix . $this->action, array($this, "callback"));
        # Add ajax for Unregister user
        if ($this->front) {
            add_action($this->prefix . 'nopriv_' . $this->action, array($this, "callback"));
        }
    }
}
