<?php
include 'con.php';


    $id=$_GET['id'];
    $rid=$_GET['rid'];
    $stmt=$conn->prepare("SELECT * FROM tb_reqeb WHERE student_id=?");
    $stmt->bindParam(1,$id);

	$stmt->execute();
    $user = $stmt->fetch();

    if ($user){
        $userStatus = $user['access'];

        if($userStatus==='PENDING' || $userStatus==='REJECTED'){
            $stmt=$conn->prepare("UPDATE tb_reqeb SET access='GRANTED' WHERE reqID=?");

            $stmt->bindParam(1,$rid);
	    
	        $stmt->execute();
           
            echo '<script> window.location.href="../php/access.php";alert("Update Successfuly");</script>';
    
    }else{
        echo '<script> window.location.href="../php/access.php";alert("Already approved user");</script>';
    }
}
?>