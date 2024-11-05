<?php

namespace App\Admin\Controller;



class AbstractAdminController {
    protected function render($view, $params)
    {
        extract($params);

        ob_start();
        require __DIR__ . '/../../../views/admin/' . $view . '.view.php';
        $contents = ob_get_clean();

        require __DIR__ . '/../../../views/admin/layouts/main.view.php';
    }

    protected function error404() {
        $this->render('abstract/notFound', []);
    }
}