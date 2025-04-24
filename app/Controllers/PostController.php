<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostController extends Controller{


    public function index(){
        
        $userModel = new User;
       
        $postModel = new Post;
        $posts = $postModel->getFollowedUsersPosts($_SESSION['user']['id']);

        // The $users variable is being assigned here but is not used anywhere in the method.
        $users = $userModel->all();

        return $this->view('post.feed', ['posts' => $posts, 'users' => $users]);
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

    public function getComments($postId)
    {
        $commentModel = new Comment();
        $comments = $commentModel->getComments($postId); 

        return ['success' => true, 'comments' => $comments];
    }

}