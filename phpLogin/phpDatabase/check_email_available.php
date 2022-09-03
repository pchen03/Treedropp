<?php

$dbHost = '127.0.0.1';
$dbName = 'TreeDropp';
$dbUsername = "root";
$dbPassword = "";
$pdo = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName . ";chartset=utf8", $dbUsername, $dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['passEmail'])) {
    $emailCheck = $_POST['passEmail'];
}

// code user Email availablity
if (isset($emailCheck)) {
    if (filter_var($emailCheck, FILTER_VALIDATE_EMAIL) === false) {
        echo "Please enter a valid Email";
    } else {
        $sql = "SELECT Email FROM users WHERE Email='$emailCheck'";
        $query = $pdo->prepare($sql);
        $query->bindParam('$emailCheck', $emailCheck, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        if ($query->rowCount() > 0) {
            echo "Email already in use";
            // echo "<script>$('#signupButton').prop('disabled',true);</script>";
        } else {

            echo "Email available for Registration";
            // echo "<script>$('#signupButton').prop('disabled',false);</script>";
        }
    }
}
