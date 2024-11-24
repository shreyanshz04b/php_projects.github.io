<?php
include 'db1.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$id]);

header("Location: index1.php");
exit();
?>