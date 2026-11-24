<?php
include 'con.php';
$stmt = $conn->prepare("SELECT *,CONCAT(first_name,' ',middle_name,' ',last_name) as name FROM tb_student ");
$stmt->execute();



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-image: url(../img/images\ (3\).jpeg);
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
      /* Adjusted to account for header height */
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

    .sidebar .navBook {
      color: red;
    }

    .main {
      margin-left: 240px;
      /* Adjusted for sidebar */
      padding: 20px;
      flex: 1;
      background-color: #ECEBDE;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 70px;
      /* Adjusted for header */
    }

    .welcome {
      font-size: 1.5rem;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 20px;
    }

    .stat-card {
      background-color: #ecf0f1;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .stat-card h3 {
      margin-bottom: 10px;
      color: #2980b9;
    }

    .stat-card p {
      color: #7f8c8d;
    }

    #myChart {
      margin-top: 40px;
      max-width: 800px;
      height: 400px;
      /* Set height for the chart */
    }

    .dashboard-container {
      width: 100%;
      max-width: 100%;
      background-color: #ECEBDE;
      /* Softer light gray */
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      padding: 10px;
      margin-bottom: 30px;
      transition: transform 0.2s ease;
    }

    .dashboard-container:hover {
      transform: translateY(-5px);
    }

    .dashboard-container {
      width: 100%;
      max-width: 100%;
      background-color: #f8f9fa;
      /* Softer light gray */
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      padding: 10px;
      margin-bottom: 30px;
      transition: transform 0.2s ease;
    }

    .dashboard-container:hover {
      transform: translateY(-5px);
    }

    a.action-btn {
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 14px;
      font-weight: bold;
      color: white;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s, transform 0.2s;
    }

    a.action-btn:hover {
      transform: scale(1.05);
    }

    a.approve-btn {
      background-color: #28a745;
      /* Green */
    }

    a.approve-btn:hover {
      background-color: #218838;
      /* Darker green */
    }

    a.decline-btn {
      background-color: #dc3545;
      /* Red */
    }

    a.decline-btn:hover {
      background-color: #c82333;
      /* Darker red */
    }

    .btnUpdate {
      padding: 12px;
      border-radius: 8px;
      background-color: #00e11a;
      color: white;
      cursor: pointer;
      text-decoration: none;
      width: 100%;
      text-align: center;
      font-size: 16px;
      border: none;
    }

    .btnUpdate:hover {
      padding: 12px;
      border-radius: 8px;
      background-color: #09bf1e;
      color: white;
      cursor: pointer;
      text-decoration: none;
      width: 100%;
      text-align: center;
      font-size: 16px;
      border: none;
    }

    td {
      padding: 10px;
    }

    #userTable {
      border: 1px solid black;
      border-radius: 10px;
    }
  </style>
</head>

<body>

  <header>
    <div class="logo">Admin Dashboard</div>
  </header>

  <div class="sidebar">
    <h3>Navigation</h3>
    <a href="admin.php"><i class="fas fa-home"></i> Home</a>
    <a href="user.php" class="navBook"><i class="fas fa-users"></i> Users</a>
    <a href="userapp.php"><i class="fas fa-check"></i> Users Request</a>
    <a href="../php/books.php"><i class="fas fa-book"></i> Books</a>
    <a href="../php/ebooks.php"><i class="fas fa-file"></i> Ebooks</a>
    <a href="../php/author.php"><i class="fas fa-person"></i> Author</a>
    <a href="../php/access.php"><i class="fas fa-lock"></i> Ebook Access Req.</a>
    <a href="../php/record.php"><i class="fas fa-history"></i> Records</a>
    <a href="../index.html"><i class="fas fa-sign-out-alt"></i> Log Out</a>
  </div>

  <div class="main">
    <!-- <div class="welcome">Welcome, Admin!</div> -->

    <div class="dashboard-container">


      <center>
        <h1>Welcome to Your Dashboard</h1>


        <table id="userTable">
          <thead>
            <tr>

              <th>Name</th>
              <th> </th>
              <th>Status</th>
              <th>Course</th>

            </tr>
          </thead>
          <tbody>
            <!-- Data rows will be dynamically generated here -->

            <?php
            $data = $stmt->fetchAll();
            foreach ($data as $user) {
              $_SESSION['stats'] = $user['stats'];
              $stats = $_SESSION['stats'];
              ?>
              <tr>
                <td><?php echo $user['name']; ?></td>
                <td></td>
                <td><?php echo $user['stats']; ?></td>
                <td><?php echo $user['Course']; ?></td>

              </tr>
              <?php
            }
            ;
            ?>



          </tbody>
        </table>
      </center>
    </div>
  </div>
  <script type="text/javascript" src="../jquery/jquery.js"></script>
  <script type="text/javascript" src="../js/user.js"></script>
</body>

</html>