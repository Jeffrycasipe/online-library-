function registration(e) {
    e.preventDefault();
    var lastname = $("#lastname").val();
    var firstname = $("#firstname").val();
    var middlename = $("#middlename").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var idno = $("#idno").val();
    var user = $("#user").val();

    $.post("./php/registration.php", {
        xlastname: lastname,
        xfirstname: firstname,
        xmiddlename: middlename,
        xemail: email,
        xpassword: password,
        xidno: idno,
        xuser: user

    }, function(data) {
        console.log(data);
        let datax = JSON.parse(data);
        if (datax.status == "success") { 
            alert("Registration successful");
            window.location.href = "./src/login.html";
        } else {
            alert("Resgistration Error!!");
        }
    })
}

function login(e) {
    e.preventDefault();
    var email = $("#emailadd").val();
    var password = $("#pass").val();
    $.post("../php/login.php", {
        xemail : email,
        xpassword : password

    }, function(data) {
        if (data == "user found") { 
            alert("Log In successful");
            window.location.href = "../src/dashboard.php";
        } else {
            alert(data);
        }
    })
}
