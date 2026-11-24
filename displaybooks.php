<?php

include 'conn.php';

$sql = $conn->prepare("SELECT * FROM tb_addbooks");
$sql->execute();

$event = $sql->fetchAll((PDO::FETCH_ASSOC));

echo json_encode($event);

?>