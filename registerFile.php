<?php

require_once ("dbconfig.php");

$msg = "";
if (isset($_POST["submit"])) {
    $uFirst = $_POST["uFirst"];
    $uLast = $_POST["uLast"];
    $uPhone = $_POST["uPhone"];
    $uEmail = $_POST["uEmail"];
    $uUsername = $_POST["uUsername"];
    $uPassword = $_POST["uPassword"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT uEmail FROM tblUsers WHERE uEmail= :uEmail";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':uEmail' => $uEmail));
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error Connecting" . $e->getMessage());
    }

    $row = $stmt->fetch();

    if ($row > 0) {
        $msg = "Sorry, this email already exists";
    } else {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO tblUsers (uFirst, uLast, uPhone, uEmail, uUsername, uPassword) VALUES (:uFirst, :uLast, :uPhone, :uEmail, :uUsername, :uPassword)";
            $q_stmt = $conn->prepare($query);

            $q_stmt->bindParam(':uFirst', $uFirst, PDO::PARAM_STR, 100);
            $q_stmt->bindParam(':uLast', $uLast, PDO::PARAM_STR, 100);
            $q_stmt->bindParam(':uPhone', $uPhone, PDO::PARAM_STR, 100);
            $q_stmt->bindParam(':uEmail', $uEmail, PDO::PARAM_STR, 100);
            $q_stmt->bindParam(':uUsername', $uUsername, PDO::PARAM_STR, 100);
            $q_stmt->bindParam(':uPassword', $uPassword, PDO::PARAM_STR, 100);

            if ($q_stmt->execute()) {
                $msg = 'Thank You! You are now registered. You will be redirected to the login page in 2 seconds..';
                header("Refresh:2; url=https://jvalance.w3.uvm.edu/cs148/final/index.php");
            }
        } catch (PDOException $ex) {
            die("Error Connecting" . $ex->getMessage());
        }
    }
}
?>

