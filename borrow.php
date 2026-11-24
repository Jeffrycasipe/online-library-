<?php
include 'con.php';
session_start();

    $student_id=$_POST['student_id'];
	$book_id=$_POST['book_id'];
	$Erdate=$_POST['Erdate'];
    $quantitybrw=$_POST['quantitybrw'];
    $bookqty = $_POST['bookqty'];
    $bookname=$_POST['bookname'];
    $genre = $_POST['genre'];


    
    $sql= "SELECT * FROM tb_brwbks WHERE (book_id=? AND B_Status !='RETURNED' AND (date_borrowed= CURDATE() AND expected_return_date = ?)) AND student_id=?" ;

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$book_id);
   
    $stmt->bindParam(2,$Erdate);
    $stmt->bindParam(3,$student_id);
	$stmt->execute();

    $count=$stmt->rowCount();
	$data=$stmt->fetchAll();

	foreach($data as $user){
    // $_SESSION['user']=$user['book_id'];
    }
        $date="SELECT * FROM tb_borrowed_books WHERE CURDATE() >= ? AND student_id=?";
        $stmt = $conn->prepare($date);
        $stmt->bindParam(1,$Erdate);
        $stmt->bindParam(2,$student_id);
        $stmt->execute();

        $dcount=$stmt->rowCount();
	    $ddata=$stmt->fetchAll();
// if($count>0){
//     echo "Borrowed Successfuly";
// }else{
//     echo $count;
// }
if($dcount==0){
    if($count>0){
        $sql="UPDATE tb_borrowed_books SET BookpiecesBorrwed=BookpiecesBorrwed+? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(2,$student_id);
        // $stmt->bindParam(2,$book_id);
        // $stmt->bindParam(3,$Erdate);
        $stmt->bindParam(1,$quantitybrw);
        
        if($quantitybrw>0){
            if($stmt->execute()){
                // echo "Borrowed Successfuly";
                $stmt = $conn->prepare("UPDATE tb_books SET quantity = quantity -? Where book_id=?");
                $stmt->bindParam(1,$quantitybrw);
                $stmt->bindParam(2,$book_id);
                
                if($bookqty>=$quantitybrw){
                    if($stmt->execute()){
                        echo "Borrowed Successfuly";
                    }
                }else{
                    echo "Invalid quantity";
                }
        
        
            }else{
                echo "invalid";
            }
        }else{
            echo "Book Pieces can't be 0";
        }

    }else{
    $sql="INSERT INTO tb_borrowed_books(student_id,book_id,expected_return_date,BookpiecesBorrwed,date_borrowed,B_Status) VALUES (?,?,?,?,CURDATE(),'UNRETURN')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$student_id);
    $stmt->bindParam(2,$book_id);
    $stmt->bindParam(3,$Erdate);
    $stmt->bindParam(4,$quantitybrw);
    
    if($quantitybrw>0){
        if($stmt->execute()){
            // echo "Borrowed Successfuly";
            $stmt = $conn->prepare("UPDATE tb_books SET quantity = quantity -? Where book_id=?");
            $stmt->bindParam(1,$quantitybrw);
            $stmt->bindParam(2,$book_id);
            
            if($bookqty>=$quantitybrw){
                if($stmt->execute()){
                    echo "Borrowed Successfuly";
                }
            }else{
                echo "Invalid quantity";
            }
    
    
        }else{
            echo "invalid";
        }
    }else{
        echo "Book Pieces can't be 0";
    }
    }
}else{
    echo "Invalid Date!";
}




    // if($count>0){
    //     $sql="UPDATE tb_borrowed_books SET BookpiecesBorrwed=BookpiecesBorrwed+? WHERE student_id=?";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(2,$student_id);
    //     // $stmt->bindParam(2,$book_id);
    //     // $stmt->bindParam(3,$Erdate);
    //     $stmt->bindParam(1,$quantitybrw);
        
    //     if($quantitybrw>0){
    //         if($stmt->execute()){
    //             // echo "Borrowed Successfuly";
    //             $stmt = $conn->prepare("UPDATE tb_books SET quantity = quantity -? Where book_id=?");
    //             $stmt->bindParam(1,$quantitybrw);
    //             $stmt->bindParam(2,$book_id);
                
    //             if($bookqty>=$quantitybrw){
    //                 if($stmt->execute()){
    //                     echo "Borrowed Successfuly";
    //                 }
    //             }else{
    //                 echo "Invalid quantity";
    //             }
        
        
    //         }else{
    //             echo "invalid";
    //         }
    //     }else{
    //         echo "Book Pieces can't be 0";
    //     }

    // }else{
    // $sql="INSERT INTO tb_borrowed_books(student_id,book_id,expected_return_date,BookpiecesBorrwed,date_borrowed,B_Status) VALUES (?,?,?,?,CURDATE(),'UNRETURN')";
    // $stmt = $conn->prepare($sql);
    // $stmt->bindParam(1,$student_id);
    // $stmt->bindParam(2,$book_id);
    // $stmt->bindParam(3,$Erdate);
    // $stmt->bindParam(4,$quantitybrw);
    
    // if($quantitybrw>0){
    //     if($stmt->execute()){
    //         // echo "Borrowed Successfuly";
    //         $stmt = $conn->prepare("UPDATE tb_books SET quantity = quantity -? Where book_id=?");
    //         $stmt->bindParam(1,$quantitybrw);
    //         $stmt->bindParam(2,$book_id);
            
    //         if($bookqty>=$quantitybrw){
    //             if($stmt->execute()){
    //                 echo "Borrowed Successfuly";
    //             }
    //         }else{
    //             echo "Invalid quantity";
    //         }
    
    
    //     }else{
    //         echo "invalid";
    //     }
    // }else{
    //     echo "Book Pieces can't be 0";
    // }
    // }
?>