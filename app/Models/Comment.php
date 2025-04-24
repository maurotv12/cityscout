<?php

namespace App\Models;
use App\Models\Model;
use App\Models\User;



class Comment extends Model
{
  protected $table = 'comments';

  public function getComments($post_id) {
    $commentModel = new Comment;
    $userModel = new User;

    $comments = $commentModel->where('post_id', $post_id)->get();

    $comments = array_map(function($comment) use ($userModel){
        $comment['user'] = $userModel->getUser($comment['user_id']);
        return $comment;
    }, $comments);
    return $comments;
  }

}