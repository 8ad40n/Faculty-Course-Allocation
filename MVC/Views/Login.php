<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="CSS/loginDesign.css">
</head>

<body>
    <form method="post" action="../Controllers/LoginController.php">
        <fieldset>
            <h1>LOGIN</h1>
            <label for="id">ID:</label><br>
            <input type="text" name="id" placeholder="User Name"><br><br>
            <label for="password">Password:</label>
            <br><input type="password" name="pass" id="pass" placeholder="Password"><br>
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <small><b>Show Password</b></small><br><br>
            <button name="login"><b>Login</b></button><br> <br>
            <a href="../EmailVerification.php">Forgot Password?</a>
            <br> <br>
        </fieldset>
    </form>

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
</body>

</html>