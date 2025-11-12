<?php

require_once __DIR__ . '/../connection/connection.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../Service/ResponseService.php';


class Login {

    public function loginUser() {
        global $conc;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || empty($data['email']) || empty($data['password'])) {
            echo ResponseService::error_response("Email and password are required.");
            exit;
        }

        $email = $data['email'];
        $password = $data['password'];

        $user = Auth::find_user($conc, $email, null);

        if (!$user) {
            echo ResponseService::error_response("Invalid email or password.");
            exit;
        }

      
        if (!password_verify($password, $user['password_hash'])) {
            echo ResponseService::error_response("Invalid email or password.");
            exit;
        }

     
        unset($user['password_hash']);

  
        echo ResponseService::success_response("Login successful.", $user);
        exit;
    }
}
