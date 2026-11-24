<?php
include 'con.php';
$id=$_GET['id'];

$sql="DELETE FROM tb_books WHERE book_id =?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1,$id);

if($stmt->execute()){
    header("location:books.php");
}else{
    echo '<script>alert("You Cant delete when someone borrowed it!")</script>';
}

?>


