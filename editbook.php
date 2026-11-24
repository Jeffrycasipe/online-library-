<?php

include 'con.php';


$stmt=$conn->prepare("SELECT * FROM tb_books WHERE book_id=?");
$stmt->bindParam(1,$_GET['id']);
$stmt->execute();
    
$count=$stmt->rowCount();
$data=$stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Book</title>
  <style>
    body {
      background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(../src/PHOTO.jpg);
      background-size: cover; /* Ensures the image covers the entire background */
      background-position: center; /* Centers the image */
      background-repeat: no-repeat; /* Prevents the image from repeating */
      color: #fff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    img {
      width: 150px; /* Set a smaller fixed width */
      height: auto; /* Maintain aspect ratio */
      max-height: 200px; /* Optional: Limit maximum height */
      border-radius: 10px;
      margin-bottom: 20px;
      object-fit: cover; /* Ensures the image fits within the specified dimensions */
      border: 2px solid #fff;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
      }

    .container form div {
      display: flex;
      flex-direction: column; /* Align label and input vertically */
      margin-bottom: 15px; /* Add spacing between fields */
      text-align: left;
    }

    label {
      margin-bottom: 5px;
      font-size: 14px;
      color: white;
      display: block;
    }
    input, select {
      width: 100%; /* Stretch to container width */
      height: 40px;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ffffff;
      background-color: rgba(255, 255, 255, 1);
    }


    
  </style>
</head>
<body>
  
<div class="container">
    <form method="POST" action="../php/edit.php" enctype="multipart/form-data">
        <h1>Edit Book</h1>
        <?php foreach($data as $user) { ?>
            <img src="<?php echo $user['filepath']; ?>" alt="Book Image">
            
            <label for="image">Book Image</label>
            <input type="file" name="image" id="image">

            <label for="bookname">Book Name</label>
            <input type="text" name="bookname" id="bookname" placeholder="Book Name" value="<?php echo $user['book_name']; ?>" required>

            <label for="description">Description</label>
            <input type="text" name="description" id="description" placeholder="Description" value="<?php echo $user['description']; ?>" required>

            <label for="pagenum">Number of Pages</label>
            <input type="text" name="pagenum" id="pagenum" placeholder="Number of Pages" value="<?php echo $user['num_of_page']; ?>" required>

            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" placeholder="Genre" value="<?php echo $user['genre']; ?>" required>

            <label for="quantity">Quantity</label>
            <input type="text" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $user['quantity']; ?>" required>

            <input type="hidden" name="id" id="id" value="<?php echo $user['book_id']; ?>">

            <div class="btn">
                <a href="../php/books.php">CANCEL</a>
                <input type="submit" value="SAVE" name="Save">
            </div>
        <?php } ?>
    </form>
</div>



  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../js/edit.js"></script>
</body>

</html>
