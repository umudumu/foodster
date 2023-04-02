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
    <title>Ваши заказы — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");
        require_once("funcs.php");
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Ваши заказы</div>
            <?php
                # Проверка наличия заказов
                $months = array(1 => "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
                $ordersQtyQuery = "SELECT COUNT(*) AS count FROM orders WHERE userID = ".$_SESSION["userID"];
                $ordersQty = mysqli_fetch_array(mysqli_query($link, $ordersQtyQuery));

                if($ordersQty["count"]) {

                    # Вывод карточки заказа
                    $ordersQuery = "SELECT * FROM orders WHERE userID = ".$_SESSION["userID"]." ORDER BY orderDate DESC";
                    $orders = mysqli_query($link, $ordersQuery);
                    while($row = mysqli_fetch_array($orders)) {
                        
                        $sum = 0; $qty = 0;
                        $orderID = $row["orderID"];
                        $orderDate = $row["orderDate"];
                        $orderDlv = $row["orderDlv"];
                        if($orderDlv) { $sum += 99; }

                        # Подсчёт суммы заказа и количества товаров
                        $orderListQuery =   "SELECT p.prodName, oi.prodQty, p.prodPrice, p.prodImg FROM orders AS o
                                            JOIN ordersinfo AS oi ON o.orderID = oi.orderID
                                            JOIN products AS p ON oi.prodID = p.prodID
                                            WHERE o.userID = ".$_SESSION["userID"]." AND o.orderID = ".$orderID;
                        $orderList = mysqli_query($link, $orderListQuery);
                        while($row = mysqli_fetch_array($orderList)) {
                            $sum += $row["prodQty"] * $row["prodPrice"];
                            $qty++;
                        }

                        # Вывод шапки заказа
                        echo 
                        "<div class='orders-item'>
                            <div class='orders-inner'>
                                <input type='checkbox' id='".$orderID."'>
                                <div class='orders-title-price'>Заказ №&nbsp;".$orderID." на ".number_format($sum, 2, ",", "")." ₽</div>
                                <div class='orders-date-qty'>".
                                    date("j ", $orderDate).$months[date("n", $orderDate)].date(" Y в H:i", $orderDate)." &bullet; ".$qty.caseform($qty, " товар", " товара", " товаров")."
                                </div>
                                <label style='cursor: pointer' for='".$orderID."'></label>
                                <div class='orders-info'>";        
                        
                        # Вывод списка товаров в заказе 
                        $orderList = mysqli_query($link, $orderListQuery);
                        while($row = mysqli_fetch_array($orderList)) {
                            echo 
                            "<div class='orders-info-item'>
                                <div class='orders-img-title'>
                                    <img src='".$row["prodImg"]."'>
                                    <div class='prod-title'>".$row['prodName']."</div>
                                </div>
                                <div class='orders-qty-price'>
                                    <div class='orders-date-qty'>".$row["prodQty"]."&nbsp;шт.</div>
                                    <div class='orders-title-price'>".number_format($row["prodQty"] * $row["prodPrice"], 2, ",", "")."&nbsp;₽</div>
                                </div>
                            </div>";
                        }

                        # Вывод информации о доставке
                        if($orderDlv) {
                            echo    "<div class='orders-info-item'>
                                        <div class='orders-img-title'>
                                            <span class='material-symbols-outlined' style='vertical-align: middle; margin: 0 1.5vw 0 0.5vw; font-size: 2vw'>shopping_cart_checkout</span>
                                            <div class='prod-title'>Услуга доставки</div>
                                        </div>
                                        <div class='orders-qty-price'>
                                            <div class='orders-title-price'>99&nbsp;₽</div>
                                        </div>
                                    </div>";
                        }

                        # Конец карточки
                        echo       
                                "</div>
                            </div>
                        </div>";
                    }

                } else {

                    echo
                    "<div class='empty'>
                        <span style='font-size: 4em; margin: 2vw 0'>😥</span> У вас пока нет заказов
                        <a href='catalog'><span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 1px 4px 0px; font-size: inherit'>arrow_forward_ios</span>Перейти в каталог</a>
                    </div>";

                }
            ?>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>