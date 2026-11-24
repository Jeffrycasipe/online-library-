<?php
include 'con.php';
session_start();

// echo $_SESSION['user'];

$stmt = $conn->prepare("SELECT * FROM tb_student WHERE student_id=?");
$stmt->bindParam(1, $_SESSION['user']);
$stmt->execute();

$count = $stmt->rowCount();
$data = $stmt->fetchAll();
foreach ($data as $user) {
   $_SESSION['stats']=$user['stats'];
}
$userstats = $_SESSION['stats'];

$stmt = $conn->prepare("SELECT * FROM tb_reqeb WHERE student_id=?");
$stmt->bindParam(1,$_SESSION['user']);
$stmt->execute();

$rcount = $stmt->rowCount();
$rdata = $stmt->fetchAll();

if ($rcount > 0) {
    foreach ($rdata as $ruser) {
        if (isset($ruser['access'])) {
            $_SESSION['access'] = $ruser['access'];
        }
    }
} else {
    $_SESSION['access'] = null; // or set a default value
}
$useraccess = $_SESSION['access'];


$searchQuery = '';
$genreFilter = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}
if (isset($_GET['genre'])) {
    $genreFilter = $_GET['genre'];
}

if (!empty($searchQuery)) {
    $stmt = $conn->prepare("SELECT * FROM tb_authorebook WHERE (ebook_tittle LIKE ? OR ebook_description LIKE ?)");
    $searchTermWildcard = "%$searchQuery%";
    $stmt->bindParam(1, $searchTermWildcard);
    $stmt->bindParam(2, $searchTermWildcard);
} elseif (!empty($genreFilter)) {
    $stmt = $conn->prepare("SELECT * FROM tb_authorebook WHERE eGenre = ?");
    $stmt->bindParam(1, $genreFilter);
} else {
    $stmt = $conn->prepare("SELECT * FROM tb_authorebook");
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
    /* General Reset and Styling */
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
    nav .navBook {
      color: red;
    }
   

    .nav a:hover {
      background-color: #34495e;
      color: #40cc45;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.7);
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 20px;
      border-radius: 10px;
      width: 50%;
      color: #333;
    }

    .close-btn {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .modal-buttons button,input[type="submit"] {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .modal-buttons .cancel-btn {
      background-color: #ccc;
    }

    .modal-buttons .send-request-btn {
      background-color: #40cc45;
      color: white;
    }

    .modal-buttons .send-request-btn:hover {
      background-color: #34495e;
    }

    /* Search Section */
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

    /* Book List */
    .container {
      margin-top: 50px;
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
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, background-color 0.3s;
      align-items: center;
    }

    .list-item:hover {
      transform: translateY(-5px);
      background-color: rgba(255, 255, 255, 0.2);
    }

    .list-item-img img {
      width: 120px;
      height: 180px;
      object-fit: cover;
      border-radius: 20%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

    .actions a {
      display: inline-block;
      margin: 5px;
      padding: 10px 15px;
      background-color: #40cc45;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-size: 14px;
      transition: background-color 0.3s;
    }

    .actions a:hover {
      background-color: #34495e;
    }

    .view-pdf-text {
      color: #3498db;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s;
    }

    .view-pdf-text:hover {
      color: #2980b9;
    }
  </style>
</head>
<body>

<header>
    <div class="logo">Virtual Library</div>
    <nav class="nav">
      <a href="home.php?id=<?php echo $user['student_id']; ?>"><i class="fas fa-home"></i>Home</a>
      <a href="books2.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-book"></i>Books</a>
      <a href="ebooks2.php?id=<?php echo $_SESSION['user']; ?>" class="navBook"><i class="fas fa-file"></i>E-books</a>
      <a href="borrowedBooks.php?id=<?php echo $_SESSION['user']; ?>"><i class="fas fa-list"></i>Borrowed Books</a>
      <a href="profile.php?id=<?php echo $_SESSION['user']; ?>"><img src="../img/acc2.png" style="width: 20px; height: 20px; border-radius: 10px; background-color: white; margin-bottom: -5px;"></a>
    </nav>
</header>
<br>
<!-- Book List -->
<div class="container">
   <div class="list">
      <?php foreach ($data as $book) { ?>
         <div class="list-item">
            <div class="list-item-img">
               <img src="../upload/<?php echo $book['ebook_cover']; ?>" alt="Book Cover">
            </div>
            <div class="list-item-content">
               <h3><?php echo $book['ebook_tittle']; ?></h3>
               <p><strong>Genre:</strong> <?php echo $book['eGenre']; ?></p>
               <p><strong>Description:</strong> <?php echo substr($book['ebook_description'], 0, 150); ?>...</p>
               <div class="actions">
                  <?php if (!empty($book['ebook_filepath'])) { 
                     
                     if($useraccess == 'GRANTED'){ ?>
                        <a href="<?php echo $book['ebook_filepath']; ?>" download target="_blank" class="download-btn">Download</a>
                     <?php } else { ?>
                        <a href="#" class="download-btn" onclick="showModal()">Download</a>
                    <?php } ?>
                     <a href="<?php echo $book['ebook_filepath']; ?>" target="_blank" class="view-pdf-text">View PDF</a>
                  <?php } else { ?>
                     <p>No PDF available</p>
                  <?php } ?>
               </div>
            </div>
         </div>
      <?php } ?>
   </div>
</div>

<!-- Modal -->
<div id="modal" class="modal">
   <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2>You are not allowed to download this e-book.</h2>
      <p>Please contact the administrator if you believe this is an error.</p>
      <div class="modal-buttons">
         <form action="sendreq.php" method="POST">
         <input type="hidden" name="stdid" value="<?php echo $_SESSION['user']; ?>">
         <button class="cancel-btn" onclick="closeModal()">Cancel</button>
         <input type="submit" name="sub" value="Send Request" class="send-request-btn "> 
         <!-- <button class="send-request-btn" onclick="sendRequest()">Send Request</button> -->
         </form>
         
      </div>
   </div>
</div>

<!-- Scripts -->
<script>
   function showModal() {
      document.getElementById('modal').style.display = 'block';
   }

   function closeModal() {
      document.getElementById('modal').style.display = 'none';
   }

   // function sendRequest() {
   //    // Add your request sending logic here (e.g., make an AJAX request)

   //    let stdid =$('#stdid').val();

   //    $.post("sendreq.php", {
	// 	stdid:stdid
	// }, function (data) {
   //    alert(data);
   //    if(data=='Request sent to administrator.'){
	// 	// alert('Request sent to administrator.');
   //    closeModal();
   //    }else{
   //       closeModal();
   //    }
	// })
   // }

   // Close the modal when the user clicks anywhere outside of the modal
   window.onclick = function(event) {
      if (event.target == document.getElementById('modal')) {
         closeModal();
      }
   }
</script>

</body>
</html>
