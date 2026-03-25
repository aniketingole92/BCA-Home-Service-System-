<?php
require_once 'config/database.php';

$id = $_GET['id'];

$sql = "DELETE FROM requirements WHERE id = ?";
$stmt = $pdo->prepare($sql);

if($stmt->execute([$id])) {
    header('Location: view_requirements.php?msg=deleted');
} else {
    header('Location: view_requirements.php?msg=error');
}
?>