<?php
session_start();
include('../Models/dbLogin.php');

function login()
{
    if (isset($_REQUEST['login'])) {
        $id = $_REQUEST['id'];
        $pass = $_REQUEST['pass'];

        if (!empty($id) && !empty($pass)) {
            $result = validateUser($id, $pass);

            if ($result->num_rows == 1) {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['id'] = $user["ID"];

                if ($user["Type"] == "Admin") {
                    header("location: ../Views/AdminHome.php");
                } elseif ($user["Type"] == "Faculty") {
                    header("location: ../FacultyHome.php");
                }
            } else {
                echo "<script>alert('Wrong password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Please fill in all the fields.');</script>";
        }
    }
}

login();
?>