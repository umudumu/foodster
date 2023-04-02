<?php
    if(!empty($_SESSION["userID"])) { 
        header("Location: /account");
        exit();
    }
    
    if(isset($_GET["fail"])) { $fail = $_GET["fail"]; }
        else { $fail = false; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация — Фудстер</title>
</head>
<body>
    <?php include("header.php"); ?>
    <div class="content">
        <div class="content-inner">
            <div class="content-center">
                <div class="userform">
                    <div class="title-center">Авторизация</div>
                    <form action="auth" method="post">
                        <input class="field" type="email" name="login" placeholder="Электронная почта">
                        <input class="field" type="password" name="password" placeholder="Пароль">
                        <?php if($fail) { echo "<span class='fail'>Неверный логин или пароль</span>"; } ?>
                        <input type="hidden" name="type" value="login">
                        <input class="auth" type="submit" value="Войти">
                        <span class="reg-welcome">Впервые на сайте?</span>
                        <div class="auth" onclick="location.href='reg'">Создать аккаунт</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>