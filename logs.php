<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library log in</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 30px;
            background: url('..style/books.jpg');
        }
        h1 {
            padding: 50;
            text-align: center;
            color: rgba(12, 15, 18, 0.85);
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #d40808;
            padding: 0px;
            background-color: aliceblue;
        }
        th {
            background-color:rgba(230, 13, 13, 0.05);
        }
    </style>
</head>
<body>
    <h1>LIBRARY LOG IN LIST</h1>
    <table>
        <thead>
            <tr>
                <th>ID NO.</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
        </thead>
        <tbody id="Librarylist">

        </tbody>
    </table>

    <script>
        syst
        const LIBRARYLOGINLIST = [
            { ID_N0: 1, LastNAME:"casipe" ,FirstName:"Jeffry",Email:"jeffrycasipe8@gmail.com"},
        ];

        
        const Librarylist = document.getElementById("Librarylist");
        LIBRARYLOGINLIST.forEach(user => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${user.ID_N0}</td>
                <td>${user.LastNAME}</td>
                <td>${user.FirstName}</td>
                <td>${user.Email}</td>
            `;
            Librarylist.appendChild(row);
        });
    </script>
</body>
</html>
