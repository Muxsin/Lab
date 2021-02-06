<?php
    require('database.php');
    session_start();

    if ($_SESSION['user'] === '' || isset($_SESSION['user']) === false) {
        header('Location: login.php');
    }

        $user_id = $_SESSION['user']['id'];

    $sql = "SELECT * FROM friends WHERE adjuster_id=? || receiver_id=? AND received=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $user_id, $user_id, $a = 1);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
</head>
<body>
    <a href="index.php">Home</a>
    <a href="register.php">Register</a>
    <h1>Friends</h1>
    <?php
        if(empty($result)) {
            echo "<p>You don't have any friends!</p>";
        } else {
            foreach($result as $item) {
                if($item['adjuster_id'] !== $user_id) {
                    $sql = "SELECT * from users WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $item['adjuster_id']);
                    $stmt->execute();
                    $friend = $stmt->get_result()->fetch_assoc();
                    $stmt->close();

                    echo $friend['username'] . "<br>";
                } else {
                    $sql = "SELECT * from users WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $item['receiver_id']);
                    $stmt->execute();
                    $friend = $stmt->get_result()->fetch_assoc();
                    $stmt->close();

                    echo $friend['username'] . "<br>";
                }
            }
        }
    ?>
</body>
</html>
