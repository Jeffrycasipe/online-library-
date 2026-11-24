<?php
include 'con.php';


    $id=$_GET['id'];

    $stmt=$conn->prepare("SELECT * FROM tb_student WHERE student_id=?");
    $stmt->bindParam(1,$id);

	$stmt->execute();
    $user = $stmt->fetch();

    if ($user){
        $userStatus = $user['stats'];

        if($userStatus==='PENDING' || $userStatus==='APPROVED'){
            $stmt=$conn->prepare("UPDATE tb_student SET stats='DECLINED' WHERE student_id=?");

            $stmt->bindParam(1,$id);
	    
	        $stmt->execute();
           
            echo '<script> window.location.href="../php/user.php";alert("Update Successfuly");</script>';
    
    }else{
        echo '<script> window.location.href="../php/user.php";alert("Already declined user");</script>';
    }
}
?>