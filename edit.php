<?php
include 'con.php';

$id = $_POST['id'];
$bookname = $_POST['bookname'];
$description = $_POST['description'];
$pagenum = $_POST['pagenum'];
$genre = $_POST['genre'];
$quantity = $_POST['quantity'];

$uploadDir = '../uploadedimg/';
$fileName = basename($_FILES['image']['name']);
$uploadFile = $uploadDir . $fileName;

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
    // File uploaded successfully
    $filePath = $uploadFile;

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE tb_books SET book_name = ?, description = ?, num_of_page = ?, genre = ?, quantity = ?, bookpic = ?, filepath = ? WHERE book_id = ?");
    $stmt->bindParam(1, $bookname);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $pagenum);
    $stmt->bindParam(4, $genre);
    $stmt->bindParam(5, $quantity);
    $stmt->bindParam(6, $fileName);
    $stmt->bindParam(7, $filePath);
    $stmt->bindParam(8, $id);

    if ($stmt->execute()) {
        header("Location: books.php");
    } else {
        echo 'Error updating the database.';
    }
} else {
    $stmt = $conn->prepare("UPDATE tb_books SET book_name = ?, description = ?, num_of_page = ?, genre = ?, quantity = ? WHERE book_id = ?");
    $stmt->bindParam(1, $bookname);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $pagenum);
    $stmt->bindParam(4, $genre);
    $stmt->bindParam(5, $quantity);
   
    $stmt->bindParam(6, $id);

    if ($stmt->execute()) {
        header("Location: books.php");
    } else {
        echo 'Error updating the database.';
    }
}
?>
