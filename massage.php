<?php
    require('database.php');
    session_start();

    if ($_SESSION['user'] === '' || isset($_SESSION['user']) === false) {
        header('Location: login.php');
    }

    $user_id = $_SESSION['user']['id'];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $msg = $_POST['msg'];
        $sql = "INSERT INTO massages (user_id, content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->bind_param('is', $user_id, $msg);

        if ($result) {
            $stmt->execute();
            $stmt->close();
            $_SESSION['success'] = 'Massage sent!';
        } else {
            var_dump($result);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Massage</title>
</head>
<body>
    <a href="index.php">Home</a>
    <a href="register.php">Register</a>
    <?php
        $success = $_SESSION['success'];
        echo "<p style='color: green;'>$success</p>";
        $_SESSION['success'] = '';
    ?>
    <h1>Massage</h1>
    <div>
        <?php
            $sql = 'SELECT content FROM massages WHERE user_id=?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $massages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            foreach($massages as $massage) {
                $item = htmlspecialchars($massage['content']);
                $user = htmlspecialchars($_SESSION['user']['user']);
                echo "
                <div style='display: flex;'>
                    <p style='background: green; padding: 10px; color: white;'>$user</p>
                    <p style='display: inline; padding: 10px; border: 1px solid black;'>$item</p>
                </div>";
            }
        ?>
    </div>
    <form action="" method="post">
        <textarea name="msg" cols="100" rows="3"></textarea>
        <button>Send</button>
    </form>
</body>
</html>
