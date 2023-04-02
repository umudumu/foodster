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
    <title>Корзина — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Корзина</div>
            <div class="basket-flex">
                <?php
                    $baskIDQuery = "SELECT * FROM baskets WHERE userID = ".$_SESSION["userID"];
                    if($row = mysqli_fetch_array(mysqli_query($link, $baskIDQuery))) {
                        $order = "location.href='order?basket=".$row["baskID"]."'";
                    }
                    $basketQtyQuery = "SELECT COUNT(*) AS count FROM baskets, basketsinfo WHERE userID = ".$_SESSION["userID"];
                    $basketQty = mysqli_fetch_array(mysqli_query($link, $basketQtyQuery));
                    if($basketQty["count"]) {
                        $basketQuery = "SELECT b.userID, p.prodID, prodName, prodQty, prodPrice, prodImg FROM baskets AS b
                                        JOIN basketsinfo AS bi ON b.baskID = bi.baskID
                                        JOIN products AS p ON bi.prodID = p.prodID
                                        WHERE b.userID = ".$_SESSION["userID"];
                        $basket = mysqli_query($link, $basketQuery);
                        $sum = 0;
                        while($row = mysqli_fetch_array($basket)) {
                            $minus = "location.href='basketaction?type=3&cat=basket&prod=".$row["prodID"]."'";
                            $plus = "location.href='basketaction?type=4&cat=basket&prod=".$row["prodID"]."'";
                            $clean = "location.href='basketaction?type=5&cat=basket&prod=0'";
                            echo
                            "<div class='basket-item'>
                                <div class='basket-inner'>
                                    <img src='".$row["prodImg"]."'>
                                    <div class='title-and-price'>
                                        <div class='prod-title'>".$row["prodName"]."</div>
                                        <div class='price'>".number_format($row["prodPrice"], 2, ",", "")."&nbsp;₽ / шт.</div>
                                    </div>
                                    <div class='qty-and-total'>
                                        <div class='prod-buttons'>
                                            <button class='plusminus' onclick=".$minus.">
                                                <span class='material-symbols-outlined' style='vertical-align: middle; font-size: inherit'>remove</span>
                                            </button>
                                            <div class='prod-qty'>".$row["prodQty"]."</div>
                                            <button class='plusminus' onclick=".$plus.">
                                                <span class='material-symbols-outlined' style='vertical-align: middle; font-size: inherit'>add</span>
                                            </button>
                                        </div>
                                        <div class='total'>".number_format($row["prodQty"] * $row["prodPrice"], 2, ",", "")."&nbsp;₽</div>
                                    </div>
                                </div>
                            </div>";
                            $sum += $row["prodQty"] * $row["prodPrice"];
                        }
                        echo
                        "<div class='basket-summary'>
                            <button class='common-btn' onclick=".$clean.">Очистить корзину</button>
                            <div class='basket-total'>
                                <div>".number_format($sum, 2, ",", "")."&nbsp;₽</div>
                                <button class='order' onclick=".$order.">
                                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 5px 2px 0px; font-size: inherit'>shopping_basket</span>
                                    Оформить заказ
                                </button>
                            </div>
                        </div>";
                    } else {
                        echo    
                        "<div class='empty'>
                            <span style='font-size: 4em; margin: 2vw 0'>😥</span> В корзине пока нет товаров
                            <a href='catalog'><span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 1px 4px 0px; font-size: inherit'>arrow_forward_ios</span>Перейти в каталог</a>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>