<?php 

require_once __DIR__ . '/../connection/connection.php';

$sql = "CREATE TABLE transactions (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  from_wallet VARCHAR(100),
  to_wallet VARCHAR(100),
  asset_symbol VARCHAR(20) NOT NULL,
  asset_name VARCHAR(100),
  transaction_type ENUM('buy','sell','send','receive') NOT NULL,
  quantity DECIMAL(20,8) DEFAULT 0,
  price_at_tx DECIMAL(20,8),
  fee DECIMAL(18,8) DEFAULT 0,
  total_value DECIMAL(20,8) GENERATED ALWAYS AS (quantity * price_at_tx) STORED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (from_wallet),
  INDEX (to_wallet),
  INDEX (asset_symbol),
  FOREIGN KEY (from_wallet) REFERENCES users(wallet_address) ON DELETE SET NULL,
  FOREIGN KEY (to_wallet) REFERENCES users(wallet_address) ON DELETE SET NULL
);
";

$execute = $conc->prepare($sql);

if ($execute && $execute->execute()) {
    echo "Table 'users' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}