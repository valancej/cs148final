<?php

include('dbconfig.php');
session_start();
$user_check = $_SESSION['uUsername'];

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $ses_sql = "SELECT uUsername FROM tblUsers WHERE uUsername= :usercheck";
    $ses_q = $db->prepare($ses_sql);
    $ses_q->execute(array(':usercheck' => $user_check));
    $ses_q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $ce) {
    die('ERROR: ' . $ce->getMessage());
}

$row = $ses_q->fetch();

$login_user = $row['uUsername'];

if (!isset($user_check)) {
    header("Location: https://jvalance.w3.uvm.edu/cs148/final/first.php");
}
?>