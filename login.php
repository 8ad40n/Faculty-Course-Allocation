<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['login'])) {
    $id = $_POST['id'];
    $pass = $_POST['pass'];
    $sql = "select * from userinfo where ID='$id' and Password='$pass'";
    $res = mysqli_query($conn, $sql);
    if (!empty($id) && !empty($pass)) {
        if ($res->num_rows == 1) {
            $new = mysqli_fetch_assoc($res);
            $user = $new["Type"];
            $_SESSION['id'] = $new["ID"];

            if ($user == "Admin") {
                header("location: AdminHome.php");
            } elseif ($user == "Faculty") {
                header("location: FacultyHome.php");
            }
        } else {
            echo "<script>alert('Wrong password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all the fields.');</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <!-- <link rel="stylesheet" href="CSS/loginDesign.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="CSS/style.css">


</head>

<body>
    <div class="container login-container">
        <div class="row">
            <div class="col-md-6 login-form-1">
                <br><br><h3>LOGIN</h3>
                <form method="post">
                        <script>
                            function togglePassword() {
                                var passwordInput = document.getElementById("pass");
                                if (passwordInput.type == "password") {
                                    passwordInput.type = "text";
                                } else {
                                    passwordInput.type = "password";
                                }
                            }
                        </script>
                        <div class="form-group">
                            <input type="text" name="id" class="form-control" placeholder="Your ID">
                        </div><br>
                        <div class="form-group">
                            <input type="password" name="pass" class="form-control" placeholder="Your Password" id="pass">
                        </div>
                        <br><div style="text-align: left;">
                            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                            <small>Show Password</small><br><br>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" class="btnSubmit" value="Login" />
                        </div>
                        <br><a href="EmailVerification.php">Forgot Password?</a>
                        <br> <br>
                </form>


            </div>
        </div>
    </div>

</body>

</html>