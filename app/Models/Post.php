<?php

namespace App\Models;
use App\Models\Model;
use App\Models\Comment;
use App\Models\User;
use App\Models\Like;


class Post extends Model
{
  protected $table = 'posts';

public function getFollowedUsersPosts($user_id) {
    $postModel = new Post();
    $userModel = new User();
    $commentModel = new Comment();
    $likeModel = new Like();
    $followerModel = new Follower(); // Asegúrate de tener un modelo para los seguidores

  
    // Llamar al modelo followers para ver los ids de los usuarios qiue siogue el usuario logueado 
    $followedUsers = $followerModel->where('user_follower_id', $user_id)->get();

    // consultar los posts relacionados a los ids de los usuarios seguidos followedUsers
}

  public function getPostsByUser($user_id) {
    $postModel = new Post();
    $userModel = new User();
    $commentModel = new Comment();
    $likeModel = new Like();

    $posts = $postModel->where('user_id', $user_id)->get();
    $posts = array_map(function ($post) use ($userModel, $commentModel, $likeModel) {
        $post['comments'] = $commentModel->getComments($post['id']);
        $post['user'] = $userModel->getUser($post['user_id']);
        $post['likes'] = $likeModel->getLikes($post['id']);
        return $post;
    }, $posts);
    return $posts;
  }

}