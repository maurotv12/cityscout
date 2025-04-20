<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller{

    public function login(){
        return $this->view('auth.login');
    }

    public function register(){
        return $this->view('auth/register');
    }

    public function loginPost()
    {
        session_start();

        $username = $_POST['userName'];
        $password = $_POST['password'];

        $userModel = new User();
        $user = $userModel->where('username', '=', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /'); // Redirige al inicio o dashboard
            exit;
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas';
            header('Location: /login');
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
    
}