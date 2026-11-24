<?php
include 'con.php';
session_start();
$student=$_SESSION['user'];

$stmt=$conn->prepare("SELECT * FROM tb_studpen WHERE student_id=? AND penStats='ONGOING'");
$stmt->bindParam(1,$student);
$stmt->execute();
$pencount=$stmt->rowCount();
$pendata=$stmt->fetchAll();

$stmt=$conn->prepare("SELECT * FROM tb_studlostbk WHERE student_id=? AND penaltystats='ONGOING'");
$stmt->bindParam(1,$student);
$stmt->execute();
$lostcount=$stmt->rowCount();
$lostdata=$stmt->fetchAll();
if($pencount>0 || $lostcount >0){
  echo '<script>alert("You cant borrow you still have an Ongoing Penalty");window.location.href = "books2.php";</script>';
}else{


  $book_id=$_GET['id'];

$stmt=$conn->prepare("SELECT * FROM tb_books WHERE book_id=?");
$stmt->bindParam(1,$book_id);
$stmt->execute();
    
$count=$stmt->rowCount();
$data=$stmt->fetchAll();
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      /* background-color: #0e3b6e; */
      background:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(../img/bookshelfs.jpg);
      color: #fff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .container {
      color: black;
      background: linear-gradient(140deg, #3C3D37, #697565); 
      padding:10px;
      border-radius: 20px;
      width: 35%;
      height: auto;
      text-align: center;
      /* z-index: 1; */
      
    }
    .container h1,p{
      color: white;
    }
    .container a{
      color: rgb(11, 0, 160);
    }
    .container a:hover{
      color: rgb(201, 18, 18);
    }
    .container input[type="text"],.container input[type="password"],.container input[type="date"],.container input[type="number"],select{
        width:90%;
        height: 50px;
        margin-top: 5px;
        margin-bottom:5px;
        font-size: 15px;
        padding: 10px;
        border: 1px solid #ffffff;
        border-radius: 5px;
        background-color: rgba(255, 255, 255,1);
        
    }
    .container input[type="submit"]{
       
            color: rgb(0, 0, 0);
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 40%;
            margin:20px;
           
            
    }
    .container input[type="submit"]:hover{
      background-color: #40cc45;
      color: #ffffff;
    }
    .btn a, .btn input[type="submit"] {
        background-color: white;
        display: inline-block;
        width: 40%;
        font-size: 18px;
    }
    .btn a{
        text-decoration: none;
       
        color: rgb(0, 0, 0);
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 40%;
        margin:20px;
       
    }
    .btn a:hover{
        background-color: #d41010;
        color: #ffffff;
    }
    label{
        color:white;
        float:left;
        padding-left:24px;
        
    }
    label {
      color: white;
      float: left;
      padding-left: 24px;
    }

    img {
      max-width: 80%;
      height: 200px;
      border-radius: 10px;
      margin-bottom: 20px;
      transition: transform 0.3s ease-in-out;
    }

    img:hover {
      transform: scale(1.05);
    }

    /* Flexbox for better layout */
    .img{
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  
  <div class="container">
    <form onsubmit="frmSub(event)">
     <h1>Borrow Book</h1>
     <?php
     foreach($data as $user){?>

        <!-- <label for="student_id">Student Id</label> -->
        <input type="hidden" id="sudent_id" value="<?php echo $_SESSION['user']; ?>">
        <input type="hidden" id="genre" value="<?php echo $user['genre']; ?>">

        <!-- <label for="book_id">Book Id</label> -->
        <input type="hidden" id="book_id" value="<?php echo $user['book_id']; ?>">
        <input type="hidden" id="quantity" value="<?php echo $user['quantity']; ?>"> 
        <div class="img">
                  <img src="<?php echo $user['filepath']; ?>" alt="Book Image">

        </div>

        <label for="book_name">Book Name</label>
        <input type="text" id="bookname" placeholder="Book Name" value="<?php echo $user['book_name']; ?>" readonly>
        
        <!-- <label for="borrow_date">Borrow Date</label>
        <input type="date" id="date_borrowed" required> -->
        
        <label for="Exp_return_date">Return Date</label>
        <input type="date" id="Exp_return_date" required>

        <label for="quantity">Book pieces</label>
        <input type="number" id="qbrw" required>

        
        <div class="btn">
            <a href="../php/books2.php">CANCEL</a>
            <input type="submit" value="SAVE" name="Save">   
        </div>
    <?php          
    };
    ?>
        
       
    </form>
  </div>
  <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript" src="../js/borrow.js"></script>
</body>

</html>
<?php
}
?>



