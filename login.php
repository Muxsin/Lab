<?php

    require('database.php');
    session_start();

    if(isset($_SESSION['user']) === true && $_SESSION['user'] !== "") {
        header('Location: index.php');
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        if($password === "" || $email === "") {
            $_SESSION['error'] = "Fields can not be empty!";
        } else {
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
    
            if($result === NULL) {
                $_SESSION['error'] = "User not exict!";
            } else {
                if(password_verify($password, $result['password'])) {
                    $_SESSION['user'] = [
                        'id' => $result['id'],
                        'user' => $result['username'],
                        'email' => $result['email']
                    ];
                    header('Location: index.php');
                } else {
                    $_SESSION['error'] = "Password incorrect!";
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <!-- Title -->
    <title>Register</title>
</head>
<body>
    <div class="container">
        <a href="register.php">Register</a>
        <div class="card" style="width: 22rem;">
            <div class="card-header text-primary">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <form method="post" class="form">
                    <div class="form-group mb-2">
                        <?php
                            $error = $_SESSION['error'];
                            echo "<p style='color: red;'>$error</p>";
                            $_SESSION['error'] = '';
                        ?>
                    </div>
                    <div class="form-group mb-2">
                        <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $_POST['email']; ?>">
                    </div>
                    <div class="form-group mb-2">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mb-2">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
