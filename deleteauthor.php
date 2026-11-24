<?php
include 'con.php';
$id=$_GET['id'];

$sql="DELETE FROM tb_author WHERE author_id =?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1,$id);

if($stmt->execute()){
    echo '<script>alert("deleted successfuly");window.location.href="../php/author.php";</script>';

}else{
    echo '<script>alert("You Cant delete when someone borrowed it!")</script>';
}

?>


