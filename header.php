<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,500,1,0"/>
</head>
<body>
    <header>
        <div class="header-inner">
            <div class="header-logo">
                <a href="/"><img src="img/logo/header.png"></a>
            </div>
            <div class="header-banner">
                <span>
                    <span class="material-symbols-outlined" style="vertical-align: middle; padding-right: 5px; font-size: inherit">favorite</span> 
                    Бесплатная доставка при заказе от&nbsp;500&nbsp;₽
                </span>
            </div>
            <nav>
                <div onclick="location.href='catalog'">Каталог</div>
                <div onclick="location.href='basket'">Корзина</div>
                <div onclick="location.href='about'">Контакты</div>
                <?php
                    $sign = "location.href='sign'";
                    $account = "location.href='account'";
                    if(empty($_SESSION["userID"])) { echo "<div onclick=$sign>Вход</div>"; }
                        else { echo "<div onclick=$account>Аккаунт</div>"; }
                ?>
            </nav>
        </div>
    </header>
</body>
</html>