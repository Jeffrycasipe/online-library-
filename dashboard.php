<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
body{
    background:url('../style/sss.jpg');
}
label.logo{
    background-color:black;
    background-size: cover; 
    color: white;
    font-size: 40px;
    line-height: 90px;
    padding: 0 100px;
    font-weight: bold;
}
nav ul{
    float: right;
    margin-right: 20px;
}
nav ul li{
    display: inline-block;
    line-height: 80px;
    margin: 0 5px;
}
nav ul li a{
    color: white;
    font-size: 20px;
    text-transform:uppercase;
}
a.active,a:hover{
    background: #1b9bff;
    transition: .5s;
}
.checkbtn{
    font-size: 30px;
    color: rgb(250, 47, 7);
    float: right;
    line-height: 80px;
    margin-right: 40px;
    cursor: pointer;
    display: none;
}
#check{
    display: none;
}
@media(max-width: 952px){
    label.logo{
        font-size: 3opx;
        padding-left: 50px;
    }
    nav ul li a{
        font-size: 26px;
    }
}
@media (max-width:858px){
    .checkbtn{
        display: block;
    }
    ul{
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 100px;
        left: 0;
        text-align:left;
    }
    nav ul li{
        display: block;
        margin: 50px 0;
        line-height: 30px;
    }
    nav ul li a{
        font-size: 20px;
    }
    a:hover,a.active{
        background: none;
        color:#052efbf4
    }
    #check:checked ~ ul{
        left: 0;
    }
}
    </style>

</head>
<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">LIBRARY DASHBOARD</label>
        <ul>
            <li><a class="active" href="#">Home</a></li>
            <li><a href="../src/book.php">Books</a></li>
            <li><a href="../src/logs.php">Logs</a></li>
        </ul>
    </nav>
    <section></section>
</body>
</html>