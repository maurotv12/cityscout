
<?php

namespace App\Controllers;

use App\Models\User;

class CreatePostController extends Controller{


public function create(){
        return $this->view('post.post/create');
    }



}