<?php 
session_start();
require_once "db.php";
require "logInChecker.php";

$categoryName = $_POST['categoryName'];

addCateogry($categoryName);
header("Location: index.php"); 


?>