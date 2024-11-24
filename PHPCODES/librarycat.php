<?php
function getBooks() {
    if (file_exists('books.json')) {
        $booksJson = file_get_contents('books.json');
        return json_decode($booksJson, true);
    }
    return [];
}

function saveBooks($books) {
    file_put_contents('books.json', json_encode($books, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $books = getBooks();
        if ($_POST['action'] === 'add') {
            $books[] = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'genre' => $_POST['genre'],
                'publication_year' => $_POST['publication_year'],
                'isbn' => $_POST['isbn'],
            ];
            saveBooks($books);
        } elseif ($_POST['action'] === 'edit') {
            $index = $_POST['index'];
            $books[$index] = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'genre' => $_POST['genre'],
                'publication_year' => $_POST['publication_year'],
                'isbn' => $_POST['isbn'],
            ];
            saveBooks($books);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_GET['delete'])) {
        $books = getBooks();
        unset($books[$_GET['delete']]);
        saveBooks(array_values($books));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$books = getBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-shadow: 2px 2px 4px cyan;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid cyan;
            text-align: left;
        }
        th {
            background-color: rgba(0, 255, 255, 0.2);
        }
        tr:hover {
            background-color: rgba(0, 255, 255, 0.1);
        }
        input[type="text"], input[type="number"] {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid cyan;
            border-radius: 5px;
            background-color: black;
            color: white;
            box-shadow: 2px 2px 5px cyan;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: cyan;
            border: none;
            border-radius: 5px;
            color: black;
            cursor: pointer;
            box-shadow: 2px 2px 5px cyan;
        }
        input[type="submit"]:hover {
            background-color: rgba(0, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <h1>Library Catalog</h1>
    <form method="post">
        <h2>Add New Book</h2>
        <input type="hidden" name="action" value="add">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="author">Author:</label>
        <input type="text" name="author" required>
        <br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre" required>
        <br>
        <label for="publication_year">Publication Year:</label>
        <input type="number" name="publication_year" required>
        <br>
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required>
        <br>
        <input type="submit" value="Add Book">
    </form>

    <h2>Book Catalog</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
            <th>ISBN</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($books as $index => $book): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['genre']) ?></td>
                <td><?= htmlspecialchars($book['publication_year']) ?></td>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                        <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required>
                        <input type="number" name="publication_year" value="<?= htmlspecialchars($book['publication_year']) ?>" required>
                        <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required>
                        <input type="submit" value="Update">
                    </form>
                    <a href="?delete=<?= $index ?>" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>1