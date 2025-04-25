<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;

class PostController extends Controller
{


    public function index()
    {
        $postModel = new Post;
        $posts = $postModel->getFollowedUsersPosts($_SESSION['user']['id']);

        return $this->view('post.feed', ['posts' => $posts]);
    }

    public function create()
    {
        $model = new User;
        $model = new Post;

        $users = $model->all();

        return $this->view('post.create');
    }

    public function post($id){
        return "aqui se mostrará el feed";
    }

    public function getComments($postId)
    {
        $commentModel = new Comment();
        $comments = $commentModel->getComments($postId);

        if (!$comments) {
            return ['success' => false, 'message' => 'No se encontraron comentarios.'];
        }

        return ['success' => true, 'message' => 'funciono', 'comments' => $comments];
    }

    public function toggleLike($postId){
        $likeModel = new Like();
        $userId = $_SESSION['user']['id'];

        // Verificar si el usuario ya dio like
        $existingLike = $likeModel->where('post_id', $postId)->where('user_id', $userId)->first();

        if ($existingLike) {
            // Quitar like
            $likeModel->delete($existingLike['id']);
            return $this->json(['success' => true, 'liked' => false]);
        } else {
            // Dar like
            $likeModel->create(['post_id' => $postId, 'user_id' => $userId, 'created_at' => date('Y-m-d H:i:s')]);
            return $this->json(['success' => true, 'liked' => true]);
        }
    }
}
