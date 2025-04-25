<?php

namespace App\Models;
use App\Models\Model;
use App\Models\Comment;
use App\Models\User;
use App\Models\Like;
use App\Models\Follower;

class Post extends Model
{
  protected $table = 'posts';

public function getFollowedUsersPosts($user_id) {
    $followerModel = new Follower();
    $commentModel = new Comment();
    $likeModel = new Like();
    $userModel = new User();

    // Obtener los IDs de los usuarios seguidos por el usuario actual
    $followedUsers = $followerModel->where('user_follower_id', $user_id)->get();

    // Extraer los IDs de los usuarios seguidos
    $followedUserIds = array_map(function ($follower) {
        return $follower['user_followed_id'];
    }, $followedUsers);

    if (empty($followedUserIds)) {
        return []; // Si no sigue a nadie, devolver un array vacío
    }

    // Obtener los posts de los usuarios seguidos
    $placeholders = implode(',', array_fill(0, count($followedUserIds), '?'));
    $sql = "
        SELECT posts.*
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE posts.user_id IN ($placeholders)
        ORDER BY posts.created_at DESC
    ";

    $posts = $this->query($sql, $followedUserIds)->get();

    // Agregar información adicional a cada post
    $posts = array_map(function ($post) use ($commentModel, $likeModel, $userModel) {
        $post['comments'] = $commentModel->getComments($post['id']);
        $post['comment_count'] = count($post['comments']);
        $post['likes'] = $likeModel->getLikes($post['id']);
        $post['like_count'] = count($post['likes']);
        $post['user'] = $userModel->getUser($post['user_id']);
        return $post;
    }, $posts);

    return $posts;
}

  public function getPostsByUser($user_id) {
    $postModel = new Post();
    $userModel = new User();
    $commentModel = new Comment();
    $likeModel = new Like();

    $posts = $postModel->where('user_id', $user_id)->get();

    $posts = array_map(function ($post) use ($userModel, $commentModel, $likeModel) {
        $post['comments'] = $commentModel->getComments($post['id']);
        $post['comment_count'] = count($post['comments']);
        $post['likes'] = $likeModel->getLikes($post['id']);
        $post['like_count'] = count($post['likes']);
        $post['user'] = $userModel->getUser($post['user_id']);
        
        return $post;
    }, $posts);
    return $posts;
  }

}