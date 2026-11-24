<?php
session_start();
include 'con.php';

$stmt = $conn->prepare("SELECT student_id FROM tb_student WHERE student_id=?");
$stmt->bindParam(1, $_SESSION['user']);
$stmt->execute();

$count = $stmt->rowCount();
$data = $stmt->fetchAll();

foreach ($data as $user) {
    // You can use $user['student_id'] if needed
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Library</title>
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
      background-image: url(../img/images.jpeg);
      background-repeat: no-repeat;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    header {
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
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
      transition: background 0.3s;
    }

    nav a i {
      margin-right: 8px;
    }

    .nav .navBook {
      color: red;
    }

    .nav a:hover {
      color: #40cc45;
      background-color: #34495e;
    }

    /* .nav .login {
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
    } */

    /* .container {
      flex: 1;
      padding: 20px;
      margin-top: 100px; 
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr); 
      gap: 20px;
    }

    .grid-item {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      transition: transform 0.3s, background-color 0.3s;
      text-align: center;
    }

    .grid-item:hover {
      transform: translateY(-10px);
      background-color: rgba(255, 255, 255, 0.2);
    }

    .grid-item img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }

    .grid-item p {
      margin: 10px 0;
      font-size: 1.1rem;
    }

    @media (max-width: 768px) {
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

    footer {
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
      width: 100%;
      margin-top: auto;
    }

    footer p {
      margin-bottom: 10px;
    }

    footer .social {
      margin-top: 10px;
    }

    footer .social a {
      color: white;
      font-size: 1.5rem;
      margin: 0 10px;
      text-decoration: none;
    }

    footer .social a:hover {
      color: #3498db;
    } */
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 90px 5%;
      background-color: #ecf0f1;
    }

    .hero-text {
      flex: 1;
    }

    .hero-text h1 {
      font-size: 3rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    .hero-text p {
      font-size: 1.2rem;
     
      color: #7f8c8d;
    }

    .search-bar {
      display: flex;
      margin-bottom: 20px;
    }

    .search-bar input {
      padding: 15px;
      border-radius: 5px;
      border: none;
      outline: none;
      width: 300px;
      font-size: 1rem;
      margin-right: 10px;
    }

    .search-bar button {
      padding: 15px 20px;
      background-color: #e67e22;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
    }

    .search-bar button:hover {
      background-color: #d35400;
    }

    .introduction-section {
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.6)), url(img/bg5.jpg) no-repeat center center/cover;
      background-size: cover;
      color:rgb(255, 255, 255);
      padding: 100px 5%;
      text-align: center;
    }

    .introduction-section h2 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    .introduction-section p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: .9;
    }

    .categories-section {
      padding: 60px 5%;
      background-color: #ecf0f1;
      text-align: center;
    }

    .categories-section h2 {
      font-size: 2.5rem;
      color: #2c3e50;
      margin-bottom: 40px;
    }

    .categories-list {
      display: flex;
      justify-content: space-between;
    }

    .category-card {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      width: 18%;
      text-align: center;
      transition: background-color 0.3s;
    }

    .category-card:hover {
      background-color: #dcdde1;
    }

    .category-card h4 {
      font-size: 1.2rem;
      color: #2c3e50;
    }

    footer {
      background-color: #2c3e50;
      color: white;
      padding: 30px 5%;
      text-align: center;
      margin-top: auto;
    }

    footer p {
      margin-bottom: 10px;
    }

    footer .social {
      margin-top: 10px;
    }

    footer .social a {
      color: white;
      font-size: 1.5rem;
      margin: 0 10px;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">Online Library</div>
    <nav class="nav">
      <a href="home.php?id=<?php echo $_SESSION['user']; ?>" class="navBook"><i class="fas fa-home"></i>Home</a>
      <a href="books2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-book"></i>Books</a>
      <a href="ebooks2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-file"></i>Ebooks</a>
      <a href="borrowedBooks.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-list"></i>Borrowed Books</a>
      <a href="profile.php?id=<?php echo $_SESSION['user']; ?>"><img src="../img/acc2.png" style="width: 20px; height: 20px; border-radius: 10px; background-color: white; margin-bottom: -5px;"></a>
    </nav>
  </header>

  <!-- <div class="container">
    <div class="grid">
      <div class="grid-item">
        <h3>Mission</h3>
        <p>Our mission is to provide accessible virtual library services to our students.</p>
      </div>
      <div class="grid-item">
        <h3>Vision</h3>
        <p>Our vision is to become a leader in providing digital library resources for academic success.</p>
      </div>
      <div class="grid-item">
        <h3>Core Values</h3>
        <p>Integrity, Knowledge, Service, and Innovation are the core values that guide us.</p>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 Virtual Library. All Rights Reserved.</p>
    <div class="social">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </footer> -->

  <section class="hero">
    <div class="hero-text">
      <h1>Welcome to Virtual Library</h1>
      <p>Explore thousands of books, articles, and resources. Whether you're a student or a book lover, there's something here for you.</p>
      <!-- <div class="search-bar">
        <input type="text" placeholder="Search for books, authors, genres...">
        <button>Search</button>
      </div> -->
    </div>
  </section>

  <section class="introduction-section">
    <h2>Your Gateway to Knowledge</h2>
    <p>Our Online library offers a diverse range of resources that cater to all interests and levels of expertise, providing a treasure trove of literature at your fingertips. Whether you’re searching for the latest bestsellers, classic novels, or academic journals, you’ll find everything you need to expand your knowledge and satisfy your curiosity. Join our vibrant community of readers and learners, where you can connect with others, share insights, and explore new perspectives. From fiction to non-fiction, and from history to science, our collection is designed to inspire, educate, and ignite your passion for learning. Start your journey today and unlock a universe of information, creativity, and inspiration waiting just for you!</p>
  </section>
  

  <!-- <section class="categories-section">
    <h2>Explore Categories</h2>
    <div class="categories-list">
      <div class="category-card">
        <h4>Fiction</h4>
      </div>
      <div class="category-card">
        <h4>Non-Fiction</h4>
      </div>
      <div class="category-card">
        <h4>Science</h4>
      </div>
      <div class="category-card">
        <h4>History</h4>
      </div>
      <div class="category-card">
        <h4>Biographies</h4>
      </div>
    </div>
  </section> -->

  <footer>
    <p>&copy; 2025 Online Library Management System. All Rights Reserved.</p>
    <div class="social">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </footer>

  
</body>
</html>
