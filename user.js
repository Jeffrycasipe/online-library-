function frmSub(e, id) {
    e.preventDefault();
    let userID=$("#user_id").val();
 
    $.post("../php/update.php", {
        userID: userID
    }, function(data) {
        alert(data); 

        if (data== "Update Successfuly!") {
            window.location.href="../php/user.php";
        } else {
            
        }
    });
}
