<?php
session_start();
require_once "db.php";

$postIDToDelete = $_POST["selectedPostforDelete"];

deletePost($postIDToDelete);
header("Location: index.php"); 
?>