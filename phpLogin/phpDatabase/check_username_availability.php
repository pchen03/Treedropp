<?php

$dbHost = '127.0.0.1';
$dbName = 'TreeDropp';
$dbUsername = "root";
$dbPassword = "";
$pdo = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName . ";chartset=utf8", $dbUsername, $dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['username'])) {
    $usernameCheck = $_POST['username'];
}

// code user Email availablity
if (isset($usernameCheck)) {

    $sql = "SELECT Email FROM users WHERE Username='$usernameCheck'";
    $query = $pdo->prepare($sql);
    $query->bindParam('$emailCheck', $usernameCheck, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {

        echo "Username already in use";
        // echo "<script>$('#submit').prop('disabled',true);</script>";
    } else {

        echo "Username is available";
        //   echo "<script>$('#submit').prop('disabled',false);</script>";
    }
}
