<?php

use Lib\Route;
use App\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);



Lib\Route::dispatch();


// <?php

// use Lib\Route;
// use App\Controllers\HomeController;

// Route::get('/', function (){
//     echo 'hola desde la pagina principal';
// });

// Route::get('/feed', function () {
//     echo 'hola desde el feed';
// });

// Route::get('/perfil', function () {
//     echo 'hola desde perfil';
// });

// Route::get('/courses/:slug', function ($slug) {
//     echo 'Hola es: ' . $slug;
    
// });

// Route::dispatch();