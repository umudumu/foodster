<?php

$host = "localhost:3306";
$user = "root";
$pass = "";
$database = "foodster";

$link = mysqli_connect($host, $user, $pass, $database);
mysqli_query($link, "SET NAMES UTF8");