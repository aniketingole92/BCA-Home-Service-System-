<?php
require_once 'config/database.php';

$id = $_GET['id'];

$sql = "DELETE FROM customers WHERE id = ?";
$stmt = $pdo->prepare($sql);

if($stmt->execute([$id])) {
    header('Location: view_customers.php?msg=deleted');
} else {
    header('Location: view_customers.php?msg=error');
}
?>