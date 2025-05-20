<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller{

    public function login(){
        return $this->view('auth.login');
    }

    public function loginPost()
    {
        session_start();

        $username = $_POST['userName'];
        $password = $_POST['password'];

        $userModel = new User();
        $userModel->hidden = [];
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

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $birth_date = $_POST['birth_date'] ?? '';
        
            // Validación básica
            if (!$fullname || !$username || !$email || !$password || !$birth_date) {
                $_SESSION['error'] = 'Todos los campos obligatorios deben ser completados.';
                return header('Location: /register');
            }
        
            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
            // Procesar imagen como BLOB
            $profile_photo = null;
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $profile_photo = file_get_contents($_FILES['profile_photo']['tmp_name']);
            }
        
            $userModel = new User();
        
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;
        
            $user = $userModel->create([
                'fullname' => $fullname,
                'username' => strtolower($username),
                'email' => strtolower($email),
                'password' => $hashedPassword,
                'birth_date' => $birth_date,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        
            // Crear sesión y redirigir
            $_SESSION['user'] = $user;
            header('Location: /');
            exit;
        }

        return $this->view('auth.register');
    }
    
}