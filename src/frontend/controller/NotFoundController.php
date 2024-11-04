<?php

namespace App\Frontend\Controller;

class NotFoundController extends AbstractController
{

    public function error404() {
        $this->render('frontend/notFound', []);
    }
}
