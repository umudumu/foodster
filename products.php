<?php
    require_once("connect.php");
    $catQtyQuery = "SELECT COUNT(*) AS count FROM categories";
    $catQty = mysqli_fetch_array(mysqli_query($link, $catQtyQuery));

    if(empty($_GET["cat"]) or $catQty["count"] < $_GET["cat"] or $_GET["cat"] < 0) {
        header("Location: /catalog");
        exit();
    } else { $catID = $_GET["cat"]; }

    # Получение названия категории для заголовков
    $catNameQuery = "SELECT catName FROM categories WHERE catID = ".$catID;
    if($row = mysqli_fetch_array(mysqli_query($link, $catNameQuery))) { $catName = $row["catName"]; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>$catName — Фудстер</title>" ?>
</head>
<body>
    <?php include("header.php"); ?>
    <div class="content">
        <div class="content-inner">
            <div class='title'><?php echo $catName ?></div>
            <div class="common-flex">
                <?php
                    # Создание карточек товаров
                    $productsQuery = "SELECT * FROM products WHERE catID = ".$catID;
                    $products = mysqli_query($link, $productsQuery);
                    while($row = mysqli_fetch_array($products)) {

                        # Ссылки на 'basketaction'
                        $create = "location.href='basketaction?type=1&cat=".$catID."&prod=".$row["prodID"]."'";
                        $add = "location.href='basketaction?type=2&cat=".$catID."&prod=".$row["prodID"]."'";
                        $minus = "location.href='basketaction?type=3&cat=".$catID."&prod=".$row["prodID"]."'";
                        $plus = "location.href='basketaction?type=4&cat=".$catID."&prod=".$row["prodID"]."'";

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
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>