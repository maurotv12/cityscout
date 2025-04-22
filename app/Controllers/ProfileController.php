<?php

namespace App\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
   
    public function profile(){
        return $this->view('user.profile');
    }
    
    public function show($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($_SESSION['user_id']);

        return $this->view('user.profile', ['user' => $user]);
    }

    public function edit()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($_SESSION['user_id']);

        return $this->view('perfil.edit', ['user' => $user]);
    }

    public function update()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();

        $data = [
            'fullname' => $_POST['fullname'] ?? '',
            'email' => $_POST['email'] ?? '',
        ];

        if (!empty($_FILES['profile_photo']['tmp_name'])) {
            $data['photo'] = file_get_contents($_FILES['profile_photo']['tmp_name']);
        }

        $user = $userModel->update($_SESSION['user_id'], $data);

        header('Location: /perfil');
        exit;
    }
}
