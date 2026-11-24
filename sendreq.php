<?php
include 'con.php';
session_start();

$studentID = $_POST['stdid'];
if(isset($_POST['sub'])){
    $sql="SELECT * FROM tb_reqeb WHERE student_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$studentID);
    $stmt->execute();

    $count = $stmt->rowCount();
    $data = $stmt->fetchAll();
    if($count>0){
        echo '<script>alert("You Already sent a Request");window.location.href="ebooks2.php";</script>';

    }else{
        $sql="INSERT INTO tb_reqeb(student_id,access) VALUES (?,'PENDING')";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$studentID);
            
            if($stmt->execute()){
            echo '<script>alert("Request sent to administrator");window.location.href="ebooks2.php";</script>';
            
            }else{
            echo "Invalid Request";
            }
    }
    

    
}   

?>