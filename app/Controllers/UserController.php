<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Follower;
use App\Models\Interest;
use App\Models\Post;

use App\Models\User;
use App\Models\UserInterest;

class UserController extends Controller
{

    // Nueva función para formatear números al estilo followers.js
    private function formatNumber($number)
    {
        if ($number < 10000) {
            return number_format($number, 0, '', '.');
        } else if ($number < 1000000) {
            // Miles, sin decimales si es exacto, con uno si no es exacto
            $miles = floor($number / 1000);
            $resto = $number % 1000;
            if ($resto === 0) {
                return $miles . ' mil';
            } else {
                $dec = floor(($number % 1000) / 100); // Un decimal, truncado
                return $miles . ($dec > 0 ? ',' . $dec : '') . ' mil';
            }
        } else if ($number < 100000000) {
            // Millones, con un decimal si no es exacto
            $millones = floor($number / 1000000);
            $resto = $number % 1000000;
            if ($resto === 0) {
                return $millones . ' mill';
            } else {
                $dec = floor(($number % 1000000) / 100000); // Un decimal, truncado
                return $millones . ($dec > 0 ? ',' . $dec : '') . ' mill';
            }
        } else {
            // 100 millones o más, sin decimales
            $millones = floor($number / 1000000);
            return $millones . ' mill';
        }
    }

    public function show($username)
    {
        $userModel = new User();
        $postModel = new Post();
        $followerModel = new Follower();

        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            http_response_code(404);
            return $this->view('errors.404', ['message' => 'Usuario no encontrado']);
        }
        $id = $user['id'];
        $posts = $postModel->getPostsByUser($id);

        session_start();
        if (!isset($_SESSION['user'])) {
            //filtrar el objeto posts para que solo muestre las primeras 3 publicaciones
            $posts = array_slice($posts, 0, 3);
            // Marcar todas las publicaciones como "blurred"
            foreach ($posts as &$post) {
                $post['is_blurred'] = true;
            }
        }
        // Contar publicaciones
        $postCount = $postModel->where('user_id', $id)->get();
        $postCount = count($postCount);

        // Contar seguidores
        $followersCount = $followerModel->where('user_followed_id', $id)->get();
        $followersCount = count($followersCount);

        // Contar seguidos
        $followingCount = $followerModel->where('user_follower_id', $id)->get();
        $followingCount = count($followingCount);

        // Verificar si el usuario actual sigue al perfil que está viendo usando solo modelos
        if (!isset($_SESSION['user'])) {
            $isFollowing = false; // Si no hay sesión, no puede seguir
        } else {
            $isFollowing = $followerModel
                ->where('user_follower_id', $_SESSION['user']['id'])
                ->where('user_followed_id', $id)
                ->first();
            $isFollowing = $isFollowing ? true : false; // Fuerza a booleano
        }

