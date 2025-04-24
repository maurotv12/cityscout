<?php

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use Lib\Route;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
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
Route::get('/post/create', function () {
    AuthMiddleware::handle();
    (new PostController)->create();
});
Route::get('/post/:id/comments', [PostController::class, 'getComments'])
    ->middleware([AuthMiddleware::class]);
// Route::get('/post/:id', function () {
//     AuthMiddleware::handle();
//     (new PostConstroller)->post();
// });

//user
Route::get('/profile/:id', [UserController::class, 'show'])
    ->middleware([AuthMiddleware::class]);
Route::get('/profile/:id/edit', [UserController::class, 'edit'])
    ->middleware([AuthMiddleware::class]);
Route::post('/user/update-bio/{id}', [UserController::class, 'updateBio'])
    ->middleware([AuthMiddleware::class]);

//chat
Route::get('/chats', [ChatController::class, 'index'])
    ->middleware([AuthMiddleware::class]);
Route::get('/conversation/:id', [ChatController::class, 'conversation'])
    ->middleware([AuthMiddleware::class]);

Lib\Route::dispatch();
