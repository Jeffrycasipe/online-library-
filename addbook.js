function frmSub(e){
   e.preventDefault();
    let bookname=$("#bookname").val();
    let description=$("#description").val();
    let pagenum=$("#pagenum").val();
    let genre=$("#genre").val();
    let quantity=$("#quantity").val();
    let author=$("#author").val();
    let pdate=$("#pdate").val();
    


    $.post("../php/addbook.php",{
        bookname: bookname,
        description:description,
        pagenum:pagenum,
        genre:genre,
        quantity:quantity,
        author:author,
        pdate:pdate
        },function (data){
        alert(data);
        if(data== 'Book Added'){
            window.location.href='../php/books.php';
        }else{
            window.location.href='../html/addbook.html';
        }
        }
        )
}