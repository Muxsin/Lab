<?php 

    session_start();

    if ($_SESSION['user'] === '' || isset($_SESSION['user']) === false) {
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <a href="register.php">Register</a>
    <?php
        echo "<a href='massage.php'>Massage</a>";
        echo "<a href='friends.php'>Friends</a>";
        echo "<h1> Hello " . $_SESSION['user']['user'] . "</h1>";
        echo "<h2>" . $_SESSION['user']['email'] . "</h2><br>";
    ?>
    <a href="logout.php">Logout</a>
</body>
</html>