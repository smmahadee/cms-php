<?php

namespace App\Admin\Controller;

use App\Repository\UsersRepository;

class LoginAdminController extends AbstractAdminController {

    public function __construct( UsersRepository $usersRepository) {
        parent::__construct($usersRepository);
    }

    public function login() {
        $isLoggedIn = $this->usersRepository->isLoggedIn();

        if($isLoggedIn) {
            header('Location: index.php?route=admin/pages');
            die();
        }
        
        $errors = [];

        if(!empty($_POST)){
            $username = @(string) $_POST['username'] ?? '';
            $password = @(string) $_POST['password'] ?? '';

            if(!empty($username) &&!empty($password)){
                $user = $this->usersRepository->findUserByUsernameAndPassword($username, $password);

                if($user){
                    // Login successful
                    // Redirect to admin dashboard
                    header('Location: index.php?route=admin/pages');
                    exit;
                } else {
                    $errors[] = 'Invalid username or password.';
                }
            }else {
                $errors[] = 'Please make sure that both input fields are filled out.';
            }
        }

        $this->render('pages/login', [
            'username' => $username ?? '',
            'errors' => $errors
        ]);
    }

    public function logout() {
        $this->usersRepository->ensureSessoin();
        session_unset();
        session_destroy();
        header('Location: index.php?route=admin/login');
        exit;
    }
}