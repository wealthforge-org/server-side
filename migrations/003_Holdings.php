<?php 

require_once __DIR__ . '/../connection/connection.php';

$sql = "CREATE TABLE holdings (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  wallet_address VARCHAR(100),
  asset_symbol VARCHAR(20) NOT NULL,
  asset_name VARCHAR(100),
  quantity DECIMAL(20,8) DEFAULT 0,
  average_price DECIMAL(20,8) DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (wallet_address) REFERENCES users(wallet_address) ON DELETE CASCADE
);
";

$execute = $conc->prepare($sql);

if ($execute && $execute->execute()) {
    echo "Table 'holdings' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}