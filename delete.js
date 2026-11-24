function frmSub(e, id) {
    e.preventDefault();

 
    $.post("../php/delete.php", {
        id: id 
    }, function(data) {
        alert(data); 

        if (data.trim() === "Delete book Successfully") {
           
            window.location.href = "../php/books.php";
        } else {
           
            alert("Error: " + data);
        }
    });
}
