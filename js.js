function frmSub(e) {
    e.preventDefault();
    let Id = $("#Id").val();
    let Fname = $("#Fname").val();
    let Mname = $("#Mname").val();
    let Lname = $("#Lname").val();
    let Course = $("#Course").val();
    let Gender = $("#Gender").val();
    let Year = $("#Year").val();
    let Section = $("#Section").val();
    let Email = $("#Email").val();
    let Password = $("#Password").val();


    $.post("../php/signup.php", {
        Id: Id,
        Fname: Fname,
        Mname: Mname,
        Lname: Lname,
        Course: Course,
        Gender: Gender,
        Year: Year,
        Section: Section,
        Email: Email,
        Password: Password
    }, function (data) {
        alert(data)
        if (data == "Sign-up successful! wait for admins approval") {
            window.location.href = "../html/login.html";
        }
    }
    )
}

