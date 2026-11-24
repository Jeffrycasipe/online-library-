<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    padding: 20px;
    background-color: #007bff;
    color: #fff;
    margin: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

nav ul {
    display: flex;
    justify-content: center;
    background-color: #fff;
    padding: 10px 0;
    margin: 0;
    list-style: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #007bff;
    color: #fff;
}

form {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

h3 {
    text-align: center;
    margin-top: 40px;
    color: #333;
}

.table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
    font-weight: bold;
    color: #333;
}

</style>
<body>
    <h1>
        BOOKS
    </h1>
    <nav>
        <ul>
            <li><a href="./dashboard.php">Home</a></li>
            <li><a href="./Books.php">Books</a></li>
            <li><a href="./logs.php">Logs</a></li>
        </ul>
    </nav>

    <form onsubmit="addBooks(event)">
        <label for="txtBookName" class="form-label">Book Name</label>
        <input type="text" class="form-control" id="txtBookName"/>

        <label for="txtTypesofBooks" class="form-label">Types of Books</label>
        <textarea class="form-control" id="txtTypesofBooks"></textarea>

        <label for="txtAuthor" class="form-label">Author</label>
        <input type="text" class="form-control" id="txtAuthor"/>

        <label for="txtAddDate" class="form-label">Add Date</label>
        <input type="date" class="form-control" id="txtAddDate"/>

        <label for="txtPublishDate" class="form-label">Publish Date</label>
        <input type="date" class="form-control" id="txtPublishDate"/>

        <label for="txtTime" class="form-label">Time</label>
        <input type="time" class="form-control" id="txtTime"/>

        <input type="submit" value="Save Event"/>
    </form>

    <h3>Event Details</h3>
    <table class="table">
    <thead>
      <tr>
        <th scope="col">Book Name</th>
        <th scope="col">Types of Books</th>
        <th scope="col">Author</th>
        <th scope="col">Add Date</th>
        <th scope="col">Publish Date</th>
        <th scope="col">Time</th>
      </tr>
    </thead>
    <tbody id="tblEventDetails">
    </tbody>
  </table>


    <script src="../js/jquery.js"></script>
    <script src="../js/index.js"></script>

</body>
</html>