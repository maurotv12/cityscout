<?php

namespace App\Models;
use App\Models\Model;
use App\Models\User;



class Like extends Model
{
  protected $table = 'likes';
  
  public function getLikes($post_id) {
    $likeModel = new Like;
    return $likeModel->where('post_id', $post_id)->get();
  }
}