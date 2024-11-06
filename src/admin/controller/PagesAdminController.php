<?php

namespace App\Admin\Controller;

use App\Repository\PagesRepository;
use App\Repository\UsersRepository;

class PagesAdminController extends AbstractAdminController
{

    public function __construct(UsersRepository $usersRepository, private PagesRepository $pagesRepository) {
        parent::__construct($usersRepository);
    }

    public function index()
    {
        $pages = $this->pagesRepository->fetchNavigation();
        $this->render('pages/index', [
            'pages' => $pages
        ]);
    }


    public function create()
    {
        $errors = [];

        if (!empty($_POST)) {
            $title = @(string)  $_POST['title'] ?? '';
            $slug = @(string)  $_POST['slug'] ?? '';
            $content = @(string) $_POST['content'] ?? '';

            $slug = strtolower($slug);
            $slug = str_replace([' ', '.'], ['-', '-'], $slug);
            $slug = preg_replace('/[^a-zA-Z0-9]/', '',  $slug);

            if (!empty($title) && !empty($slug) && !empty($content)) {
                if (empty($this->pagesRepository->isSlugExists($slug))) {
                    $this->pagesRepository->insert(['title' => $title, 'slug' => $slug, 'content' => $content]);
                    header('Location: index.php?route=admin/pages');
                } else {
                    $errors[] = 'Slug already exists.';
                }
            } else {
                $errors[] = 'All fields are required.';
            }
        }
        $this->render('pages/create', [
            'errors' => $errors
        ]);
    }

    public function edit() {
        $errors = [];
        $id = @(int) ($_GET['id'] ?? 0);
        
        if (!empty($_POST)) {
            $title = @(string) ($_POST['title'] ?? '');
            $content = @(string) ($_POST['content'] ?? '');
            if (!empty($title) && !empty($content)) {
                $this->pagesRepository->updateTitleAndContent(
                    $id,
                    $title,
                    $content
                );
                header("Location: index.php?route=admin/pages");
                return;
            }
            else {
                $errors[] = 'Please make sure that both input fields are filled out';
            }
        }
        
        $page = $this->pagesRepository->fetchById($id);

        $this->render('pages/edit', [
            'page' => $page,
            'errors' => $errors
        ]);
    }
    public function delete()
    {
        $id = @(int) $_POST['id'];
        $errors = [];

        $result = $this->pagesRepository->delete($id);
        if ($result === false) {
          $errors[] = 'Delete failed.';
        }
        header('Location: index.php?route=admin/pages');
    }
}
