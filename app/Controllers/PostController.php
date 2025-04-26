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



    public function store()
    {
        
        $userId = $_SESSION['user']['id'];
        $caption = $_POST['caption'] ?? '';
        $uploadedFiles = $_FILES['files'] ?? null;

        // return $this->json(['success' => false, 'message' => $caption], 400);

        if (!$uploadedFiles || empty($uploadedFiles['name'][0])) {
            return $this->json(['success' => false, 'message' => 'No se seleccionaron archivos.'], 400);
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'mp4'];
        $uploadDir = __DIR__ . '/../../public/assets/images/posts/';
        $fileData = [];

        foreach ($uploadedFiles['name'] as $index => $name) {
            $tmpName = $uploadedFiles['tmp_name'][$index];
            $error = $uploadedFiles['error'][$index];
            $size = $uploadedFiles['size'][$index];

            if ($error === UPLOAD_ERR_OK) {
                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($extension, $allowedExtensions)) {
                    return ['success' => false, 'message' => 'Formato de archivo no permitido.'];
                }

                $timestamp = time() . '_' . uniqid();
                $fileName = $timestamp;
                $filePath = $uploadDir . $fileName . '.' . $extension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $fileData[] = [
                        'user_id' => $userId,
                        'file_name' => $fileName,
                        'type' => $extension,
                        'caption' => $caption,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                } else {
                    return ['success' => false, 'message' => 'Error al guardar el archivo.'];
                }
            } else {
                return ['success' => false, 'message' => 'Error al subir el archivo.'];
            }
        }

        // Guardar en la base de datos
        $postModel = new Post();
        foreach ($fileData as $data) {
            $postModel->create($data);
        }
      
        return ['success' => true, 'message' => 'Publicación creada con éxito.'];
    }


}
