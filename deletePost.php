<?php
session_start();
require_once "db.php";
require "logInChecker.php";


$postIDToDelete = $_POST["selectedPostforDelete"];

deletePost($postIDToDelete);
header("Location: index.php"); 
?>