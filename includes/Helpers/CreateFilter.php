<?php

namespace awcv\Helpers;

class CreateFilter
{
    protected $action, $args, $dataFilter;

    public function __construct(string $action, array $args)
    {
        $this->action = $action;
        $this->args = $args;
        $this->dataFilter = $this->apply();
    }

    protected function apply()
    {
        return apply_filters(AWCV_SLUG . "_" . $this->action, $this->args);
    }

    public function get()
    {
        return $this->dataFilter;
    }
}
