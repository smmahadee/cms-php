<?php

namespace App\Admin\Controller;

use App\Repository\UsersRepository;

class AbstractAdminController {

    public function __construct(protected UsersRepository $usersRepository)
    {
        
    }
    protected function render($view, $params)
    {
        extract($params);

        ob_start();
        require __DIR__ . '/../../../views/admin/' . $view . '.view.php';
        $contents = ob_get_clean();

        $isLoggedIn = $this->usersRepository->isLoggedIn();

        require __DIR__ . '/../../../views/admin/layouts/main.view.php';
    }

    protected function error404() {
        $this->render('abstract/notFound', []);
    }
}