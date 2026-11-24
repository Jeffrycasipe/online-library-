<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Books</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(../img/bookshelfs.jpg);
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
      padding: 10px;
      border-radius: 20px;
      width: 35%;
      height: auto;
      text-align: center;
    }

    .container h1, .container p {
      color: white;
    }

    .container a {
      color: rgb(11, 0, 160);
    }

    .container a:hover {
      color: rgb(201, 18, 18);
    }

    .container input[type="text"],
    .container input[type="password"],
    .container input[type="file"],
    .container input[type="number"],
    .container input[type="date"],
    select {
      width: 90%;
      height: 50px;
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
      width: 40%;
      margin: 20px;
    }

    .btn a:hover {
      background-color: #d41010;
      color: #ffffff;
    }

    .mb-3 {
      margin-top: 2px;
      text-align: left;
    }

    .mb-3 label {
        margin-left: 24px;
      margin-bottom: 0px;
      display: block;
      font-size: 14px;
      color: white;
    }
  </style>
</head>
<body>
  
  <div class="container">
    <form method="POST" action="../php/addbook.php" enctype="multipart/form-data">
      <h1>Add Books</h1>
      
      <input type="file" name="image" id="image" accept="image/*" required>

      <input type="text" name="bookname" id="bookname" placeholder="Book Name" required>
  
      <input type="text" name="description" id="description" placeholder="Description" required>
  
      <input type="number" name="pagenum" id="pagenum" placeholder="Number of Pages" required>
  
      <label for="genre" class="form-label"></label>
    <select class="form-control" name="genre" id="genre" required>
      <option value="noGenre">Select Genre...</option>
      <option value="fiction">Fiction</option>
      <option value="nonFiction">Non-Fiction</option>
      <option value="fantasy">Fantasy</option>
      <option value="mystery">Mystery</option>
      <option value="history">History</option>
      <option value="science">Science</option>
    </select>

  
      <input type="number" name="quantity" id="quantity" placeholder="Quantity" required>
      
      <?php
        include 'con.php';
        $sql = "SELECT * FROM tb_author";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      
      
        <label for="author" class="form-label"></label>
        <select class="form-control" name="author" id="author" required>
          <option value="noAuthor">Select Author...</option> 
          <?php foreach ($data as $user) { ?>
            <option value="<?php echo $user['author_id']; ?>"> 
              <?php echo $user['author_name']; ?>
            </option> 
          <?php } ?>      
        </select>
     
      
      <div class="mb-3">
        <label for="pdate" class="form-label">Published Date</label>
        <center><input type="date" class="form-control" name="pdate" id="pdate" required></center>
      </div>
  
      <div class="btn">
        <a href="books.php">CANCEL</a>
        <input type="submit" value="SAVE">
      </div>  
    </form>
  </div>
  
  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../js/addbook.js"></script>
</body>
</html>
