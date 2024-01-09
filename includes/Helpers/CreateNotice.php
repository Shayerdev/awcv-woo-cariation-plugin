<?php

    namespace awcv\Helpers;

class CreateNotice
{
    protected $msg, $type;
    public function __construct(string $msg, string $type = "error")
    {
        $this->msg = $msg;
        $this->type = $type;
        $this->displayNotice();
    }

    public function displayNotice()
    {
        add_action('admin_notices', [$this, "connectTemplate"]);
    }

    public function connectTemplate()
    {
        try {
            $message = $this->msg;
            $plugin_file_path = plugin_dir_path(AWCV_PLUGIN_DIR) . "templates/notice/{$this->type}.php";
            if (file_exists($plugin_file_path)) {
                include $plugin_file_path;
            } else {
                throw new \Exception("File template notice not detect", 0);
            }
        } catch (\Exception $e) {
            error_log($e);
        }
    }
}
