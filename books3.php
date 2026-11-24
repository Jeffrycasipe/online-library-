<?php
include 'conn.php';

// Set error mode to exception for debugging
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if a search query or genre filter is set
$searchQuery = '';
$genreFilter = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}
if (isset($_GET['genre'])) {
    $genreFilter = $_GET['genre'];
}

// Modify the query to search for books based on genre or search term
try {
    if (!empty($searchQuery)) {
        $stmt = $conn->prepare("SELECT * FROM authorsbook WHERE book_name LIKE ? OR description LIKE ?");
        $searchTermWildcard = "%$searchQuery%";
        $stmt->bindParam(1, $searchTermWildcard);
        $stmt->bindParam(2, $searchTermWildcard);
    } elseif (!empty($genreFilter)) {
        $stmt = $conn->prepare("SELECT * FROM authorsbook WHERE genre = ?");
        $stmt->bindParam(1, $genreFilter);
    } else {
        $stmt = $conn->prepare("SELECT * FROM authorsbook");
    }
    $stmt->execute();
    $data = $stmt->fetchAll();
    print_r($data); // Debugging: Display fetched data
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books Dashboard</title>
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
      padding: 20px 5%;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header .logo {
      font-size: 1.8rem;
      font-weight: 600;
    }

    nav {
      display: flex;
      gap: 20px;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      padding: 10px 15px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      transition: background 0.3s;
    }

    nav a i {
      margin-right: 8px;
    }

    nav .navBook {
      color: red;
    }
    nav a:hover {
      color: #40cc45;
      background-color: #34495e;
    }

    .container {
      
      padding: 20px;
    }

    /* New styles for the genre section */
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

    /* Custom 4-column grid layout */
    .grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 20px;
      border-radius: 10px;
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
  border-radius: 10px;
  opacity: 1; /* Show on hover */
  transform: translateY(0); /* Slide into view */
}
  

    .grid-item:hover {
      border-radius: 10px;
      transform: translateY(-10px);
      background-color: rgba(255, 255, 255, 0.2);
    }

    .grid-item img {
      width: 100%; /* Make the image take the full width of its container */
  height: 220px; /* Set a fixed height */
  object-fit: cover; /* Ensures the image covers the area while maintaining aspect ratio */
  border-radius: 10px; /* Rounded corners */
  display: block; /* Ensures images are treated as block elements */
  margin-bottom: 15px; /* Space below image */
    }

    .grid-item p {
      margin: 5px 0;
      font-size: 1.1rem;
    }

    .search-bar {
      margin-bottom: 20px;
    }

    .search-bar form {
      display: flex;
      justify-content: center;
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

    /* Responsive for smaller screens */
    @media (max-width: 768px) {
      .grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 576px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">Online Library</div>
    <nav>
      <a href="../index.html"><i class="fas fa-home"></i>Home</a>
      <a href="../books3.php" class="navBook"><i class="fas fa-book"></i>Books</a>
      <a href="../html/login.html"><i class="fas fa-sign-in-alt"></i>Login</a>
    </nav>
  </header>

  <div class="container">
    <!-- Genre Section -->
    <div class="genre-section">
      <h1>Explore Genres</h1>
      <div class="categories">
      <a href="books3.php">All</a>
      <?php
      $stmt = $conn->prepare("SELECT * FROM tb_books GROUP BY genre");
      $stmt->execute();
      $gen = $stmt->fetchAll();
       foreach ($gen as $genre) { ?>

        <a href="../books3.php?genre=<?php echo $genre['genre'];?>"><?php echo $genre['genre'];?></a>
        <!-- <a href="books2.php?genre=Romance">Romance</a>
        <a href="books2.php?genre=Fantasy">Fantasy</a>
        <a href="books2.php?genre=Mystery">Mystery</a>
        <a href="books2.php?genre=Science Fiction">Science Fiction</a> -->
        
       <?php }?>
      </div>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
      <form action="books3.php" method="GET">
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
            <p><b>Description:</b> <br> <?php echo htmlspecialchars($book['description']); ?></p>
            <p><b>Genre:</b> <?php echo htmlspecialchars($book['genre']); ?></p>
            <div class="info">
            <p><b>Author:</b> <?php echo htmlspecialchars($book['author_name']); ?></p>
            <p><b>Published Date:<br></b> <?php echo htmlspecialchars($book['published_date']); ?></p>
            
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
