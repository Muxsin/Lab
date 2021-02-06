<?php

    $HOST = "db";
    $USERNAME = "root";
    $PASSWORD = "secret";
    $DBNAME = "app";

    $conn = new mysqli($HOST, $USERNAME, $PASSWORD, $DBNAME);

    if(!$conn) {
        die ("Failed to connect to MySQL: " . mysqli_connect_error());
    }

?>
