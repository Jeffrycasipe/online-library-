function frmSub(e){
    
    let id = $("#id").val();
    let bookname=$("#bookname").val();
    let description=$("#description").val();
    let pagenum=$("#pagenum").val();
    let genre=$("#genre").val();
    let quantity=$("#quantity").val();
    


    $.post("../php/edit.php",{
        id: id,
        bookname:bookname,
        description:description,
        pagenum:pagenum,
        genre:genre,
        quantity:quantity
        
        },function (data){
        alert(data)
        if(data=='Edited Successfuly!'){
            window.location.href="../php/books.php";
        }else{

        }
        }
        )
}

