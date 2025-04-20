<?php

namespace App\Controllers;

class UserController extends Controller{

    public function show($id){
        return "aqui se mostrará el detalle de un usuario ";
    }

    public function edit($id){
        return "aqui se mostrará el formulario para editar un usuario ";
    }

}