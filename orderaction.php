<?php
    require_once("connect.php");
    $baskID = $_GET["basket"];
    if($baskID == 0) { 
        header("Location: /");
        exit();
    }
    $sum = 0;

    # Получение суммы заказа для определения стоимости доставки
    $sumQuery = "SELECT b.userID, bi.prodID, bi.prodQty, p.prodPrice FROM baskets AS b, basketsinfo AS bi 
                JOIN products AS p ON bi.prodID = p.prodID WHERE b.userID = ".$_SESSION["userID"];
    $productList = mysqli_query($link, $sumQuery);
    while($row = mysqli_fetch_array($productList)) {
        $sum += $row["prodQty"] * $row["prodPrice"];
    }

    if($sum >= 500) { $delivery = false; }
        else { $delivery = true; }

    # Создание заказа в БД
    $createOrderQuery = "INSERT INTO orders (userID, orderDate, orderDlv) VALUES
                        ('".$_SESSION["userID"]."', '".time()."', '".$delivery."')";
    mysqli_query($link, $createOrderQuery);

    # Получение ID заказа для заполнения его табличной части
    $orderIDQuery = "SELECT * FROM orders WHERE userID = ".$_SESSION["userID"]." ORDER BY orderDate DESC LIMIT 1";
    if($row = mysqli_fetch_array(mysqli_query($link, $orderIDQuery))) { $orderID = $row["orderID"]; }

    # Получение списка товаров из корзины и вставка в табличную часть заказа
    $productQuery = "SELECT * FROM basketsinfo WHERE baskID = ".$baskID;
    $productList = mysqli_query($link, $productQuery);
    while($row = mysqli_fetch_array($productList)) {
        $productAddQuery =  "INSERT INTO ordersinfo (orderID, prodID, prodQty) VALUES
                            ('".$orderID."', '".$row["prodID"]."', '".$row["prodQty"]."')";
        mysqli_query($link, $productAddQuery);
    }

    # Очистка корзины
    $basketCleanQuery = "DELETE FROM basketsinfo WHERE baskID = ".$baskID;
    $basketRemoveQuery = "DELETE FROM baskets WHERE baskID = ".$baskID;
    mysqli_query($link, $basketCleanQuery);
    mysqli_query($link, $basketRemoveQuery);

    # Перенаправление по завершении
    header("Location: /success");