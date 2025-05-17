<?php

namespace App\Http\Controllers;

class BaseController
{
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(?string $template = null, object|array $variables = [])
    {
        $templatePath = 'public/views/' . $template . '.php';
        $layoutPath = 'public/views/layout.php';
        $output = 'File not found';

        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $content = ob_get_clean();

            if (file_exists($layoutPath)) {
                ob_start();
                include $layoutPath;
                $output = ob_get_clean();
            } else {
                $output = $content;
            }
        }

        print $output;
    }
}
