<?php
session_start();

if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $id = count($_SESSION['products']) + 1;
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);
        $price = floatval($_POST['price']);
        
        $_SESSION['products'][] = ['id' => $id, 'name' => $name, 'description' => $description, 'price' => $price];
    }

    if (isset($_POST['update_product'])) {
        $id = intval($_POST['id']);
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);
        $price = floatval($_POST['price']);
        
        $_SESSION['products'][$id - 1] = ['id' => $id, 'name' => $name, 'description' => $description, 'price' => $price];
    }

    if (isset($_POST['delete_product'])) {
        $id = intval($_POST['id']);
        unset($_SESSION['products'][$id - 1]);
        $_SESSION['products'] = array_values($_SESSION['products']); // Re-index array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: cyan;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid cyan;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #005f5f;
            color: white;
        }
        .form-container {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid cyan;
            background-color: #222;
            color: cyan;
        }
        .form-container button {
            background-color: cyan;
            color: black;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #00ffff;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add Product</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <input type="number" name="price" placeholder="Product Price" step="0.01" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>
</div>

<h2>Product List</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($_SESSION['products'] as $product): ?>
    <tr>
        <td><?php echo $product['id']; ?></td>
        <td><?php echo $product['name']; ?></td>
        <td><?php echo $product['description']; ?></td>
        <td><?php echo number_format($product['price'], 2); ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <button type="submit" name="delete_product">Delete</button>
            </form>
            <button onclick="editProduct(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>', '<?php echo addslashes($product['description']); ?>', <?php echo $product['price']; ?>)">Edit</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
    function editProduct(id, name, description, price) {
        document.querySelector('input[name="name"]').value = name;
        document.querySelector('textarea[name="description"]').value = description;
        document.querySelector('input[name="price"]').value = price;
        const form = document.createElement('form');
        form.method = 'POST';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        input.name = 'update_product'; // Set the update action
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
</script>

</body>
</html>