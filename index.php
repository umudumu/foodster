<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фудстер — заказ продуктов в Сочи</title>
    <link rel="icon" href="favicon.svg">  
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");
        $promoQuery = "SELECT * FROM products WHERE promo = 1";
        $promo = mysqli_query($link, $promoQuery);
        $actionsQuery = "SELECT * FROM actions";
        $actions = mysqli_query($link, $actionsQuery);
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="welcome">
               <div class="welcome-text">
                    Привет, это <span style="font-weight:700">Фудстер</span> — онлайн-магазин с быстрой доставкой по&nbsp;центру Сочи. Привозим свежие продукты известных брендов и&nbsp;местных производителей.
                    <a href="catalog"><span class="material-symbols-outlined" style="vertical-align: middle; padding: 0px 1px 4px 0px; font-size: inherit">arrow_forward_ios</span>Перейти в каталог</a>
                    <img src="img/logo/welcome.png">
               </div>
            </div>
            <div class="title">Популярные товары</div>
            <div class="common-flex">
                <?php
                    # Создание карточек товаров
                    while($row = mysqli_fetch_array($promo)) {

                        # Ссылки на 'basketaction'
                        $create = "location.href='basketaction?type=1&cat=0&prod=".$row["prodID"]."'";
                        $add = "location.href='basketaction?type=2&cat=0&prod=".$row["prodID"]."'";
                        $minus = "location.href='basketaction?type=3&cat=0&prod=".$row["prodID"]."'";
                        $plus = "location.href='basketaction?type=4&cat=0&prod=".$row["prodID"]."'";

                        # Содержимое карточки до кнопок
                        echo 
                        "<div class='prod-item'>
                            <div class='prod-inner'>
                                <img src='".$row["prodImg"]."'>
                                <div class='prod-title'>".$row["prodName"]."</div>
                                <div class='info'>
                                    <div class='weight'>".$row["prodWt"]." г</div>
                                    <div class='price'>".number_format($row["prodPrice"], 2, ',', '')." ₽</div>
                                </div>";

                        # Алгоритм отображения кнопок
                                if(empty($_SESSION["userID"])) {
                                    # Если пользователь не авторизован, отключаем кнопки
                                    echo    "<button class='basket' disabled>
                                                <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 1px 2px 0px; font-size: inherit'>shopping_cart</span>
                                                Войдите, чтобы добавить
                                            </button>";
                                } else {
                                    # Проверка на существование корзины у пользователя
                                    $basketExistQuery = "SELECT * FROM baskets WHERE userID = ".$_SESSION["userID"];
                                    $basketExist = mysqli_query($link, $basketExistQuery);
                                    if($basket = mysqli_fetch_array($basketExist)) {
                                        # Если корзина существует, проверяем наличие в ней текущего товара из категории
                                        $productExistQuery = "SELECT * FROM baskets AS b, basketsinfo AS bi
                                                              WHERE b.userID = ".$_SESSION["userID"]." AND bi.prodID = ".$row["prodID"];
                                        $productExist = mysqli_query($link, $productExistQuery);
                                        if($product = mysqli_fetch_array($productExist)) {
                                            # Если текущий товар уже есть в корзине, показываем количество и +/-
                                            echo    "<div class='prod-buttons'>
                                                        <button class='plusminus' onclick=".$minus.">
                                                            <span class='material-symbols-outlined' style='vertical-align: middle; font-size: inherit'>remove</span>
                                                        </button>
                                                        <div class='prod-qty'>".$product["prodQty"]."</div>
                                                        <button class='plusminus' onclick=".$plus.">
                                                            <span class='material-symbols-outlined' style='vertical-align: middle; font-size: inherit'>add</span>
                                                        </button>
                                                    </div>";
                                        } else {
                                            # Если товара нет в корзине, показываем у товара стандартную кнопку добавления
                                            echo    "<button class='basket' onclick=".$add.">
                                                        <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 1px 2px 0px; font-size: inherit'>shopping_cart</span>
                                                        В корзину
                                                    </button>";
                                        }
                                    } else {
                                        # Если корзины не существует, показываем у всех товаров стандартную кнопку добавления
                                        echo    "<button class='basket' onclick=".$create.">
                                                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 1px 2px 0px; font-size: inherit'>shopping_cart</span>
                                                    В корзину
                                                </button>";
                                    }
                                }
                        
                        # Конец карточки
                        echo
                            "</div>
                        </div>";
                    }
                ?>
            </div>
            <div class="title">Скидки и акции</div>
            <div class="common-flex">
                <?php 
                    while($row = mysqli_fetch_array($actions)) {
                        echo
                        "<div class='action-item' style='background-color: ".$row["actColor"]."'>
                            <div class='action-inner'>
                                <div class='action-info'>
                                    <div class='action-title'>".$row["actTitle"]."</div>
                                    <div class='action-period'>".$row["actPeriod"]."</div>
                                </div>
                                <img src='".$row["actImg"]."'>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>