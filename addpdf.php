<?php
include "con.php";
if (isset($_POST['sub'])) {
    // Check if the file input field exists and a file is uploaded
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $d = $_POST['d'];
    $pd = $_POST['pdate'];
    $author = $_POST['author'];
    // Handle the cover image upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $cover = $_FILES['cover'];

        // Get the file name and path for the cover image
        $imagename = basename($cover['name']);
        $imagDir = '../ebookphoto/'; // Directory to store uploaded images

        // Generate a unique file name to avoid overwriting existing files
        $uniqueImageName = uniqid() . '.' . pathinfo($imagename, PATHINFO_EXTENSION);
        $uploadImagePath = $imagDir . $uniqueImageName;

        // Check if the image file is a valid format (you can add more file types as needed)
        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($cover['type'], $allowedImageTypes)) {
            // Move the uploaded image to the specified directory
            if (move_uploaded_file($cover['tmp_name'], $uploadImagePath)) {
                echo "Cover image uploaded successfully!";
            } else {
                echo "Failed to upload cover image.";
            }
        } else {
            echo '<script> window.location.href="../php/ebooks.php";alert("Invalid image format. Only JPEG, PNG, or GIF allowed.");</script>';

            // echo "Invalid image format. Only JPEG, PNG, or GIF allowed.";
        }
    } else {
        // echo "No cover image uploaded or there was an error.";
        echo '<script> window.location.href="../php/ebooks.php";alert("No cover image uploaded or there was an error.");</script>';

    }

    // Handle the PDF upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $pdf = $_FILES['pdf'];

        // Get the file information
        $fileName = basename($pdf['name']);
        $uploadDir = '../ebooks/'; // Path to store the PDF on the server
        $uploadFile = $uploadDir . $fileName;

        // Check if the uploaded file is a PDF
        $fileType = $pdf['type'];
        if ($fileType == 'application/pdf') {
            // Move the uploaded PDF to the specified directory
            if (move_uploaded_file($pdf['tmp_name'], $uploadFile)) {
                echo "PDF uploaded successfully!";
            } else {
                echo "Failed to upload PDF.";
            }
        } else {
            echo "Only PDF files are allowed!";
        }
    }

    // Insert data into the database
    if (isset($uploadFile) && isset($uploadImagePath)) {
        // Prepare the SQL query to insert the file paths
        if($author ==="noAuthor"){
            echo '<script> window.location.href="../php/ebooks.php";alert("Unkown Author");</script>';
        }else{
            $stmt = $conn->prepare("INSERT INTO tb_ebooks (ebook_tittle, ebook_description, eGenre, ebook_filepath, ebook_cover,author_id,published_date) VALUES (?, ?, ?, ?, ?,?,?)");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $d);
        $stmt->bindParam(3, $genre);
        $stmt->bindParam(4, $uploadFile); // Bind the file path for the PDF
        $stmt->bindParam(5, $uploadImagePath); // Bind the file path for the image
        
        $stmt->bindParam(6, $author);
        $stmt->bindParam(7, $pd);

        // Execute the query
        if ($stmt->execute()) {
            echo '<script> window.location.href="../php/ebooks.php";alert("Ebook added Successfuly");</script>';

exit();
        } else {
                        echo '<script> window.location.href="../php/ebooks.php";alert("Error");</script>';

        }
        }
        
    }
}
?>
