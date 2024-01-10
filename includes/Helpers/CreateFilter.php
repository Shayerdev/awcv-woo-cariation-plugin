<?php

namespace awcv\Helpers;

class CreateFilter
{
    protected $action, $args, $dataFilter;

    /**
     * @param string $action
     * @param array $args
     */
    public function __construct(string $action, array $args)
    {
        $this->action = $action;
        $this->args = $args;
        $this->dataFilter = $this->apply();
    }

    /**
     * @return mixed
     */
    protected function apply()
    {
        return apply_filters(AWCV_SLUG . "_" . $this->action, $this->args);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->dataFilter;
    }
}
