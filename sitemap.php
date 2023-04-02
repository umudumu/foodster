<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта сайта — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Карта сайта</div>
            <div class="sitemap-flex">
                <li class="sitemap-item"><a class="sitemap-title" href="/">Главная страница</a></li>
                <ul class="sitemap-item"><a class="sitemap-title" href="account">Аккаунт</a>
                    <li><a href="orders">Заказы</a></li>
                    <li><a href="settings">Настройки</a></li>
                    <li><a href="sign">Вход</a></li>
                    <li><a href="reg">Регистрация</a></li>
                </ul>
                <ul class="sitemap-item"><a class="sitemap-title" href="catalog">Каталог товаров</a>
                <?php
                    $catQuery = "SELECT * FROM categories ORDER BY catName";
                    $categories = mysqli_query($link, $catQuery);
                    while($row = mysqli_fetch_array($categories)) {
                        echo "<li><a href='products?cat=".$row["catID"]."'>".$row["catName"]."</a></li>";
                    }
                ?>
                </ul>
                <li class="sitemap-item"><a class="sitemap-title" href="about">Контакты</a></li>
                <li class="sitemap-item"><a class="sitemap-title" href="basket">Корзина</a></li>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>