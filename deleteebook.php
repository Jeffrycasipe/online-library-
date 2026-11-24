<?php
include 'con.php';
$id=$_GET['id'];

$sql="DELETE FROM tb_ebooks WHERE ebook_id =?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1,$id);

if($stmt->execute()){
    // header("location:ebooks.php");
    echo '<script> window.location.href="../php/ebooks.php";alert("Deleted Successfuly.");</script>';

}else{
    header("location:ebooks.php");
    // echo "You Cant delete hen someone borrowed it!";
}

?>


