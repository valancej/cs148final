<?php

session_start();
require_once 'dbconfig.php';

$error = "";
if (isset($_POST["submit"])) {
    if (empty($_POST["uUsername"]) || empty($_POST["uPassword"])) {
        $error = "Both fields are required.";
    } else {

        $uUsername = $_POST['uUsername'];
        $uPassword = $_POST['uPassword'];

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $sql = "SELECT uid FROM tblUsers WHERE uUsername = :username AND uPassword = :password";
            $q = $conn->prepare($sql);
            $q->execute(array(':username' => $uUsername, ':password' => $uPassword));
            $q->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $pe) {
            die("Error Connecting" . $pe->getMessage());
        }

        if ($row == $q->fetch()) {
            $_SESSION['uUsername'] = $row['uUsername'];
            header("location: https://jvalance.w3.uvm.edu/cs148/final/home.php");
        } else {
            $error = "Incorrect username or password.";
        }
    }
}
?>