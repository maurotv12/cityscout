<?php

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use Lib\Route;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Controllers\NotificationController;
use App\Models\User;

Route::get('/', [PostController::class, 'index'])
    ->middleware([AuthMiddleware::class]);

//Auth
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);

//posts
Route::delete('/post/:id/delete', [PostController::class, 'deletePost'])
    ->middleware([AuthMiddleware::class]);
    
Route::get('/post/:id/comments', [PostController::class, 'getComments'])
    ->middleware([AuthMiddleware::class]);
Route::post('/post/:id/comments', [PostController::class, 'addComment'])
    ->middleware([AuthMiddleware::class]);
//Delete Comment
Route::delete('/comment/:id/delete', [PostController::class, 'deleteComment'])
    ->middleware([AuthMiddleware::class]);

Route::post('/post/:id/like', [PostController::class, 'toggleLike'])
    ->middleware([AuthMiddleware::class]);

//Guardar post
Route::post('/post/store', [PostController::class, 'store'])
    ->middleware([AuthMiddleware::class]);

Route::post('/post/:id/update-caption', [PostController::class, 'updateCaption'])
    ->middleware([AuthMiddleware::class]);
    

//user
Route::get('/profile/:id', [UserController::class, 'show'])
    ->middleware([AuthMiddleware::class]);
Route::get('/profile/:id/edit', [UserController::class, 'edit'])
    ->middleware([AuthMiddleware::class]);
Route::post('/user/update-profile/:id', [UserController::class, 'update'])
    ->middleware([AuthMiddleware::class]);

//chat

// Obtener lista de chats
Route::get('/chats', [ChatController::class, 'getChats'])->middleware([AuthMiddleware::class]);
// Obtener mensajes de un chat
Route::get('/chats/:chatWithId/messages', [ChatController::class, 'getMessages'])->middleware([AuthMiddleware::class]);
// Enviar un mensaje
Route::post('/chats/:chatWithId/send', [ChatController::class, 'sendMessage'])->middleware([AuthMiddleware::class]);
// Marcar mensajes como leídos
Route::post('/chats/:chatWithId/read', [ChatController::class, 'markMessagesAsRead'])->middleware([AuthMiddleware::class]);

// Follow and Unfollow
Route::post('/user/:id/follow', [UserController::class, 'toggleFollow'])
    ->middleware([AuthMiddleware::class]);


//Notifications
Route::get('/notifications', [NotificationController::class, 'getNotifications'])
    ->middleware([AuthMiddleware::class]);
// Marcar notificación como leída
Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])
    ->middleware([AuthMiddleware::class]);

Lib\Route::dispatch();
