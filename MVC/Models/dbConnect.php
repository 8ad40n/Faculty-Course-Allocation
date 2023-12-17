<?php

function getConnection()
{
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";
    $conn = new mysqli($server, $username, $password, $dbname);
    return $conn;
}
?>