<?php

namespace App\Repository;

use PDO;

class UsersRepository
{
    public function __construct(private PDO $pdo) {}

    public function ensureSessoin() {
        if(!session_id()){
            session_start();
        }
    }
    public function findUserByUsernameAndPassword($username, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `username` = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {

            // GENERATE SESSION DATA
           $this->ensureSessoin();
            $_SESSION['adminUserId'] = $user['id'];
            session_regenerate_id();

            return $user;
        } else {
            return null;
        }
    }

    public function isLoggedIn(){
       $this->ensureSessoin();
        return !empty($_SESSION['adminUserId']);
    }

    public function ensureLoggedIn() {
        $isLoggedIn = $this->isLoggedIn();

        if(empty($isLoggedIn)) {
            header('Location: index.php?' . http_build_query(['route' => 'admin/login']));
            die();
        }
    }
}
