<?php
if (isset($_POST["Verify"])) {
    include_once("SMTP/class.phpmailer.php");
    include_once("SMTP/class.smtp.php");
    
    $email = $_POST["Email"];
    $verificationCode = generateVerificationCode();
    
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->Username = "restaurentmanagement@gmail.com"; // Enter your Gmail email
    $mail->Password = "gqebtkdusbtscblo"; // Enter your Gmail app password
    $mail->FromName = "Tech Area";
    $mail->AddAddress($email);
    $mail->Subject = "Verification Code";
    $mail->isHTML(true);

    $mail->Body = "Your verification code is: " . $verificationCode;

    if ($mail->send()) {
        $msg = "We have e-mailed your verification code!";
    } else {
        $msg = "Error sending the verification code.";
    }
}

function generateVerificationCode($length = 6) {
    $characters = '0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Verification Code</title>
</head>
<body>
    <form method="POST">
        Email: <input type="email" name="Email" placeholder="Enter the email"><br>
        <button name="Verify">Verify</button>
    </form>
</body>
</html>
