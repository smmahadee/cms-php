<?php

use App\Frontend\Controller\NotFoundController;

require __DIR__ . '/inc/all.inc.php';

$page = @(string) ($_GET['page'] ?? '');

if($page === 'index') {
    echo "TODO: Create index page";
}else {
    $notFoundController = new NotFoundController();
    $notFoundController->error404();
}