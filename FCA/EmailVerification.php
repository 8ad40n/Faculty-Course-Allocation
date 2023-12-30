<?php
include("dbConnect.php");
include('smtp/PHPMailerAutoload.php');
session_start(); 

if(isset($_POST['send']))
{
    $otp=rand(100000,999999);
    $receiverEmail=$_POST['email'];
    $subject="Email Verification";
    $emailbody="Your 6 Digit OTP Code: ";

    $_SESSION['otp'] = $otp;

    $sql= "select FacultyID from faculty where Email = '$receiverEmail' ";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result);

    if(mysqli_num_rows($result)== 1)
    {
        $_SESSION["facultyid"] = $row["FacultyID"];
        smtp_mailer($receiverEmail,$subject,$emailbody.$otp);
    }
    else
    {
        echo "<script>alert('Invalid Email! Please, Try Again.')</script>";
    }
   
}


function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "restaurentmanagement@gmail.com"; //write sender email address
	$mail->Password = "gqebtkdusbtscblo"; //write app password of sender email
	$mail->SetFrom("restaurentmanagement@gmail.com"); //write sender email address
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
        header('Location: EnterVerificationCode.php');
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>OTP Send</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <br><br><center><h1>Email Validation:</h1></center><br><br>
        <form method="POST"> 
        Email: <br><input type="email" class="form-control" name="email">
        <button name="send" class="btn btn-primary">Send OTP Code</button>
        </form>
    </div>
    
</body>
</html>
