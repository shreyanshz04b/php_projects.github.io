<?php
session_start();

// Initialize books array in session if it doesn't exist
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [];
}

// Handle form submission to add a book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $genre = $_POST['genre'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];

    // Create a new book entry
    $newBook = [
        'genre' => $genre,
        'title' => $title,
        'author' => $author,
        'isbn' => $isbn
    ];

    // Add the new book to the session
    $_SESSION['books'][] = $newBook;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #000;
            color: #fff;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px cyan;
            max-width: 600px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #00ffcc;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #00ffcc;
            border-radius: 4px;
            background-color: #222;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #00ffcc;
            color: black;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #00e6b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #00ffcc;
            text-align: left;
        }
        th {
            background-color: #00ffcc;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Library Management System</h1>
        <form method="post">
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required>

            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="isbn">ISBN Number:</label>
            <input type="text" id="isbn" name="isbn" required>

            <input type="hidden" name="action" value="add">
            <input type="submit" value="Add Book">
        </form>

        <?php if (!empty($_SESSION['books'])): ?>
            <h2>Books List</h2>
            <?php
            // Group books by genre
            $booksByGenre = [];
            foreach ($_SESSION['books'] as $book) {
                $booksByGenre[$book['genre']][] = $book;
            }
            ?>

            <?php foreach ($booksByGenre as $genre => $books): ?>
                <h3><?php echo htmlspecialchars($genre); ?></h3>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
 <th>ISBN</th>
                    </tr>
                    <?php foreach ($books as $bk): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bk['title']); ?></td>
                            <td><?php echo htmlspecialchars($bk['author']); ?></td>
                            <td><?php echo htmlspecialchars($bk['isbn']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>