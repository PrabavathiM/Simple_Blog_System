<?php
session_start();
include(__DIR__ . '/App/database/connect.php');
//user is authentication 
$id = $_GET['id'];
$Username = $_SESSION['Username'];
//Check if user is logged in
$stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("is", $id, $Username);
$stmt->execute();

header('Location: Dashboard.php');
exit;
?>