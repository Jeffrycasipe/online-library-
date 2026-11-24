<?php
include 'con.php';

$name = $_POST['name'];
$gender = $_POST['gender'];
$bday = $_POST['bday'];



$uploadDir = '../uploadedimg/';
$fileName = basename($_FILES['image']['name']);
$uploadFile = $uploadDir . $fileName;
$aname = "%$name%";

// Getting data from the form
$sql= "SELECT * FROM tb_author WHERE (author_name LIKE ?)" ;

  $stmt = $conn->prepare($sql);
	$stmt->bindParam(1,$aname);

	$stmt->execute();

	$count=$stmt->rowCount();
	$data=$stmt->fetchAll();

	foreach($data as $user){
    $_SESSION['user']=$user['book_id'];
};
	if($count > 0){
    // $_SESSION['user']=$user['book_id'];
	// 	$sql = "UPDATE tb_books SET quantity=quantity+$quantity WHERE book_id=?";
    //   $stmt = $conn->prepare($sql);
    //   $stmt->bindParam(1,$_SESSION['user']);

    //   if ($stmt->execute()) {
    //     header("Location:books.php");
    // } else {
    //     echo "Error inserting data into the database.";
    // }
    echo '<script>alert("author alreaady exist!); window.location.href="../php/author.php";</script>';

		
	}else{

        // if($gender = null){
        //     echo '<script>alert("invalid Gender!); window.location.href="../php/addauthor.php";</script>';

        // }else{
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
    
                $filePath = $uploadFile;
            
             
                $sql = "INSERT INTO tb_author (author_name, gender, bday, pic) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
            
                // Bind parameters
                $stmt->bindParam(1, $name);
                $stmt->bindParam(2, $gender);
                $stmt->bindParam(3, $bday);
                $stmt->bindParam(4, $filePath);
              
            
                // Execute the statement
                if ($stmt->execute()) {
                    header("Location: author.php");
                } else {
                    echo "Error inserting data into the database.";
                }
            } else {
                echo "Error uploading image.";
            }
        // }
		

    }







?>
