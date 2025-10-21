<?php
require_once __DIR__ . '/../connection/connection.php';
$users = [
    ['Alice Smith','alice@example.com','password123','0xABC123',1000.00],
    ['Bob Johnson','bob@example.com','password123','0xDEF456',1500.50],
    ['Charlie Lee','charlie@example.com','password123','0xGHI789',500.25],
    ['Diana Prince','diana@example.com','password123','0xJKL012',2500.00],
    ['Ethan Hunt','ethan@example.com','password123','0xMNO345',800.75],
];

foreach ($users as $u) {
    [$name,$email,$pwd,$wallet,$balance] = $u;
    $pwdHash = password_hash($pwd,PASSWORD_DEFAULT);
    mysqli_query($conc,"INSERT INTO users (name,email,password_hash,wallet_address,balance) VALUES ('$name','$email','$pwdHash','$wallet',$balance)");
}

?>
