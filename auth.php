<?php
    header("Location: /");
    
    require_once("connect.php");
    $action = $_POST["type"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $passcheck = $_POST["passcheck"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];

    if($action == "reg") {
        $query = "SELECT * FROM users WHERE userMail = '".$login."'";
        $result = mysqli_query($link, $query);
        if(empty($name) or empty($surname) or empty($login) or empty($password) or empty($passcheck)) {
            header("Location: /reg?fail=2");
        } else if($password != $passcheck) {
            header("Location: /reg?fail=3");
        } else if($row = mysqli_fetch_array($result)) {
            if($row["userMail"] == $login) { header("Location: /reg?fail=4"); }
        } else {
            $regQuery = "INSERT INTO users (userName, userSurn, userMail, userPass) VALUES
                         ('".$name."', '".$surname."', '".$login."', '".$password."')";
            $regResult = mysqli_query($link, $regQuery);
            $loginQuery = "SELECT * FROM users WHERE userMail = '".$login."'";
            $loginResult = mysqli_query($link, $loginQuery);
            if($row = mysqli_fetch_array($loginResult)) {
                $_SESSION["userID"] = $row["userID"];
            }
            header("Location: /account");
        }
    }

    if($action == "login") {
        $query = "SELECT * FROM users WHERE userMail = '".$login."' AND userPass = '".$password."'";
        $result = mysqli_query($link, $query);
        if($row = mysqli_fetch_array($result)) {
            $_SESSION["userID"] = $row["userID"];
            header("Location: /");
            exit();
        } else {
            header("Location: /sign?fail=1");
        }
    }

    if($action == "logout") {
        session_destroy();
        header("Location: /");
    }