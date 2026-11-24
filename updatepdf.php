W<?php
include "con.php";
if (isset($_POST['sub'])) {
    // Get form data
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $d = $_POST['d'];
    $pd = $_POST['pdate'];
    $author = $_POST['author'];
    $ebookid = $_POST['id']; // Assuming the ebook ID is passed via GET

    // Variables to hold the uploaded file paths
    $uploadFile = null;
    $uploadImagePath = null;

    // Handle the cover image upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $cover = $_FILES['cover'];
        $imagename = basename($cover['name']);
        $imagDir = '../ebookphoto/'; // Directory to store uploaded images
        $uniqueImageName = uniqid() . '.' . pathinfo($imagename, PATHINFO_EXTENSION);
        $uploadImagePath = $imagDir . $uniqueImageName;

        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($cover['type'], $allowedImageTypes)) {
            if (move_uploaded_file($cover['tmp_name'], $uploadImagePath)) {
                echo "Cover image uploaded successfully!";
            } else {
                echo "Failed to upload cover image.";
            }
        } else {
            echo '<script> window.location.href="../php/ebooks.php";alert("Invalid image format. Only JPEG, PNG, or GIF allowed.");</script>';
            exit();
        }
    }

    // Handle the PDF upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $pdf = $_FILES['pdf'];
        $fileName = basename($pdf['name']);
        $uploadDir = '../ebooks/'; // Path to store the PDF on the server
        $uploadFile = $uploadDir . $fileName;

        if ($pdf['type'] == 'application/pdf') {
            if (move_uploaded_file($pdf['tmp_name'], $uploadFile)) {
                echo "PDF uploaded successfully!";
            } else {
                echo "Failed to upload PDF.";
            }
        } else {
            echo "Only PDF files are allowed!";
            exit();
        }
    }

    // Prepare the SQL query based on the presence of files
    if ($uploadFile != null && $uploadImagePath != null) {
        $sql = "UPDATE tb_ebooks SET ebook_filepath = ?, ebook_tittle = ?, eGenre = ?, ebook_description = ?, author_id = ?, published_date = ?, ebook_cover = ? WHERE ebook_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $uploadFile);
        $stmt->bindParam(2, $title);
        $stmt->bindParam(3, $genre);
        $stmt->bindParam(4, $d);
        $stmt->bindParam(5, $author);
        $stmt->bindParam(6, $pd);
        $stmt->bindParam(7, $uploadImagePath);
        $stmt->bindParam(8, $ebookid);
    } elseif ($uploadFile != null) {
        $sql = "UPDATE tb_ebooks SET ebook_filepath = ?, ebook_tittle = ?, eGenre = ?, ebook_description = ?, author_id = ?, published_date = ? WHERE ebook_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $uploadFile);
        $stmt->bindParam(2, $title);
        $stmt->bindParam(3, $genre);
        $stmt->bindParam(4, $d);
        $stmt->bindParam(5, $author);
        $stmt->bindParam(6, $pd);
        $stmt->bindParam(7, $ebookid);
    } elseif ($uploadImagePath != null) {
        $sql = "UPDATE tb_ebooks SET ebook_cover = ?, ebook_tittle = ?, eGenre = ?, ebook_description = ?, author_id = ?, published_date = ? WHERE ebook_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $uploadImagePath);
        $stmt->bindParam(2, $title);
        $stmt->bindParam(3, $genre);
        $stmt->bindParam(4, $d);
        $stmt->bindParam(5, $author);
        $stmt->bindParam(6, $pd);
        $stmt->bindParam(7, $ebookid);
    } else {
        $sql = "UPDATE tb_ebooks SET ebook_tittle = ?, eGenre = ?, ebook_description = ?, author_id = ?, published_date = ? WHERE ebook_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $genre);
        $stmt->bindParam(3, $d);
        $stmt->bindParam(4, $author);
        $stmt->bindParam(5, $pd);
        $stmt->bindParam(6, $ebookid);
        if ($stmt->execute()) {
            echo '<script> window.location.href="../php/ebooks.php";alert("Ebook updated successfully!");</script>';
            exit();
        } else {
            echo '<script> window.location.href="../php/ebooks.php";alert("Error updating ebook!");</script>';
            exit();
        }
    }

    // Execute the statement and handle the result
    
}
?>
