<?php

namespace App\Controllers;
use App\Models\User;

class UserController extends Controller{

    public function show($id){
       
        $userModel = new User();
        $user = $userModel->find ($id);
        
        return $this->view('user.profile', ['user' => $user]);
       
    }

    public function edit($id){
        return "aqui se mostrará el formulario para editar un usuario ";
    }

}