        return $this->view('user.profile', [
            'posts' => $posts,
            'user' => $user,
            'postCount' => $postCount,
            'followersCount' => $this->formatNumber($followersCount),
            'followingCount' => $this->formatNumber($followingCount),
            'isFollowing' => $isFollowing,
        ]);
    }


    public function update($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $data = [];

        // Actualizar biografía
        if (isset($_POST['bio'])) {
            $data['bio'] = $_POST['bio'];
            $_SESSION['user']['bio'] = $data['bio'] ?? $user['bio']; // Actualizar la sesión con la nueva biografía
        }

        if (isset($_POST['username'])) {
            $data['username'] = $_POST['username'];
            $_SESSION['user']['username'] = $data['username'] ?? $user['username']; // Actualizar la sesión con el nuevo nombre de usuario
        }

        if (isset($_POST['fullname'])) {
            $data['fullname'] = $_POST['fullname'];
            $_SESSION['user']['fullname'] = $data['fullname'] ?? $user['fullname']; // Actualizar la sesión con el nuevo nombre completo
        }

        // Actualizar foto de perfil
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                return $this->json(['error' => 'Formato de archivo no permitido'], 400);
            }

            $fileName = $id . '.' . $extension;
            $filePath = __DIR__ . '/../../public/assets/images/profiles/' . $fileName;

            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $filePath)) {
                $data['profile_photo_type'] = $extension;

                //eliminar foto de perfil anterior del local
                if (file_exists(__DIR__ . '/../../public/assets/images/profiles/' . $user['id'] . '.' . $user['profile_photo_type']) && $user['profile_photo_type'] !== $extension) {
                    unlink(__DIR__ . '/../../public/assets/images/profiles/' . $user['id'] . '.' . $user['profile_photo_type']);
                }

                $_SESSION['user']['profile_photo_type'] = $extension; // Actualizar la sesión con el nuevo tipo de foto de perfil

            } else {
                return $this->json(['error' => 'Error al guardar la foto de perfil'], 500);
            }
        }

        // Guardar cambios en la base de datos
        $updated = $userModel->update($id, $data);

        if ($updated) {
            return $this->json([
                'success' => true,
                'message' => 'Perfil actualizado con éxito',
                'bio' => $data['bio'] ?? $user['bio'],
                'user_id' => $user['id'],
                'profile_photo_updated' => isset($data['profile_photo_type']),
                'profile_photo_type' => $data['profile_photo_type'] ?? $user['profile_photo_type'],
            ]);
        } else {
            return $this->json(['error' => 'No se pudo actualizar el perfil'], 500);
        }
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

    public function toggleFollow($id)
    {
        $followerModel = new Follower();
        $userId = $_SESSION['user']['id'];

        // Verificar si ya sigue al usuario usando where y first del modelo base
        $existingFollow = $followerModel
            ->where('user_follower_id', $userId)
            ->where('user_followed_id', $id)
            ->first();

        if ($existingFollow) {
            // Dejar de seguir
            $followerModel->delete($existingFollow['id']);
            $followersCount = $followerModel->where('user_followed_id', $id)->get();
            $followersCount = count($followersCount);
            return $this->json([
                'success' => true,
                'following' => false,
                'followersCount' => $followersCount
            ]);
        } else {
            // Seguir
            $followerModel->create([
                'user_follower_id' => $userId,
                'user_followed_id' => $id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $followersCount = $followerModel->where('user_followed_id', $id)->get();
            $followersCount = count($followersCount);

            $notificationController = new NotificationController();
            $notificationController->createNotification('follower', $userId, $id);

            return $this->json([
                'success' => true,
                'following' => true,
                'followersCount' => $followersCount
            ]);
        }
    }

    public function searchUsers()
    {
        $query = $_GET['query'] ?? '';

        if (empty($query)) {
            return $this->json(['success' => false, 'message' => 'No se proporcionó un término de búsqueda.'], 400);
        }

        $userModel = new User();

        // Usar where y orWhere del modelo base
        $users = $userModel
            ->where('username', 'LIKE', '%' . $query . '%')
            ->orWhere('fullname', 'LIKE', '%' . $query . '%')
            ->limit(10)
            ->get();

        return $this->json(['success' => true, 'users' => $users]);
    }
    public function checkAvailability()
    {
        $field = $_GET['field'] ?? null;
        $value = $_GET['value'] ?? null;
        $fieldLabel = $field == 'username' ? 'Nombre de usuario' : 'Correo';

        $allowedFields = ['username' => 'username', 'email' => 'email'];


        if (!$field || !$value || !in_array($field, ['username', 'email'])) {
            return $this->json(['success' => false, 'message' => 'Campo o valor inválido.'], 400);
        }

        $userModel = new User();
        $fieldName = $allowedFields[$field];

        $existingUser = $userModel->where($fieldName, '=', $value)->first();

        if ($existingUser) {
            return $this->json(['success' => false, 'message' => ucfirst($fieldLabel) . ' ya está en uso.']);
        }

        return $this->json(['success' => true, 'message' => ucfirst($fieldLabel) . ' disponible.']);
    }

    public function getInterests()
    {
        $interestModel = new Interest();
        $interests = $interestModel->all();
        return $this->json(['success' => true, 'interests' => $interests, 'userInterests' => $this->getInterestByUserId($_SESSION['user']['id'])]);
    }

    public function getInterestByUserId($id)
    {
        $userInterestModel = new UserInterest();
        $interests = $userInterestModel->where('user_id', $id)->get();
        return array_map(function ($interest) {
            return $interest['interest_id'];
        }, $interests);
    }


    public function saveUserInterests()
    {
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $interests = $data['interests'] ?? [];

        if (count($interests) < 3) {
            return $this->json(['success' => false, 'message' => 'Selecciona al menos tres intereses.'], 400);
        }

        $userInterestModel = new UserInterest();

        // Elimina los intereses previos del usuario
        $userInterestModel->where('user_id', $userId)->delete();

        // Inserta los nuevos intereses
        foreach ($interests as $interestId) {
            $userInterestModel->create([
                'user_id' => $userId,
                'interest_id' => $interestId
            ]);
        }

        return $this->json(['success' => true]);
    }


    public function getUsersWithSimilarInterests()
    {
        $userId = $_SESSION['user']['id'];
        $userModel = new User();
        $interestModel = new Interest();
        $userInterestModel = new UserInterest();
        $followerModel = new Follower();

        // Get user's interests
        $userInterestIds = array_column(
            $userInterestModel->where('user_id', $userId)->get(),
            'interest_id'
        );

        if (empty($userInterestIds)) {
            return $this->json(['success' => true, 'usersWithSimilarInterests' => []]);
        }

        // Get users the current user already follows
        $followedUserIds = array_column(
            $followerModel->where('user_follower_id', $userId)->get(),
            'user_followed_id'
        );

        // Find users with at least one shared interest, excluding self and already followed users
        $similarUserInterests = $userInterestModel
            ->where('interest_id', 'IN', $userInterestIds)
            ->where('user_id', '!=', $userId)
            ->where('user_id', 'NOT IN', $followedUserIds)
            ->get();

        if (empty($similarUserInterests)) {
            return $this->json(['success' => true, 'usersWithSimilarInterests' => []]);
        }

        // Group interests by user_id
        $userInterestsMap = [];
        foreach ($similarUserInterests as $row) {
            $userInterestsMap[$row['user_id']][] = $row['interest_id'];
        }

        $similarUserIds = array_keys($userInterestsMap);

        // Get user data
        $users = $userModel->where('id', 'IN', $similarUserIds)->get();

        // Get all interests for name lookup
        $allInterests = [];
        foreach ($interestModel->all() as $interest) {
            $allInterests[$interest['id']] = $interest['name'];
        }

        // Build result
        $result = [];
        foreach ($users as $user) {
            $interests = [];
            foreach ($userInterestsMap[$user['id']] as $interestId) {
                if (isset($allInterests[$interestId])) {
                    $interests[] = $allInterests[$interestId];
                }
            }
            $followersCount = count($followerModel->where('user_followed_id', $user['id'])->get());
            $user['followersCount'] = $this->formatNumber($followersCount);
            $user['interests'] = $interests;
            $result[] = $user;
        }

        return $this->json([
            'success' => true,
            'usersWithSimilarInterests' => $result
        ]);
    }

    public function followersList($id)
    {
        $userModel = new User();
        $followerModel = new Follower();
        $userId = $_SESSION['user']['id'];

        // Obtener seguidores y seguidos
        $followers = $followerModel->where('user_followed_id', $id)->get();
        $following = $followerModel->where('user_follower_id', $id)->get();

        $followersData = [];
        foreach ($followers as $f) {
            $followerUser = $userModel->find($f['user_follower_id']);
            $existingFollow = !!$followerModel
            ->where('user_follower_id', $userId)
            ->where('user_followed_id', $f['user_followed_id'])
            ->first();
            $followerUser['is_following'] = $existingFollow; // true si el usuario actual sigue al seguidor, false si no
            if ($followerUser) $followersData[] = $followerUser;
        }
        $followingData = [];
        foreach ($following as $f) {
            $followedUser = $userModel->find($f['user_followed_id']);
            $existingFollow = !!$followerModel
            ->where('user_follower_id', $userId)
            ->where('user_followed_id', $f['user_followed_id'])
            ->first();
            $followedUser['is_following'] = $existingFollow;
            if ($followedUser) $followingData[] = $followedUser;
        }

        return $this->json([
            'success' => true,
            'followers' => $followersData,
            'following' => $followingData
        ]);
    }
}
