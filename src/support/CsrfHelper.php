<?php

namespace App\Support;

class CsrfHelper
{
    public function ensureSession()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function generateToken()
    {
        $this->ensureSession();
        if (empty($_SESSION['csrfToken'])) {
            $token = bin2hex(random_bytes(32));
            $_SESSION['csrfToken'] = $token;
        }

        return $_SESSION['csrfToken'];
    }

    public function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->ensureSession();
            if (
                !empty($_POST['_csrf']) &&
                !empty($_SESSION['csrfToken']) &&
                $_POST['_csrf'] === $_SESSION['csrfToken']
            ) {
                unset($_SESSION['csrfToken']);
                return;
            }


            http_response_code(419);
            echo "Error: CSRF token mismatch";
            var_dump($_POST);
            var_dump($_SESSION);
            die();
        }
    }
}
