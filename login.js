function frmSub(e){
    e.preventDefault();
    let uname = $('#uname').val();
    let pass =$('#pass').val();
  
    
    $.post("../php/login.php",{
        uname: uname,
        pass:pass

        },function (data){
        alert(data);
        if(data=='log in successfuly'){
            window.location.href='../html/admin.html';
           
        }else{
            window.location.href='../index.html';
        }
        }
        )
}

