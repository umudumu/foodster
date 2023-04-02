<?php
    if(empty($_SESSION["userID"])) {
        header("Location: /sign");
        exit();
    }

    if(isset($_GET["status"])) { $status = $_GET["status"]; }
        else { $status = false; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");
        $userQuery = "SELECT * FROM users WHERE userID = ".$_SESSION["userID"];
        $user = mysqli_query($link, $userQuery);
        if($row = mysqli_fetch_array($user)) {
            $userName = $row["userName"];
            $userSurn = $row["userSurn"];
            $userMail = $row["userMail"];
            $userAddr = $row["userAddr"];
            $userPass = $row["userPass"];
        }
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Настройки</div>
            <div class="content-center">
                <div class="userform">
                    <div class="title-center">Личные данные</div>
                    <form action="change" method="post">
                        <input class="field" type="text" name="name" placeholder="Имя" value="<?php echo $userName; ?>">
                        <input class="field" type="text" name="surname" placeholder="Фамилия" value="<?php echo $userSurn; ?>">
                        <input class="field" type="email" name="login" placeholder="Электронная почта" value="<?php echo $userMail; ?>">
                        <input class="field" type="text" name="address" placeholder="Адрес доставки" value="<?php echo $userAddr; ?>">
                        <?php
                            switch($status) {
                                case 1:
                                    echo "<span class='done'>Данные успешно обновлены</span>";
                                    break;
                                case 2:
                                    echo "<span class='fail'>Заполнены не все поля</span>";
                                    break;
                            }
                        ?>
                        <input type="hidden" name="type" value="personal">
                        <input class="auth" type="submit" value="Изменить данные">
                    </form>
                </div>
                <div class="userform">
                    <div class="title-center">Пароль</div>
                    <form action="change" method="post">
                        <input class="field" type="password" name="currentpass" placeholder="Текущий пароль" autocomplete="current-password">
                        <input class="field" type="password" name="newpass" placeholder="Новый пароль">
                        <input class="field" type="password" name="passcheck" placeholder="Повторите пароль">
                        <?php
                            switch($status) {
                                case 3:
                                    echo "<span class='done'>Пароль успешно обновлён</span>";
                                    break;
                                case 4:
                                    echo "<span class='fail'>Пароли не совпадают</span>";
                                    break;
                                case 5:
                                    echo "<span class='fail'>Неверный пароль</span>";
                                    break;    
                            }
                        ?>
                        <input type="hidden" name="type" value="password">
                        <input class="auth" type="submit" value="Изменить пароль">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php") ?>
</body>
</html>