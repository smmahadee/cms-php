<?php

namespace App\Repository;

use App\Model\PageModel;
use PDO;

class PagesRepository {
    public function __construct(public PDO $pdo)
    {
        
    }

    public function fetchNavigation() {
        $stmt = $this->pdo->prepare('SELECT * FROM `pages`');
        $stmt->execute();
 
        return $stmt->fetchAll(PDO::FETCH_CLASS, PageModel::class);
    }

    public function fetchBySlug(string $slug): ?PageModel {
        $stmt = $this->pdo->prepare('SELECT * FROM `pages` WHERE `slug` = :slug');
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, PageModel::class);
        $entry = $stmt->fetch();

        if($entry) {
            return $entry;
        }else {
            return null;
        }
    }
}