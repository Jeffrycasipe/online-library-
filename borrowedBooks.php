<?php
include 'con.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$stmt = $conn->prepare("SELECT student_id FROM tb_student WHERE student_id=?");
$stmt->bindParam(1, $_SESSION['user']);
$stmt->execute();

$data = $stmt->fetchAll();
foreach ($data as $user) {}

// Initialize search and genre filters
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
    $stmt = $conn->prepare("SELECT * FROM tb_brwbks WHERE (book_name LIKE ? OR description LIKE ?) AND (student_id=? AND B_Status='UNRETURN')");
    $searchTermWildcard = "%$searchQuery%";
    $stmt->bindParam(1, $searchTermWildcard);
    $stmt->bindParam(2, $searchTermWildcard);
    $stmt->bindParam(3, $_SESSION['user']);
} elseif (!empty($genreFilter)) {
    $stmt = $conn->prepare("SELECT * FROM tb_brwbks WHERE genre = ? AND (student_id=? AND B_Status='UNRETURN')");
    $stmt->bindParam(1, $genreFilter);
    $stmt->bindParam(2, $_SESSION['user']);
} else {
    $stmt = $conn->prepare("SELECT * FROM tb_brwbks WHERE student_id=? AND B_Status='UNRETURN'");
    $stmt->bindParam(1, $_SESSION['user']);
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
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(../img/ah1.jpg) no-repeat center center/cover;
      color: white;
      min-height: 100vh;
      position: relative;
    }

    header {
      background-color: #2c3e50;
     
      top: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      padding: 20px 50px;
      font-size: 1rem;
      z-index: 2;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .nav {
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

    .container {
      margin-top:-10px;
      padding: 20px;
    }

    
    .grid {
      display: grid;
      grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); /* Always 5 columns */
      gap:20px;
    }

    .grid-item {
     
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
    
  
 

    .grid-item:hover {
      transform: translateY(-10px);
      background-color: rgba(255, 255, 255, 0.2);
    }

    .grid-item img {
      width: 100%; 
  height: 240px;
  object-fit: cover; 
  border-radius: 10px; 
  display: block;
  margin-bottom: 15px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .grid {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on smaller screens */
      }
    }

    @media (max-width: 576px) {
      .grid {
        grid-template-columns: 1fr; /* 1 column on very small screens */
      }
    }

    .search-bar {
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
    .nav a:hover {
      background-color: #34495e;
      color: #40cc45;
    }
    .nav .navBook {
      color: red;
    }
  </style>
</head>
<body>
  
<header>
    <div class="logo">Virtual Library</div>
    <nav class="nav">
      <a href="home.php?id=<?php echo $user['student_id']; ?>"><i class="fas fa-home"></i>Home</a>
      <a href="books2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-book"></i>Books</a>
      <a href="ebooks2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-file"></i>Ebooks</a>

      <a href="borrowedBooks.php?id=<?php echo $_SESSION['user']; ?>" class="navBook"><i class="fas fa-list"></i>Borrowed Books</a>
      <a href="profile.php?id=<?php echo $_SESSION['user']; ?>"><img src="../img/acc2.png" style="width: 20px; height: 20px; border-radius: 10px; background-color: white; margin-bottom: -5px;"></a>
    </nav>
</header>

<div class="container">

  <div class="genre-section">
      <h1>Explore Genres</h1>
      <div class="categories">
        <a href="borrowedBooks.php">All</a>
        <?php
           $stmt = $conn->prepare("SELECT * FROM tb_brwbks WHERE student_id=?   GROUP BY genre");
           $stmt->bindParam(1, $_SESSION['user']);
           $stmt->execute();
           
           
          $gen = $stmt->fetchAll();
       foreach ($gen as $genre) { ?>

        <a href="borrowedBooks.php?genre=<?php echo $genre['genre'];?>"><?php echo $genre['genre'];?></a>
        <!-- <a href="borrowedBooks.php?genre=Action">Action</a>
        <a href="borrowedBooks.php?genre=Romance">Romance</a>
        <a href="borrowedBooks.php?genre=Fantasy">Fantasy</a>
        <a href="borrowedBooks.php?genre=Mystery">Mystery</a>
        <a href="borrowedBooks.php?genre=Science Fiction">Science Fiction</a> -->
        <?php } ?>
      </div>
  </div>

  <div class="search-bar">
      <form action="borrowedBooks.php" method="GET">
        <input type="text" name="search" placeholder="Search for a book name or its description" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit"><i class="fas fa-search"></i> Search</button>
      </form>
  </div>

  <div class="grid">
      <?php if (!empty($data)) { ?>
        <?php foreach ($data as $book) { ?>
          <div class="grid-item">
          <img src="<?php echo $book['filepath']; ?>" alt="Book Image">
          <p><b>Book Name:</b><br><?php echo htmlspecialchars($book['book_name']); ?></p>
            <!-- <p><b>Book Description:</b><br><?php echo htmlspecialchars($book['description']); ?></p>
            <p><b>Pages:</b> <?php echo htmlspecialchars($book['num_of_page']); ?></p> -->
            <p><b>Genre:</b> <?php echo htmlspecialchars($book['genre']); ?></p>
            <p><b>Quantity:</b> <?php echo htmlspecialchars($book['BookpiecesBorrwed']); ?></p>
            <p><b>Date Borrowed:</b><br> <?php echo ($book['date_borrowed']); ?></p>
            <p><b>Return Date:</b><br> <?php echo ($book['expected_return_date']); ?></p>
          </div>
        <?php } ?>
      <?php } else { ?>
        <p>No books found.</p>
      <?php } ?>
  </div>
</div>

</body>
</html>
