<?php

namespace App\Controllers;

class Controller {
    public function view($route, $data =[]){

        extract($data);

        $route = str_replace('.', '/', $route);

        if (file_exists("../resources/views/{$route}.php")) {

            ob_start();
            include "../resources/views/{$route}.php";
            $content = ob_get_clean();

            return $content;
        }else{
            return "No existe la ruta";
        }
    }

    public function redirect($route, $data = []) {
        if (isset($data['flash'])) {
            session_start();
            $_SESSION['flash'] = $data['flash'];
        }
        header("Location: /{$route}");
        exit;
    }
    
    public function json($data, $code = 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }


}


