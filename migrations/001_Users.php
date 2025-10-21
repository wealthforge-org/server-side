<?php 

require_once __DIR__ . '/../connection/connection.php';

$sql = "CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  wallet_address VARCHAR(100) NOT NULL UNIQUE,
  balance DECIMAL(18,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
";

$execute = $conc->prepare($sql);

if ($execute && $execute->execute()) {
    echo "Table 'Users' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}