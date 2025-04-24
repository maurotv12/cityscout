<?php

namespace App\Models;
use App\Models\Model;


class User extends Model
{
  protected $table = 'users';
  
  public function getUser($user_id) {
    $userModel = new User;
    return $userModel->find($user_id);
  }
}