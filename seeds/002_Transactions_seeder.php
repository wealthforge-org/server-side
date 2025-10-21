<?php
require_once __DIR__ . '/../connection/connection.php';
$transactions = [
    ['0xABC123','0xDEF456','BTC','Bitcoin','send',0.5,30000,10],
    ['0xDEF456','0xGHI789','ETH','Ethereum','buy',2,1800,5],
    ['0xGHI789','0xJKL012','ADA','Cardano','sell',100,1.2,2],
    ['0xJKL012','0xMNO345','SOL','Solana','send',10,35,1],
    ['0xMNO345','0xABC123','DOT','Polkadot','receive',50,20,0.5],
];

foreach ($transactions as $t) {
    [$from,$to,$symbol,$name,$type,$qty,$price,$fee] = $t;
    $fromVal = $from ? "'$from'" : "NULL";
    $toVal = $to ? "'$to'" : "NULL";
    mysqli_query($conc,"INSERT INTO transactions (from_wallet,to_wallet,asset_symbol,asset_name,transaction_type,quantity,price_at_tx,fee) VALUES ($fromVal,$toVal,'$symbol','$name','$type',$qty,$price,$fee)");
}
?>