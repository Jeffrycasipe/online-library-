<?php
include 'con.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add PDF</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../img/ah.PNG') no-repeat center center/cover;
            min-height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .form-container {
            background: #2c3e50;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1abc9c;
        }

        .form-container .btn-primary {
            background-color: #1abc9c;
            border: none;
            transition: background-color 0.3s;
        }

        .form-container .btn-primary:hover {
            background-color: #16a085;
        }

        .form-container a {
            text-decoration: none;
            color: white;
            transition: color 0.3s;
        }

        .form-container a:hover {
            color: #1abc9c;
        }

        .form-container .form-control {
            border-radius: 5px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Ebook File</h2>
        <form method="POST" action="addpdf.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="pdf" class="form-label">Upload Ebook</label>
                <input type="file" class="form-control" name="pdf" accept="application/pdf" required>
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label">Upload Ebook Cover</label>
                <input type="file" class="form-control" name="cover" id="cover" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Enter the title" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" name="genre" id="genre" placeholder="Enter the genre" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="d" id="description" placeholder="Enter a description" required>
            </div>
            
            <?php
            $sql = "SELECT * FROM tb_author";
            $stmt = $conn->prepare($sql);
            // Execute the statement
            $stmt->execute();
            // Fetch all rows
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <select class="form-control" name="author" id="author" required>
                <option value="noAuthor">Select Author...</option> 
                    <?php 
                    foreach ($data as $user) {
                    ?>
                        <option value="<?php echo $user['author_id']; ?>"> 
                            <?php echo $user['author_name']; ?>
                        </option> 
                    <?php 
                    }
                    ?>      
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Published Date</label>
                <input type="date" class="form-control" name="pdate" id="pdate" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="ebooks.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary" name="sub">Save</button>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
