<?php
include 'con.php';

$bookname = $_POST['bookname'];
$description = $_POST['description'];
$pagenum = $_POST['pagenum'];
$genre = $_POST['genre'];
$quantity = $_POST['quantity'];
$author = $_POST['author_id'];
$pdate = $_POST['bday'];


$uploadDir = '../uploadedimg/';
$fileName = basename($_FILES['image']['name']);
$uploadFile = $uploadDir . $fileName;
$bkname = "%$bookname%";
$g="%$genre%";
// Getting data from the form
$sql= "SELECT * FROM tb_books WHERE (book_name LIKE ? AND genre LIKE ?)" ;

  $stmt = $conn->prepare($sql);
	$stmt->bindParam(1,$bkname);
  $stmt->bindParam(2,$g);
	$stmt->execute();

	$count=$stmt->rowCount();
	$data=$stmt->fetchAll();

	foreach($data as $user){
    $_SESSION['user']=$user['book_id'];
};
	if($count > 0){
    $_SESSION['user']=$user['book_id'];
		$sql = "UPDATE tb_books SET quantity=quantity+$quantity WHERE book_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(1,$_SESSION['user']);

      if ($stmt->execute()) {
        header("Location:books.php");
    } else {
        echo "Error inserting data into the database.";
    }

		
	}else{
		if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
    
      $filePath = $uploadFile;
  
   
      $sql = "INSERT INTO tb_books (book_name, description, num_of_page, genre, quantity, bookpic, filepath,author_id,published_date ) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)";
      $stmt = $conn->prepare($sql);
  
      // Bind parameters
      $stmt->bindParam(1, $bookname);
      $stmt->bindParam(2, $description);
      $stmt->bindParam(3, $pagenum);
      $stmt->bindParam(4, $genre);
      $stmt->bindParam(5, $quantity);
      $stmt->bindParam(6, $fileName);
      $stmt->bindParam(7, $filePath);
      $stmt->bindParam(8, $author);
      $stmt->bindParam(9, $pdate);
  
      // Execute the statement
      if ($stmt->execute()) {
        //   header("Location: books.php");
        echo '<script>alert("Book added successfuly!");window.location.href="books.php";
</script>';
      } else {
          echo "Error inserting data into the database.";
      }
  } else {
      echo "Error uploading image.";
  }

    }







?>
