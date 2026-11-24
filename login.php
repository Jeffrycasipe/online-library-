<?php
session_start();
include 'conn.php';

	$uname=$_POST['Uname'];
	$pwd=$_POST['pass'];

	$sql= "SELECT * FROM tb_student WHERE (student_id =? AND stud_passsword=?)" ;
  $stmt = $conn->prepare($sql);
	$stmt->bindParam(1,$uname);
  $stmt->bindParam(2,$pwd);
	$stmt->execute();

	$count=$stmt->rowCount();
	$data=$stmt->fetchAll();

	foreach($data as $user){
		$_SESSION['user']=$user['student_id'];
		$_SESSION['stats']=$user['stats'];
	
};
$userstats=$_SESSION['stats'];
	if($count > 0){
		$_SESSION['user']=$user['student_id'];
		if($userstats=='APPROVED'){
			echo '<script>alert("Log in Successfuly"); window.location.href="home.php";</script>';
		}else if($userstats == 'DECLINED'){
			echo '<script>alert("You have been declined"); window.location.href="../html/login.html";</script>';
		}else{
			echo '<script>alert("Wait for admins approval"); window.location.href="../html/login.html";</script>';
		}
		
		// header("location:home.php");
		
		
	}else{
		echo '<script>alert("Invalid acount"); window.location.href="../html/login.html";</script>';
		
    }

if(isset($_POST['admlogin'])){

	$uname=$_POST['Uname'];
	$pwd=$_POST['pass'];
	$stmt=$conn->prepare("SELECT * FROM tb_admin WHERE adminUsername=? AND adminPassword=?");
	    $stmt->bindParam(1,$uname);
    
	    $stmt->bindParam(2,$pwd);
	    $stmt->execute();

        $count=$stmt->rowCount();
	    $data=$stmt->fetchAll();

	    foreach($data as $user){};
       

        if($count > 0){
            header("location:../php/admin.php");
        }else{
            echo 'Invalid Account';
        }
        
}
?>