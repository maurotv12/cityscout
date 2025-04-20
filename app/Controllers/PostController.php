<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;

class PostController extends Controller{


    public function index(){
        
        $userModel = new User;
        $messages = [];

        $users = $userModel->all();

        return $this->view('post.feed');
    }

    public function create(){
        $model = new User;
        $model = new Post;

        $users = $model->all();

        return $this->view('post.create');
    }

    public function post($id){
        return "aqui se mostrará el feed  ";
    }

}