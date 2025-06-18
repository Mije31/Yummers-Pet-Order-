<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT order_id, order_date, total_price, delivery_status FROM orders WHERE user_email = ? ORDER BY order_date DESC");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Order History</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
            color: #333;
        }

        table {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 20px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td {
            color: #444;
        }

        button {
            display: block;
            margin: 20px auto 40px;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            font-size: 1.1rem;
            color: #666;
        }
    </style>
</head>
<body>

<h2>Your Order History</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Total Price</th>
            <th>Order Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['order_id']) ?></td>
            <td>$<?= number_format($row['total_price'], 2) ?></td>
            <td><?= date("M d, Y H:i", strtotime($row['order_date'])) ?></td>
            <td><?= htmlspecialchars($row['delivery_status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center; font-size: 1.1rem;">No orders found.</p>
<?php endif; ?>

<button><a href="home.php">Back to home</a></button>

</body>
</html>
