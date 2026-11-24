<?php
include 'con.php';
$id=$_POST['brwID'];
$brwquantity=$_POST['brwquantity'];
$bookID = $_POST['bookID'];


$stmt = $conn->prepare("UPDATE tb_books SET quantity = quantity + ? Where book_id=?");
$stmt->bindParam(1,$brwquantity);
$stmt->bindParam(2,$bookID);
if($stmt->execute()){
    $sql="DELETE FROM tb_borrowed_books WHERE borrowed_num =?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$id);

    if($stmt->execute()){
        echo 'returned Successfuly';
    }else{
        echo 'Invalid';
    }
}



?>


