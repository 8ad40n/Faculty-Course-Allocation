<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Verify"])) {
        $email = $_POST["Email"];
        $verificationCode = generateVerificationCode(6);

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = "your_email@gmail.com"; // Replace with your Gmail email
        $mail->Password = "your_password"; // Replace with your Gmail app password
        $mail->FromName = "Tech Area";
        $mail->AddAddress($email);
        $mail->Subject = "Verification Code";
        $mail->isHTML(true);
        $mail->Body = "Your verification code is: " . $verificationCode;

        if ($mail->send()) {
            echo "success"; // Send confirmation to the client
        } else {
            echo "error"; // Send error to the client
        }
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
    <form method="POST" id="verifyForm">
        Email: <input type="email" name="Email" id="email" placeholder="Enter the email"><br>
        <button type="button" name="Verify" id="verifyButton">Verify</button>
    </form>
    <p id="resultMessage"></p>
    
    <script>
        document.getElementById('verifyButton').addEventListener('click', function() {
            var email = document.getElementById('email').value;
            var resultMessage = document.getElementById('resultMessage');
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Replace with the URL of your PHP script
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText === "success") {
                        resultMessage.textContent = "Verification code sent successfully.";
                    } else if (xhr.responseText === "error") {
                        resultMessage.textContent = "Error sending the verification code.";
                    }
                }
            };
            xhr.send('Verify=1&Email=' + email);
        });
    </script>
</body>
</html>
