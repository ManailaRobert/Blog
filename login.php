<?php
session_start();
require "db.php";


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credentials=[
        "username"=>$_POST['username'],
        "password"=>$_POST['password']
    ];
    $dataReceived = performLogIn($credentials);
    // Verify credentials
    if ($dataReceived !== null) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['role'] = $dataReceived["role"];
        $_SESSION['accountID'] = $dataReceived["accountID"];
        header("Location: index.php"); // Redirect to the homepage
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/styles/background.css">
    <link rel="stylesheet" href="./styles/logInLogOut.css">  

</head>
<body >
    <div class="container">
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Login</button>
        <label>You dont have an account? Sign up <a href="signIn.php">here.</a></label>
    </form>
    </div>

</body>
</html>