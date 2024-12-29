<?php
session_start();
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credentials=[
        "username"=>$_POST['username'],
        "password"=>$_POST['password'],
        "reTypePassword"=>$_POST['reTypePassword']
    ];
    $role = performSignUp($credentials);
    // Verify credentials

    if($role == 1)
        $error = "Username already registered";
    else if ($role !== null) {
        header("Location: login.php"); // Redirect to the homepage
        exit;
    } else {
        $error = "Invalid passwords do no match.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/styles/background.css">
    <link rel="stylesheet" href="./styles/logInLogOut.css">  

</head>
<body >
    <div class="container">
    <h1>Sign Up</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>
    <form method="post" action="signIn.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="retypepassword">Retype Password:</label>
        <input type="password" name="reTypePassword" id="reTypePassword" required>
        <button type="submit">Login</button>
        <label>You have an account? Login <a href="logIn.php">here.</a></label>
    </form>
    </div>

</body>
</html>