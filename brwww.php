<?php
include 'con.php';
session_start();

// Fetch the student ID for the current session user
$stmt = $conn->prepare("SELECT student_id FROM tb_student WHERE student_id=?");
$stmt->bindParam(1, $_SESSION['user']);
$stmt->execute();
$data = $stmt->fetchAll();

foreach ($data as $user) {
    // You can use the $user variable below as needed
    $studentId = htmlspecialchars($user['student_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Dashboard</title>
    <link href="../bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-image: url(../img/images\ \(1\).jpeg);
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
            position: relative;
            color: white;
        }

        header {
            background-color: #3C3D37;
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 20px 50px;
            z-index: 2;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header .nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav .navBook {
            color: red;
        }

        .books {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
            padding: 100px 20px 20px; /* Add padding to avoid overlap with fixed header */
        }

        .book-detail1 {
            background-color: rgba(1, 1, 1, 0.5);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .book-detail1 p {
            font-size: 20px;
        }

        .book-detail1 img {
            max-width: 100%;
            border-radius: 10px;
        }

        .book-detail2 {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .book-detail2 p {
            text-align: center;
            font-size: 17px;
        }

        .op input[type="submit"] {
            font-size: 25px;
            background-color: white;
            color: black;
            padding: 5px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 10px;
            border: none;
        }

        .add {
            text-align: center;
            margin-top: 20px;
        }

        .add a {
            font-size: 30px;
            background-color: white;
            color: black;
            padding: 5px;
            border-radius: 10px;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 10px;
            }

            header .nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .books {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
  
    <header>
        <div class="logo">Online Library</div>
        <nav class="nav">
            <a href="home.php?id=<?php echo $studentId; ?>">Home</a>
            <a href="books2.php?id=<?php echo $studentId; ?>">Books</a>
            <a href="borrowedBooks.php?id=<?php echo $_SESSION['user']; ?>" class="navBook">Borrowed Books</a>
            <a href="profile.php?id=<?php echo $studentId; ?>">
                <img src="../img/acc2.png" style="width: 20px; height: 20px; border-radius: 10px; background-color: white;margin-bottom: -5px;">
            </a>
        </nav>
    </header>

    <?php
    // Fetch borrowed books
    $stmt = $conn->prepare("SELECT * FROM tb_brwbook WHERE student_id=? AND B_Status='UNRETURN'");
    $stmt->bindParam(1, $_SESSION['user']);
    $stmt->execute();
    $data = $stmt->fetchAll();
    ?>

    <div class="books">
        <?php foreach ($data as $user) { ?>
            <div class="book-detail1">
                <img src="../img/book.png" alt="Book Image">
                <p><b>Book Name:</b><br><?php echo htmlspecialchars($user['book_name']); ?></p>
                <p><b>Book Description:</b><br><?php echo htmlspecialchars($user['description']); ?></p>
                <div class="book-detail2">
                    <p><b>Pages:</b> <?php echo htmlspecialchars($user['num_of_page']); ?></p>
                    <p><b>Genre:</b> <?php echo htmlspecialchars($user['genre']); ?></p>
                    <p><b>Quantity:</b> <?php echo htmlspecialchars($user['BookpiecesBorrwed']); ?></p>
                </div>
                <p><b>Date Borrowed:</b><br> <?php echo ($user['date_borrowed']); ?></p>
                <p><b>Expected Return Date:</b><br> <?php echo ($user['expected_return_date']); ?></p>
                <!-- Uncomment below to enable return functionality
                <form onsubmit="frmSub(event)">
                    <input type="hidden" id="brwID" value="<?php echo ($user['borrowed_num']); ?>">
                    <input type="hidden" id="brwquantity" value="<?php echo $user['BookpiecesBorrwed'];?>">
                    <input type="hidden" id="bookID" value="<?php echo $user['book_id'];?>">
                    <div class="op">
                        <input type="submit" value="Return">
                    </div>
                </form>
                -->
            </div>
        <?php } ?>
    </div>

    

    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript" src="../js/return.js"></script>
</body>
</html>
    .op {
      margin-top: auto; /* Pushes the buttons to the bottom */
    }

    .op a {
      font-size: 25px;
      background-color: white;
      text-decoration: none;
      color: black;
      padding: 5px;
      border-radius: 10px;
      display: inline-block;
      margin-top: 10px; /* Space between text and buttons */
    }

    .add {
      text-align: center;
      margin-top: 20px; /* Space above the add books button */
    }

    .add a {
      font-size: 30px;
      background-color: white;
      text-decoration: none;
      color: black;
      padding: 5px;
      border-radius: 10px;
    }