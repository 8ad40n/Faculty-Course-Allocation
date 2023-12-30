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
        echo "<script>alert('Wrong OTP! Please, Try Again.')</script>";
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div class="container">
    <form method="post"> <!-- Use method="post" to send data via POST -->
    <br><br><center><h1>OTP Validation:</h1></center><br><br>
        <label for="code">Enter OTP Code:</label><br>
        <input type="number" class="form-control" name="code"> <!-- Use type="text to accept text input -->
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
    </div>
    
</body>

</html>
