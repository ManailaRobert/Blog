<?php 
    session_start(); // because it functions like a page since its called on a button that is in a form
    session_destroy(); 
    header("Location: login.php");
    exit;