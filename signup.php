<?php
session_start();
include 'conn.php';

$Id =$_POST['Id'];
$Fname=$_POST['Fname'];
$Mname=$_POST['Mname'];
$Lname=$_POST['Lname'];
$Gender=$_POST['Gender'];
$Email=$_POST['Email'];
$Course=$_POST['Course'];
$Year=$_POST['Year'];
$Section=$_POST['Section'];
$Password=$_POST['Password'];


$sql="INSERT INTO tb_student(student_id,first_name,middle_name,last_name,gender,email,course,yearLvl,section,stud_passsword,stats) VALUES (?,?,?,?,?,?,?,?,?,?,'PENDING')";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1,$Id);
$stmt->bindParam(2,$Fname);
$stmt->bindParam(3,$Mname);
$stmt->bindParam(4,$Lname);
$stmt->bindParam(5,$Gender);
$stmt->bindParam(6,$Email);
$stmt->bindParam(7,$Course);
$stmt->bindParam(8,$Year);
$stmt->bindParam(9,$Section);
$stmt->bindParam(10,$Password);

if($stmt->execute()){
  echo "Sign-up successful! wait for admins approval";
  
}else{
  echo "Invalid Account";
}


?>