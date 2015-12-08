<?php 

include("pdoCheck.php");
include("pdoConfig.php");

$id = (int)$_GET['id'];

$msg = "";

if (isset($_POST["submit"])) {
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
    $q = $conn->prepare("DELETE FROM tblContactinfo WHERE cid = :cid");
    $q->bindParam(':cid', $id);
    
    
    if ($q->execute()) {
            $msg = 'Record Deleted.';
        }
    
    } catch (PDOException $de) {
        die("Error Connecting" . $de->getMessage());
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
        <form method="POST" action="">
            <h3><?php echo $msg; ?></h3>
            <input type="submit" name="submit" value="delete"/>
        </form>
    </body>
</html>
