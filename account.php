<?php
    if(empty($_SESSION["userID"])) {
        header("Location: /sign");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");    
    ?>
    <div class="content">
        <div class="content-inner">
            <?php 
                $nameQuery = "SELECT userName FROM users WHERE userID = ".$_SESSION["userID"];
                if($row = mysqli_fetch_array(mysqli_query($link, $nameQuery))) {
                    echo "<div class='title'>Привет, ".$row["userName"]."!</div>"; 
                }
            ?>
            <form class="account-sections" action="auth" method="post">
                <div class="account-item" onclick="location.href='orders'">
                    <span class='material-symbols-outlined'>shopping_basket</span>Заказы
                </div>
                <div class="account-item" onclick="location.href='settings'">
                    <span class='material-symbols-outlined'>settings</span>Настройки
                </div>
                <button class="account-item" type="submit">
                    <span class='material-symbols-outlined'>logout</span>Выйти
                </button>
                <input type="hidden" value="logout" name="type">
            </form>
        </div>
    </div>
    <?php include("footer.php") ?>
</body>
</html>