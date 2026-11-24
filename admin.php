<?php
include 'con.php';
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
      top: 70px; /* Adjusted to account for header height */
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
      margin-left: 240px; /* Adjusted for sidebar */
      padding: 20px;
      flex: 1;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 70px; /* Adjusted for header */
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
      height: 400px; /* Set height for the chart */
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">Admin Dashboard</div>
  </header>

  <div class="sidebar">
    <h3>Navigation</h3>
      <a href="admin.php" class="navBook"><i class="fas fa-home"></i> Home</a>
      <a href="user.php"><i class="fas fa-person"></i> Users</a>
      <a href="userapp.php" ><i class="fas fa-check"></i> Users Request</a>
      <a href="../php/books.php"><i class="fas fa-book"></i> Books</a>
      <a href="../php/ebooks.php"><i class="fas fa-file"></i> Ebooks</a>
      <a href="../php/author.php"><i class="fas fa-person"></i> Author</a>
      <a href="../php/access.php"><i class="fas fa-lock"></i> Ebook Access Req.</a>
      <a href="../php/record.php"><i class="fas fa-history"></i> Records</a>
      <a href="../index.html"><i class="fas fa-sign-out-alt"></i> Log Out</a>
  </div>

  <div class="main">
    <div class="welcome">Welcome, Admin!</div>
<?php
$stmt = $conn->prepare("SELECT COUNT(student_id)as student FROM tb_student WHERE stats='APPROVED'");
$stmt->execute();
$data = $stmt->fetchAll();
?>
    <div class="stats">
      <div class="stat-card">
        <h3>Total Users</h3>
        <?php foreach ($data as $user) { ?>
        <p><?php echo $user['student']; ?> Student/s</p>
        <?php } ?>
      </div>
      <?php
$stmt = $conn->prepare("SELECT SUM(quantity)as totalbooks FROM tb_books");
$stmt->execute();
$data = $stmt->fetchAll();
?>
      <div class="stat-card">
        <h3>Books Available</h3>
        <?php foreach ($data as $user) { ?>
        <p><?php echo $user['totalbooks']; ?> Books</p>
        <?php } ?>
      </div>
      <?php
$stmt = $conn->prepare("SELECT SUM(BookpiecesBorrwed)as totalbooks FROM tb_borrowed_books");
$stmt->execute();
$data = $stmt->fetchAll();
?>

      <div class="stat-card">
        <h3>Borrowed Books</h3>
        <?php foreach ($data as $user) { ?>
        <p><?php echo $user['totalbooks']; ?> Books</p>
        <?php } ?>
      </div>
    </div>


    <?php
            $stmt = $conn->prepare("SELECT course,COUNT(course) as course FROM `tb_student`WHERE stats='APPROVED'  GROUP BY course");
            $stmt->execute();
            $count=$stmt->rowCount();
            $data=$stmt->fetchAll();
            if($count>0){
               $age= array();
               $ages= array();
                    foreach($data as $user){
                        $age[]= $user['course'];
                        $ages[]= $user['course'];
                    };
                
            }
        ?>
        <!-- Graph Section --><br>
        <div class="graph-container">
            <h2><center>Approved User Course Graph</center></h2>
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    <!-- Canvas element for the chart -->
    <canvas id="myChart"></canvas>

    <script>
         
         const age = <?php echo json_encode($age); ?>;
         const ages = <?php echo json_encode($ages); ?>;
    const data ={
        labels: ages,
                datasets: [{
                    label: 'Users Course Graph',
                    data:age,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            };


         const config={
            type: 'bar',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
         }
        // Chart.js code
        const myChart= new Chart(
            document.getElementById('myChart'),
            config
        );
        
    </script>

    
  </div>
</body>
</html>
