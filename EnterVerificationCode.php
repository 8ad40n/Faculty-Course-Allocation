<?php
include("dbConnect.php");
session_start();

$otp = $_SESSION['otp'];

if (isset($_POST['submit'])) {
    $code = $_POST["code"];
    if ($code == $otp) {
        header('Location: ResetPassword.php');
        exit; // Don't forget to exit to stop executing the script further
    } else {
        echo "Wrong OTP! Please, Try Again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>

<body>
    <form method="post"> <!-- Use method="post" to send data via POST -->
        <label for="code">Enter OTP Code:</label><br>
        <input type="number" name="code"> <!-- Use type="text to accept text input -->
        <button type="submit" name="submit">Submit</button>
    </form>
</body>

</html>
