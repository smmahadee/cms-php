<?php

namespace App\Frontend\Controller;

use App\Repository\PagesRepository;

class PagesController extends AbstractController
{
    public function __construct( PagesRepository $pagesRepository) {
        parent::__construct($pagesRepository);
    }

    public function showPage($slug)
    {
        $data =   $this->pagesRepository->fetchBySlug($slug);

        if($data === null) {
            return $this->error404();
        }

        $this->render('pages/index', [
            'page' => $data
        ]);
    }
}
