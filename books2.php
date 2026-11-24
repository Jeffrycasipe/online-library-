<?php
include 'con.php';
session_start();

// echo $_SESSION['user'];
$stmt = $conn->prepare("SELECT student_id FROM tb_student WHERE student_id=?");
$stmt->bindParam(1, $_SESSION['user']);
$stmt->execute();

$count = $stmt->rowCount();
$data = $stmt->fetchAll();
foreach ($data as $user) { /* Optionally, you can include user information here */ }

$searchQuery = '';
$genreFilter = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}
if (isset($_GET['genre'])) {
    $genreFilter = $_GET['genre'];
}

// Modify the query to search for books based on genre or search term
if (!empty($searchQuery)) {
    $stmt = $conn->prepare("SELECT * FROM tb_authorsbook WHERE ((book_name LIKE ? OR description LIKE ?)or author_name LIKE ?) AND quantity>0");
    $searchTermWildcard = "%$searchQuery%";
    $stmt->bindParam(1, $searchTermWildcard);
    $stmt->bindParam(2, $searchTermWildcard);
    $stmt->bindParam(3, $searchTermWildcard);

} elseif (!empty($genreFilter)) {
    $stmt = $conn->prepare("SELECT * FROM tb_authorsbook WHERE genre = ? AND quantity>0");
    $stmt->bindParam(1, $genreFilter);
} else {
    $stmt = $conn->prepare("SELECT * FROM tb_authorsbook WHERE quantity>0");
}
$stmt->execute();
$data = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books Dashboard</title>
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
    .nav .navBook {
      color: red;
    }
    .nav .login {
      padding: 10px 20px;
      border: 2px solid white;
      border-radius: 20px;
      font-size: 0.9rem;
      text-transform: uppercase;
      transition: background-color 0.3s ease;
    }

    .nav .login:hover {
      background-color: white;
      color: #333;
    }

    

    .container {
      margin-top: 50px;
      padding: 20px;
    }

    
    .grid {
      display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
  gap: 20px;
  padding: 20px;
    }

    .grid-item {
      max-width: 200px; 
      margin: 10px auto; 
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      transition: transform 0.3s, background-color 0.3s;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .grid-item .info {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      border-radius: 10px;
      background: rgba(0, 0, 0, 1);
      color: white;
      padding: 15px;
      opacity: 0; /* Initially hidden */
      transform: translateY(100%); /* Positioned below the grid item */
      transition: transform 0.3s ease, opacity 0.3s ease;
}
.grid-item:hover .info {
  opacity: 1; /* Show on hover */
  transform: translateY(0); /* Slide into view */
}
  

    .grid-item:hover {
      transform: translateY(-10px);
      background-color: rgba(255, 255, 255, 0.2);
    }

    .grid-item img {
      width: 100%;
  height: 220px; 
  object-fit: cover; 
  border-radius: 10px;
  display: block;
  margin-bottom: 15px;
    }

    .grid-item p {
      margin: 1px 0;
      font-size: 1.1rem;
    }

    .op a {
      margin-top: 10px;
      font-size: 20px;
      background-color: white;
      text-decoration: none;
      color: black;
      padding: 10px 15px;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    .op a:hover {
      background-color: #40cc45;
      color: white;
    }

    /* Responsive for smaller screens */
    @media (max-width: 768px) {
      .container {
        margin-top: 140px;
      }

      header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }

      .nav {
        flex-direction: column;
        gap: 15px;
      }

      .grid {
        grid-template-columns: repeat(2, 1fr); 
      }
    }

    @media (max-width: 576px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }
    
    .search-bar form {
      display: flex;
      justify-content: center;
      padding-bottom: 10px;
    }

    .search-bar input[type="text"] {
      padding: 10px;
      width: 320px;
      border-radius: 5px;
      border: none;
      font-size: 1rem;
    }

    .search-bar button {
      padding: 10px 20px;
      margin-left: 10px;
      background-color: #34495e;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .search-bar button:hover {
      background-color: #2c3e50;
    }
    .genre-section {
      background-color: #34495e; /* Background color for the genre section */
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: center;
    }

    .genre-section h1 {
      font-size: 2rem;
      color: #fff;
      margin-bottom: 15px;
    }

    .categories {
      display: flex;
      justify-content: center;
      flex-wrap: wrap; /* Wrap buttons to the next line if needed */
      gap: 10px; /* Space between buttons */
    }

    .categories a {
      padding: 10px 20px;
      background-color: #2c3e50;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .categories a:hover {
      background-color: #1abc9c; /* Different hover color */
    }
  </style>
</head>
<body>
  
<header>
    <div class="logo">Online Library</div>
   <nav class="nav">
      <a href="home.php?id=<?php echo $user['student_id']; ?>"><i class="fas fa-home"></i>Home</a>
      <a href="books2.php?id=<?php echo $_SESSION['user']; ?>" class="navBook"><i class="fas fa-book"></i>Books</a>
      <a href="ebooks2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-file"></i>Ebooks</a>
      <a href="borrowedBooks.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-list"></i>Borrowed Books</a>
      <a href="profile.php?id=<?php echo $_SESSION['user']; ?>"><img src="../img/acc2.png" style="width: 20px; height: 20px; border-radius: 10px; background-color: white; margin-bottom: -5px;"></a>
    </nav>
</header>
<br>

<div class="container">
<div class="genre-section">
      <h1>Explore Genres</h1>
      <div class="categories">
      <a href="books2.php">All</a>
      <?php
      $stmt = $conn->prepare("SELECT * FROM tb_books GROUP BY genre");
      $stmt->execute();
      $gen = $stmt->fetchAll();
       foreach ($gen as $genre) { ?>

        <a href="books2.php?genre=<?php echo $genre['genre'];?>"><?php echo $genre['genre'];?></a>
        <!-- <a href="books2.php?genre=Romance">Romance</a>
        <a href="books2.php?genre=Fantasy">Fantasy</a>
        <a href="books2.php?genre=Mystery">Mystery</a>
        <a href="books2.php?genre=Science Fiction">Science Fiction</a> -->
        
       <?php }?>
      </div>
    </div>

   <div class="search-bar">
      <form action="books2.php" method="GET">
        <input type="text" name="search" placeholder="Search for a book name or its description" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit"><i class="fas fa-search"></i> Search</button>
      </form>
    </div>

    <div class="grid">
      <?php if (!empty($data)) { ?>
        <?php foreach ($data as $book) { ?>
          <div class="grid-item">
            <img src="<?php echo $book['filepath']; ?>" alt="Book Image">
            <p><b>Book Name:</b> <br> <?php echo htmlspecialchars($book['book_name']); ?></p>
            
            <p><b>Genre:</b> <?php echo htmlspecialchars($book['genre']); ?></p>
            <p><b>Quantity:</b> <?php echo htmlspecialchars($book['quantity']); ?></p>
            <div class="info">
            <!-- <p><b>Book Name:</b> <br> <?php echo htmlspecialchars($book['book_name']); ?></p>        
            <p><b>Genre:</b> <?php echo htmlspecialchars($book['genre']); ?></p>
            <p><b>Quantity:</b> <?php echo htmlspecialchars($book['quantity']); ?></p> -->
            <p><b>Description:</b> <br> <?php echo htmlspecialchars($book['description']); ?></p>
            <p><b>Author:</b> <?php echo htmlspecialchars($book['author_name']); ?></p>
            <p><b>published date:</b> <?php echo htmlspecialchars($book['published_date']); ?></p>
            <div class="op">
              <a href="borrowbook.php?id=<?php echo $book['book_id']; ?>">Borrow</a> 
            </div>
          </div>
            
          </div>
        <?php } ?>
      <?php } else { ?>
        <p>No books found.</p>
      <?php } ?>
    </div>
</div>

</body>
</html>
