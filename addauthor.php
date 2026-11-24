<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Author</title>
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
      appearance: none; /* Removes browser-specific styles for uniformity */
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

    .btn a,
    .btn input[type="submit"] {
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
  </style>
</head>
<body>
  
  <div class="container">
    <form method="POST" action="../php/addauth.php" enctype="image/form-data">
      <h1>Add Author</h1>
    
      <input type="text" name="name" id="name" placeholder="Author Name" required>
  
      <label for="Gender"><i class="fas fa-venus-mars"></i> </label>
          <select name="gender" required>
          <option value="">Select Gender...</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
  
      <input type="date" name="bday" id="bday" placeholder="Publication Date" required>
  
      <div class="btn">
        <a href="../php/author.php">CANCEL</a>
        <input type="submit" value="SAVE">
      </div>  
    </form>
  </div>

  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../js/addbook.js"></script>
</body>
</html>
