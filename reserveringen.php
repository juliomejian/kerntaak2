<?php 
session_start();

require_once 'core/User.php';

$user = new Core\User();

$stmt_reserveringen_item = $user->runQuery("SELECT * FROM eten_item WHERE subeten_code=:subeten_code");

$stmt_reserveringen_item->execute(array(":subeten_code"=>$sub_eten_code));
    while($row_reserveringen_item= $stmt_reserveringen_item->fetch(\PDO::FETCH_ASSOC)):
        $etenItemCode = $row_reserveringen_item['eten_item_id'];
        $etenItemNaam = $row_reserveringen_item['eten_item_name'];
        $etenPrijs = $row_reserveringen_item['eten_item_prijs'];
?>