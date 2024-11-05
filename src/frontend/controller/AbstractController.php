<?php

namespace App\Frontend\Controller;

use App\Repository\PagesRepository;

class AbstractController {
    public function __construct(protected PagesRepository $pagesRepository)
    {
        
    }

    protected function render($view, $params)
    {
        extract($params);

        ob_start();
        require __DIR__ . '/../../../views/frontend/' . $view . '.view.php';
        $contents = ob_get_clean();

        $navPages = $this->pagesRepository->fetchNavigation();

        require __DIR__ . '/../../../views/frontend/layouts/main.view.php';
    }

    protected function error404() {
        $this->render('abstract/notFound', []);
    }
}