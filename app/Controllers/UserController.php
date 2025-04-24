<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class UserController extends Controller
{

    public function show($id)
    {

        $userModel = new User();
        $postModel = new Post();
        $commentModel = new Comment();

        $user = $userModel->find($id);
        $posts = $postModel->getPostsByUser($id);

        return $this->view('user.profile', ['user' => $user, 'posts' => $posts]);
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            http_response_code(404);
            return $this->view('errors.404', ['message' => 'Usuario no encontrado']);
        }

        return $this->view('user.edit', ['user' => $user]);
    }

    
    public function update($id)
    {
       
        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            http_response_code(404);
            return $this->view('errors.404', ['message' => 'Usuario no encontrado']);
        }

        return $this->view('user.edit', ['user' => $user]);
    }


    public function updateBio($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener la biografía enviada desde el formulario
        $bio = $_POST['bio'] ?? '';

        // Actualizar la biografía en la base de datos
    $updated = $userModel->update($id, ['bio' => $bio]);

    if ($updated) {
        // Devolver una respuesta JSON con éxito
        return $this->json(['success' => true, 'bio' => $bio]);
    } else {
        // Devolver un error si la actualización falla
        return $this->json(['error' => 'No se pudo actualizar la biografía'], 500);
    }
    }
 
}
