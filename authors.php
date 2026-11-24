<?php
include 'con.php';
session_start();

echo $_SESSION['user'];

// Query to fetch authors from the database
$stmt = $conn->prepare("SELECT * FROM tb_author");
$stmt->execute();
$authors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authors Dashboard</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(../img/ah.PNG) no-repeat center center/cover;
      color: white;
      min-height: 100vh;
      position: relative;
    }

    header {
      background-color: #2c3e50;
      position: absolute;
      top: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      padding: 20px 50px;
      font-size: 1rem;
      z-index: 2;
    }

    header .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }

    header .nav {
      display: flex;
      gap: 30px;
      align-items: center;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      padding: 10px 15px;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .nav a:hover {
      background-color: #34495e;
      color: #40cc45;
    }

    .nav .navAuthor {
      color: red;
    }

    .container {
      margin-top: 80px;
      padding: 20px;
    }

    .list {
      display: flex;
      flex-direction: column;
      gap: 20px;
      padding: 20px;
    }

    .list-item {
      display: flex;
      gap: 20px;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, background-color 0.3s;
      align-items: center;
    }

    .list-item:hover {
      transform: translateY(-5px);
      background-color: rgba(255, 255, 255, 0.2);
    }

    .list-item-content {
      flex: 1;
    }

    .list-item-content h3 {
      font-size: 1.5rem;
      color: #fff;
      margin-bottom: 10px;
    }

    .list-item-content p {
      font-size: 1rem;
      color: #ddd;
      margin: 5px 0;
    }
  </style>
</head>
<body>
  
<header>
  <div class="logo">Virtual Library</div>
  <nav class="nav">
    <a href="home.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-home"></i> Home</a>
    <a href="books2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-book"></i> Books</a>
    <a href="ebooks2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-file"></i> E-books</a>
    <a href="authors.php?id=<?php echo $_SESSION['user']; ?>" class="navAuthor"><i class="fas fa-pen"></i> Authors</a>
    <a href="profile.php?id=<?php echo $_SESSION['user']; ?>"><img src="../img/acc2.png" style="width: 20px; height: 20px; border-radius: 10px; background-color: white; margin-bottom: -5px;"></a>
  </nav>
</header>

<div class="container">
  <h1>Authors</h1>
  <div class="list">
    <?php foreach ($authors as $author) { ?>
      <div class="list-item">
        <div class="list-item-content">
          <h3><?php echo $author['author_name']; ?></h3>
          <p><strong>Bio:</strong> <?php echo substr($author['author_name'], 0, 150); ?>...</p>
          <p><strong>Country:</strong> <?php echo $author['author_name']; ?></p>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

</body>
</html>
