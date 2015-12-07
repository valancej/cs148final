<?php
include("pdoCheck.php");
require_once 'dbconfig.php';

$ciFirst = $_POST["ciFirst"];
$ciLast = $_POST["ciLast"];
$ciPhoneType = $_POST["ciPhoneType"];
$ciContactType = implode(', ', $_POST['ciContactType']);
$ciPhoneNumber = $_POST["ciPhoneNumber"];
$ciMemberType = $_POST["ciMemberType"];
$ciEmailAddress = $_POST["ciEmailAddress"];
$ciHomeAddress = $_POST["ciHomeAddress"];

$msg = "";
if (isset($_POST["submit"])) {

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO tblContactinfo (ciFirst, ciLast, ciMemberType, ciPhoneNumber, ciPhoneType, ciEmailAddress,  ciHomeAddress, ciContactType, uUsername) VALUES (:ciFirst, :ciLast, :ciMemberType, :ciPhoneNumber, :ciPhoneType, :ciEmailAddress, :ciHomeAddress, :ciContactType, :user_check) ");

        $stmt->bindParam(':ciFirst', $ciFirst, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciLast', $ciLast, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciMemberType', $ciMemberType, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciPhoneNumber', $ciPhoneNumber, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciPhoneType', $ciPhoneType, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciEmailAddress', $ciEmailAddress, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciHomeAddress', $ciHomeAddress, PDO::PARAM_STR, 100);
        $stmt->bindParam(':ciContactType', $ciContactType, PDO::PARAM_STR, 100);
        $stmt->bindParam(':user_check', $user_check, PDO::PARAM_STR, 100);

        if ($stmt->execute()) {
            $msg = 'Record Inserted.';
        }
    } catch (PDOException $pe) {
        die("Error Connecting" . $pe->getMessage());
    }
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Hello, <?php
echo $login_user;
?>!</h1>
        <h2>Add New Contacts</h2>
        <form method="post" action="">
            <h3><?php echo $msg; ?></h3>
            <label for="ciFirst">First Name</label><br>
            <input type="text" name="ciFirst" class="input" required/><br>
            <label for="ciLast">Last Name</label><br>
            <input type="text" name="ciLast" class="input" required/><br>
            <label for="ciMemberType">Relative or Friend</label><br>
            <select name="ciMemberType" required>
                <option value="Family/Relative">Family/Relative</option>
                <option value="Friend/Coworker">Friend/Coworker</option>
            </select><br>
            <label for="ciPhoneNumber" name="ciPhoneNumber" class="input"/>Phone Number</label><br>
        <input type="text" name="ciPhoneNumber" class="input" required/><br>
        <label for="ciPhoneType">Phone Type</label><br>
        <input type="radio" name="ciPhoneType" value="Cell" class="input" required/>Cell<br>
        <input type="radio" name="ciPhoneType" value="Home" class="input" required/>Home<br>
        <input type="radio" name="ciPhoneType" value="Work" class="input" required/>Work<br>
        <label for="ciEmailAddress">Email Address</label><br>
        <input type="email" name="ciEmailAddress" class="input" required/><br>
        <label for="ciHomeAddress">Home Address</label><br>
        <input type="text" name="ciHomeAddress" class="input" required/><br>
        <label for="ciContactType">Methods Available for Contact</label><br>
        <input type="checkbox" name="ciContactType[]" value="Phone" class="input" />Phone<br>
        <input type="checkbox" name="ciContactType[]" value="Email" class="input" />Email<br>
        <input type="checkbox" name="ciContactType[]" value="Mail" class="input" />Mail<br>
        <input type="submit" name="submit" value="Add Contact"/>
    </form>
    <a href="/cs148/final/viewcontacts.php">View Contacts</a>
    <a href="/cs148/final/logout.php">Logout?</a>
</body>
</html>
