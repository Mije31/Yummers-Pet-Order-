<?php
session_start();
include 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: admin_log.php");
    exit();
}



// Fetch products
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #3498db;
            color: white;
        }
        form {
            display: inline;
        }
        button {
            padding: 8px 15px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c0392b;
        }

        button.add {
            background-color: #3498db;
            margin: 20px auto;
            display: block;
            width: 150px;
            text-align: center;
        }
    </style>
</head>
<body>
    <button class = "add"><a href="productupdate.php" style="display: block; text-align: center; margin-top: 20px; text-decoration: none; color:rgb(0, 0, 0);">Add Products </a></button>
<button class = "delete"><a href="logoff_admin.php" style="display: block; text-align: center; margin-top: 20px; text-decoration: none; color:rgb(0, 0, 0);">Sign out </a></button>
<h2>Remove Products from Database</h2>

<table>
    <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['product_id']) ?></td>
        <td><?= htmlspecialchars($row['product_name']) ?></td>
        <td>£<?= number_format($row['product_price'], 2) ?></td>
        <td>
            <form action="remove_product.php" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>



</body>
</html>
