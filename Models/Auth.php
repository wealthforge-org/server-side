<?php

require_once __DIR__ . '/Model.php';



class Auth extends Model {
    private $conc;
    protected static string $table = 'users';

    public function __construct($connection) {
        $this->conc = $connection;
    }


    public static function find_user(mysqli $conc, ?string $email, ?string $phone_number): ?array {
    if (empty($email) && empty($phone_number)) {
        throw new InvalidArgumentException("You must provide either an email or phone number.");
    }

    if (!empty($email)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conc->prepare($sql);
        $stmt->bind_param("s", $email);
    } else {
        $sql = "SELECT * FROM users WHERE phone_number = ?";
        $stmt = $conc->prepare($sql);
        $stmt->bind_param("s", $phone_number);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: null;
}

}