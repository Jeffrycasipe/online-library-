<?php

include 'con.php';


$stmt=$conn->prepare("SELECT * FROM tb_author WHERE author_id=?");
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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      background:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(../img/bookshelfs.jpg);
      color: #fff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .container {
      color: black;
      background: linear-gradient(140deg, #3C3D37, #697565); 
      padding: 20px;
      border-radius: 20px;
      width: 35%;
      height: auto;
      text-align: center;
    }
    
    .container h1, p {
      color: white;
    }
    
    .container a {
      color: rgb(11, 0, 160);
    }
    
    .container a:hover {
      color: rgb(201, 18, 18);
    }
    
    .container input[type="text"], .container input[type="password"],.container input[type="file"], select {
      width: 90%;
      height: 40px;
      margin-top: 10px;
      font-size: 15px;
      padding: 10px;
      border: 1px solid #ffffff;
      border-radius: 5px;
      background-color: rgba(255, 255, 255, 1);
    }
    
    .container input[type="submit"] {
      color: rgb(0, 0, 0);
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 40%;
      margin: 20px;
    }
    
    .container input[type="submit"]:hover {
      background-color: #40cc45;
      color: #ffffff;
    }
    
    .btn a, .btn input[type="submit"] {
      background-color: white;
      display: inline-block;
      width: 40%;
      font-size: 18px;
    }
    
    .btn a {
      text-decoration: none;
      color: rgb(0, 0, 0);
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 20px;
    }
    
    .btn a:hover {
      background-color: #d41010;
      color: #ffffff;
    }

    /* Styling the image */
    img {
      width: 250px;
      max-width: 250px;
      height: 250px;
      border-radius: 10px;
      margin-bottom: 20px;
      object-fit: cover; /* Ensures image stays proportionate */
      border: 2px solid #fff;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    }

    .container input {
      margin-bottom: 1px; /* Add space between input fields */
    }
  </style>
</head>
<body>
  
<div class="container">
    <form method="POST" action="../php/authoredit.php" enctype="multipart/form-data">
        <h1>Edit Book</h1>
        <?php foreach($data as $user) { ?>
            <img src="<?php echo $user['pic']; ?>" alt="Book Image">
            <input type="file" name="image" id="image" >
            <input type="text" name="name" id="bookname" placeholder="Book Name" value="<?php echo $user['author_name']; ?>" required>
            <label for="Gender"><i class="fas fa-venus-mars"></i> </label>
          <select name="gender" required>
          <option value="">Select Gender...</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
            <input type="text" name="bday" id="pagenum" placeholder="Number of Pages" value="<?php echo $user['bday']; ?>" required>
            
            <input type="hidden" name="id" id="id" value="<?php echo $user['author_id']; ?>">
            <div class="btn">
                <a href="../php/author.php">CANCEL</a>
                <input type="submit" value="SAVE" name="Save">
            </div>
        <?php } ?>
    </form>
</div>


  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../js/edit.js"></script>
</body>

</html>
