<?php
session_start();
include 'con.php';
$id = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="../bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(../img/ah2.PNG) no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .container {
      max-width: 600px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      margin: 100px auto;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 2rem;
      color: #40cc45;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #40cc45;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-bottom: 15px;
      font-size: 16px;
    }

    img {
      display: block;
      margin: 0 auto 20px auto; /* Center the image and add space below */
      width: 150px; /* Set a specific width for the image */
      height: auto; /* Maintain aspect ratio */
      border-radius: 50%; /* Make it circular */
    }

    /* Adjustments for name display */
    .name-container p {
      font-size: 1.5rem; /* Increase the font size */
      margin: 5px 0; /* Reduce the gap between the first and last name */
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .buttons a, .buttons input[type="submit"] {
      background-color: #40cc45;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
      text-align: center;
      text-decoration: none;
    }

    .buttons a:hover, .buttons input[type="submit"]:hover {
      background-color: #2c3e50;
    }

    .logOut {
      text-align: center;
      margin-top: 15px;
    }

    .logOut a {
      color: red;
      text-decoration: none;
      font-weight: bold;
    }

    .logOut a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .container {
        width: 90%;
      }
    }
    
  </style>
</head>
<body>

  <div class="container">
    <h1>User Profile</h1>
    <form onsubmit="frmSub(event)">
      <?php
      $stmt = $conn->prepare("SELECT * FROM tb_student WHERE student_id=?");
      $stmt->bindParam(1, $id);
      $stmt->execute();
      $data = $stmt->fetchAll();
      foreach ($data as $user) { ?>
      <img src="../img/acc2.png" alt="User Image">
      <div class="name-container">
        <center>
          <p><?php echo  $user['first_name']; ?></p>
          <p><?php echo  $user['last_name']; ?></p>
        </center>
      </div>
      <?php } ?>
      
      <div class="buttons">
        <a href="home.php?id=<?php echo $_SESSION['user']; ?>">Home</a>
        <input type="submit" value="Update" name="Submit">
      </div>
      <div class="logOut">
        <a href="../index.html">Log Out</a>
      </div>
    </form>
  </div>

</body>
</html>
