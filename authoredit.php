<?php
include 'con.php';

$id = $_POST['id'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$bday = $_POST['bday'];


$uploadDir = '../uploadedimg/';
$fileName = basename($_FILES['image']['name']);
$uploadFile = $uploadDir . $fileName;

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
    // File uploaded successfully
    $filePath = $uploadFile;

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE tb_author SET author_name = ?, gender = ?, bday = ?, pic=? WHERE author_id = ?");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $gender);
    $stmt->bindParam(3, $bday);
    $stmt->bindParam(4, $filePath);
    $stmt->bindParam(5, $id);
 

    if ($stmt->execute()) {
        header("Location: author.php");
    } else {
        echo 'Error updating the database.';
    }
} else {
    $stmt = $conn->prepare("UPDATE tb_author SET author_name = ?, gender = ?, bday = ? WHERE author_id = ?");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $gender);
    $stmt->bindParam(3, $bday);

    $stmt->bindParam(4, $id);

    if ($stmt->execute()) {
        header("Location: author.php");
    } else {
        echo 'Error updating the database.';
    }
}
?>
