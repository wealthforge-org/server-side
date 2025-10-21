<?php
require_once __DIR__ . '/../connection/connection.php';
$holdings = [
    ['0xABC123','BTC','Bitcoin',0.5,30000],
    ['0xDEF456','ETH','Ethereum',2,1800],
    ['0xGHI789','ADA','Cardano',100,1.2],
    ['0xJKL012','SOL','Solana',10,35],
    ['0xMNO345','DOT','Polkadot',50,20],
];

foreach ($holdings as $h) {
    [$wallet,$symbol,$name,$qty,$avgPrice] = $h;
    mysqli_query($conc,"INSERT INTO holdings (wallet_address,asset_symbol,asset_name,quantity,average_price) VALUES ('$wallet','$symbol','$name',$qty,$avgPrice)");
}