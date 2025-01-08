<?php 
session_start();
require "logInChecker.php";
require_once "db.php";

if(isset($_POST['postID'])){
    $post = [
        'postID' => $_POST['postID'],
        'title' => $_POST['postTitle'],
        'content' => $_POST['postContent'],
        'categoryID' =>$_POST['selectedCategory']
       ];
       updatePost($post);
       
}else{
    $post = [
        'accountID' => $_SESSION['accountID'],
        'title' => $_POST['postTitle'],
        'content' => $_POST['postContent'],
        'categoryID' =>$_POST['selectedCategory']
       ];
       addPost($post);
       
}


header("Location: index.php"); 
?>