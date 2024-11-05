<?php

namespace App\Repository;

use App\Model\PageModel;
use PDO;

class PagesRepository
{
    public function __construct(public PDO $pdo) {}

    public function fetchNavigation()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `pages` ORDER BY `id` ASC');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, PageModel::class);
    }

    public function fetchBySlug(string $slug): ?PageModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `pages` WHERE `slug` = :slug');
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, PageModel::class);
        $entry = $stmt->fetch();

        if ($entry) {
            return $entry;
        } else {
            return null;
        }
    }

    public function isSlugExists($slug) {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS count from `pages` WHERE `slug` = :slug');
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($result['count'] >= 1);
    }

    public function insert(array $data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO `pages` (`slug`, `title`, `content`) values (:slug, :title, :content)');
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':content', $data['content']);
        return $stmt->execute($data);
    }

    public function delete(int $id){
        $stmt = $this->pdo->prepare('DELETE FROM `pages` WHERE `id` = :id');
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function update(int $id, array $data){
        $stmt = $this->pdo->prepare('UPDATE `pages` SET `slug` = :slug, `title` = :title, `content` = :content WHERE `id` = :id');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':content', $data['content']);
        return $stmt->execute();
    }

    public function fetchById(int $id): ?PageModel {
        $stmt = $this->pdo->prepare('SELECT * FROM `pages` WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, PageModel::class);
        $entry = $stmt->fetch();
        if (!empty($entry)) {
            return $entry;
        }
        else {
            return null;
        }
    }

    public function updateTitleAndContent(int $id, string $title, string $content) {
        $stmt = $this->pdo->prepare('UPDATE `pages` 
            SET `title` = :title, `content` = :content 
            WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':content', $content);
        $stmt->execute();
    }
}
