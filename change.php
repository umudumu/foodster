<?php
    header("Location: /");
    
    require_once("connect.php");
    $action = $_POST["type"];

    if($action == "personal") {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $login = $_POST["login"];
        $address = $_POST["address"];

        if(empty($name) or empty($surname) or empty($login) or empty($address)) {
            header("Location: /settings?status=2");
        } else {
            $query = "UPDATE users SET userName = '".$name."', userSurn = '".$surname."', userMail = '".$login."', userAddr = '".$address."' WHERE userID = ".$_SESSION["userID"];
            mysqli_query($link, $query);
            header("Location: /settings?status=1");
        }
    }

    if($action == "password") {
        $currentpass = $_POST["currentpass"];
        $newpass = $_POST["newpass"];
        $passcheck = $_POST["passcheck"];

        $query = "SELECT userPass FROM users WHERE userID = ".$_SESSION["userID"];
        if($row = mysqli_fetch_array(mysqli_query($link, $query))) {
            if($row["userPass"] == $currentpass) {
                if($newpass == $passcheck) {
                    $query = "UPDATE users SET userPass = '".$newpass."' WHERE userID = ".$_SESSION["userID"];
                    mysqli_query($link, $query);
                    header("Location: /settings?status=3");
                } else {
                    header("Location: /settings?status=4");
                }
            } else {
                header("Location: /settings?status=5");
            }
        }
    }