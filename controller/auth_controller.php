<?php

require_once __DIR__ . '/../connection/connection.php';
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../Service/ResponseService.php';

class Register {

    public function RegisterUser() {
    global $conc;

    $data = json_decode(file_get_contents("php://input"), true);

    // Validate required fields
    if (!$data || empty($data['password']) || empty($data['email']) || empty($data['name'])) {
        echo ResponseService::error_response("Missing required fields.");
        exit;
    }

    // Rename 'password' to 'password_hash' and hash it
    $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
    unset($data['password']); // remove original key

    // Optional: add default wallet address or handle it separately
    if (empty($data['wallet_address'])) {
        $data['wallet_address'] = uniqid('wallet_'); // simple placeholder
    }

    // Insert user
    $result = Auth::create($conc, $data);

    if ($result) {
        echo ResponseService::success_response("User created successfully.");
    } else {
        echo ResponseService::error_response("Failed to create user.");
    }

    exit;
}


}
