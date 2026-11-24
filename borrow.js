function frmSub(e){
    e.preventDefault();
    let StudID = $("#sudent_id").val();
    let book_id=$("#book_id").val();
    let Erdate=$("#Exp_return_date").val();
    let quantitybrw=$("#qbrw").val();
    let bookqty =$("#quantity").val();
    let bookname =$("#bookname").val();
    let genre =$("#genre").val();
    


    $.post("../php/borrow.php",{
        student_id:StudID,
        book_id:book_id,
        Erdate:Erdate,
        quantitybrw:quantitybrw,
        bookqty:bookqty,
        bookname:bookname,
        genre:genre
        
        },function (data){
        alert(data)
        if(data=='Borrowed Successfuly'){
            window.location.href="../php/books2.php";
        }else{

        }
        }
        )
}

