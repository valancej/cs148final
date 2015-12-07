<?php
include("pdoCheck.php");
require_once 'dbconfig.php';
session_start();
$user_check = $_SESSION['uUsername'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM tblContactinfo WHERE uUsername = :usercheck";
    $q = $conn->prepare($sql);
    $q->execute(array(':usercheck' => $user_check));
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $pe) {
    die("Error Connecting" . $pe->getMessage());
}
?>

<?php
if (isset($_REQUEST) && !empty($_REQUEST)) {
    if (
            isset($_REQUEST['phoneNumber'], $_REQUEST['carrier'], $_REQUEST['smsMessage']) &&
            !empty($_REQUEST['phoneNumber'])
    ) {
        $message = wordwrap($_REQUEST['smsMessage'], 70);
        $to = $_REQUEST['phoneNumber'] . '@' . $_REQUEST['carrier'];
        $result = @mail($to, '', $message);
        echo '<h1>Message was sent to ' . $to . "</h1>";
    } else {
        print '<h1> Not all information was submitted. </h1>';
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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Contacts</title>
        <!-- Google Fonts -->

        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Exo+2:400,300,500,700,200' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="css/magnific-popup.css">


        <!-- Bootstrap Stylesheet -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body class="view-contact-page">      
        <div class="container view-contact-inner">
            <div id="test-popup" class="white-popup mfp-hide">
                <form action="" method="post">
                    <ul>
                        <li>
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" name="phoneNumber" id="phoneNumber" placeholder="3855550168" /></li>
                        <li>
                            <label for="carrier">Carrier</label>
                            <select name="carrier" required>
                                <option value="vtext.com">Verizon</option>
                                <option value="txt.att.net">AT & T</option>
                            </select>
                        </li>
                        <li>
                            <label for="smsMessage">Message</label>
                            <textarea name="smsMessage" id="smsMessage" cols="45" rows="15"></textarea>
                        </li>
                        <li><input type="submit" name="sendMessage" id="sendMessage" value="Send Message" /></li>
                    </ul>
                </form>
            </div>
            <h1><?php
echo $user_check;
?>'s Contacts</h1>
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Family or Relative</th>
                    <th>Phone Number</th>
                    <th>Phone Type</th>
                    <th>Email Address</th>
                    <th>Home Address</th>
                    <th>Contact Methods Available</th>
                    <th>Send Message</th>
                </tr>

                <?php while ($row = $q->fetch()): ?>

                    <tr><td><?php echo $row["ciFirst"] ?></td>
                        <td><?php echo $row["ciLast"] ?></td> 
                        <td><?php echo $row["ciMemberType"] ?></td>
                        <td><?php echo $row["ciPhoneNumber"] ?></td> 
                        <td><?php echo $row["ciPhoneType"] ?></td>
                        <td><?php echo $row["ciEmailAddress"] ?></td> 
                        <td><?php echo $row["ciHomeAddress"] ?></td> 
                        <td><?php echo $row["ciContactType"] ?></td>
                        <td><a href="#test-popup" class="open-popup-link">Send Text</a></td>
                    </tr>          

                <?php endwhile; ?>                   
            </table>
            <a href="/cs148/final/home.php"><button>Back to Home Page</button></a>
        </div>


    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Magnific Popup core JS file -->
    <script src="https://jvalance.w3.uvm.edu/cs148/final/js/jquery.magnific-popup.min.js"></script>

</html>
