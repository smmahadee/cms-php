<?php

namespace App\Frontend\Controller;

class AbstractController {
    protected function render($view, $params)
    {
        extract($params);

        ob_start();
        require __DIR__ . '/../../../views/' . $view . '.view.php';
        $contents = ob_get_clean();

        require __DIR__ . '/../../../views/frontend/layouts/main.view.php';
    }
}