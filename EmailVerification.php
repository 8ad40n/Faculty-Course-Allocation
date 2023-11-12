<?php session_start(); ?>
<?php

include("dbConnect.php");
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["register"])) {
    $email = $_POST["email"];

    $check_query = mysqli_query($connect, "SELECT * FROM faculty where Email = '$email'");
    $rowCount = mysqli_num_rows($check_query);

    if (!empty($email)) {
        if ($rowCount > 0) {
            ?>
            <script>
                alert("User with email already exists!");
            </script>
            <?php
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $result = mysqli_query($connect, "INSERT INTO login (email, password, status) VALUES ('$email', '$password_hash', 0)");
            if ($result) {

                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;


                
                $mail = new PHPMailer(true);

                // Configure the SMTP settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Username = 'your_email@gmail.com'; // Replace with your Gmail email
                $mail->Password = 'your_password'; // Replace with your Gmail password

                // Sender and recipient
                $mail->setFrom('your_email@gmail.com', 'OTP Verification');
                $mail->addAddress($_POST["email"]);

                $mail->isHTML(true);
                $mail->Subject = "Your verify code";
                $mail->Body = "<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>";

                if (!$mail->send()) {
                    ?>
                    <script>
                        alert("<?php echo "Failed, Invalid Email " ?>");
                    </script>
                    <?php
                } else {
                    ?>
                    <script>
                        alert("<?php echo "Successfully, OTP sent to " . $email ?>");
                    </script>
                    <?php
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Register Form</title>
</head>
<body>
    <form action="post" method="POST"> <!-- Fixed the form method -->
        Email: <input type="email" name="email">
        <input type="submit" value="Send Code" name="register">
    </form>
</body>
</html>
