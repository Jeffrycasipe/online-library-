<?php
session_start();
include 'con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Books</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
      * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-image: url(../img/ah.PNG);
      background-repeat: no-repeat;
      background-size: cover;
      color: #333;
      display: flex;
      min-height: 100vh;
    }

    header {
      background-color: #2c3e50;
      padding: 20px 5%;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      width: 100%;
      z-index: 1000;
    }

    header .logo {
      font-size: 1.8rem;
      font-weight: 600;
    }

    .sidebar {
      width: 250px;
      background-color: #34495e;
      color: #fff;
      position: fixed;
      top: 70px;
      bottom: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      color: #40cc45;
      background-color: #56728b;
    }

    .books {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
      gap: 10px;
      padding: 20px;
      margin-top: 30px;
    }

    .book-detail1 {
      max-width: 200px;
      margin: 10px auto;
      background-color: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      transition: transform 0.2s, box-shadow 0.2s;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .book-detail1:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .book-detail1 img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 10px;
      display: block;
      margin-bottom: 15px;
    }

    .op a {
      font-size: 20px;
      background-color: #2980b9;
      text-decoration: none;
      color: white;
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
      display: inline-block;
      transition: background-color 0.3s;
    }

    .op a:hover {
      background-color: #40cc45;
      color: white;
    }

    .add {
      text-align: center;
      margin-top: 20px;
  
    }

    .add a {
      width: 100%;
      font-size: 20px;
      background-color: #2980b9;
      text-decoration: none;
      color: white;
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
      display: inline-block;
      transition: background-color 0.3s;
    }

    .add a:hover {
      background-color: #40cc45;
      color: white;
    }

    .main {
      margin-left: 240px;
      padding: 20px;
      flex: 1;
      background-color: rgba(255, 255, 255, 0.6);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 70px;
    }

    .welcome {
      font-size: 1.5rem;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .sidebar .navBook {
      color: red;
    }
  </style>
</head>
<body>
  
<header>
  <div class="logo">Admin Dashboard</div>
</header>

<div class="sidebar">
  <h3>Navigation</h3>
  <a href="../php/admin.php"><i class="fas fa-home"></i> Home</a>
  <a href="user.php"><i class="fas fa-users"></i> Users</a>
  <a href="userapp.php" ><i class="fas fa-check"></i> Users Request</a>
  <a href="../php/books.php" ><i class="fas fa-book"></i> Books</a>
  <a href="../php/ebooks.php"><i class="fas fa-file"></i> Ebooks</a>
  <a href="../php/author.php" class="navBook"><i class="fas fa-person"></i> Author</a>
  <a href="../php/access.php"><i class="fas fa-lock"></i> Ebook Access Req.</a>
  <a href="../php/record.php"><i class="fas fa-history"></i> Records</a>
  <a href="../index.html"><i class="fas fa-sign-out-alt"></i> Log Out</a>
</div>

<?php
$stmt = $conn->prepare("SELECT * FROM tb_author");
$stmt->execute();
$data = $stmt->fetchAll();
?>

<div class="main">
  <div class="welcome">Welcome, Admin!</div>
  <!-- <p style="opacity: 1;"><i>Remember, if you try to delete a book that has been borrowed, it will result in an error: you cannot delete books that have been borrowed by someone!”</i></p> -->
 
  <div class="add">
    <a href="../php/addauthor.php">Add Author</a>
  </div>
  <div class="books">
    <?php foreach ($data as $user) { ?>
      <div class="book-detail1">
        <img src="<?php echo $user['pic']; ?>" alt="author Image">
        <p><b>Author Name:</b><br> <?php echo htmlspecialchars($user['author_name']); ?></p>
        <p><b>Gender:</b><br> <?php echo htmlspecialchars($user['gender']); ?></p>
        
        <div class="op">
          <a href="editauthor.php?id=<?php echo $user['author_id']; ?>">Edit</a> 
          <a href="deleteauthor.php?id=<?php echo $user['author_id']; ?>">Delete</a>
        </div>
      </div>
    <?php } ?>
  </div>

</div>

</body>
</html>
