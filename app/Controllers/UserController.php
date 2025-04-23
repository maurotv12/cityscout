<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Post;

class UserController extends Controller{

    public function show($id){
       
        $userModel = new User();
        $postModel = new Post();
        $user = $userModel->find ($id);
        $posts = $postModel->where('user_id', $id)->get();
        
        return $this->view('user.profile', ['user' => $user, 'posts' => $posts]);
       
    }

    public function edit($id){
        return "aqui se mostrará el formulario para editar un usuario ";
    }

}

