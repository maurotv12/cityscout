<?php

namespace App\Controllers;

use App\Models\User;

class HomeController extends Controller
{

    public function index()
    {
        $userModel = new User();

        //return $userModel->where('id','>=',2)->get();
        //return $userModel ->all();

        //return $userModel->find(3);

        // return $userModel->create(
        //     ['fullname' => 'Mauricio 5', 
        //     'email' => 'Mauricio@gmail.com',
        //     'password' => '123456']);

        // return $userModel->update(3,
        //     ['fullname' => 'Mauricio 24', 
        //     'email' => 'Mauricio@gmail.com']);

        // $userModel->delete(6);
        // return "eliminado";
        
        // return $userModel->where("fullname", "Mauricio' OR 'a' = 'a")->get();

            return $this->view('post.feed', 
        [
            'title' => 'Home',
            'description' => 'Esta es la pagina home'
        ]);
    }



}

