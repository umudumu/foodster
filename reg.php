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
    <title>Регистрация — Фудстер</title>
</head>
<body>
    <?php include("header.php"); ?>
    <div class="content">
        <div class="content-inner">
            <div class="content-center">
                <div class="userform">
                    <div class="title-center">Регистрация</div>
                    <form action="auth" method="post">
                        <input class="field" type="text" name="name" placeholder="Имя">
                        <input class="field" type="text" name="surname" placeholder="Фамилия">
                        <input class="field" type="email" name="login" placeholder="Электронная почта">
                        <input class="field" type="password" name="password" placeholder="Пароль" autocomplete="new-password">
                        <input class="field" type="password" name="passcheck" placeholder="Повторите пароль">
                        <?php
                            switch($fail) {
                                case 2:
                                    echo "<span class='fail'>Заполнены не все поля</span>";
                                    break;
                                case 3:
                                    echo "<span class='fail'>Пароли не совпадают</span>";
                                    break;
                                case 4:
                                    echo "<span class='fail'>Пользователь с такой электронной почтой уже существует</span>";
                                    break;
                            }
                        ?>
                        <input type="hidden" name="type" value="reg">
                        <input class="auth" type="submit" value="Зарегистрироваться">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>