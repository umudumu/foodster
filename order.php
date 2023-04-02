<?php
    require_once("connect.php");

    $basketQuery = "SELECT COUNT(*) AS count FROM baskets WHERE userID = ".$_SESSION["userID"];
    $basketExists = mysqli_query($link, $basketQuery);
    if($row = mysqli_fetch_array($basketExists)) { 
        if($row["count"]) { $basketExists = true; }
            else { $basketExists = false; }
    }

    if(empty($_SESSION["userID"]) or !isset($_GET["basket"]) or !$basketExists) {
        header("Location: /");
        exit();
    }

    $baskID = $_GET["basket"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("funcs.php");
        $sum = 0;

        $addressQuery = "SELECT userAddr FROM users WHERE userID = ".$_SESSION["userID"];
        if($row = mysqli_fetch_array(mysqli_query($link, $addressQuery))) { $address = $row["userAddr"]; }
            else { $address = null; }

        $prodQtyQuery = "SELECT COUNT(*) AS count FROM basketsinfo WHERE baskID = '".$baskID."'";
        if($row = mysqli_fetch_array(mysqli_query($link, $prodQtyQuery))) { $prodQty = $row["count"]; }

        $sumQuery = "SELECT b.userID, bi.prodID, bi.prodQty, p.prodPrice FROM baskets AS b, basketsinfo AS bi 
                    JOIN products AS p ON bi.prodID = p.prodID WHERE b.userID = ".$_SESSION["userID"];
        $prodList = mysqli_query($link, $sumQuery);
        while($row = mysqli_fetch_array($prodList)) {
            $sum += $row["prodQty"] * $row["prodPrice"];
        }
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Оформление заказа</div>
            <form action="orderaction" method="get">
                <div class="order-item">
                    <div class="order-title">Адрес доставки</div>
                    <?php
                        echo
                        "<input type='hidden' name='basket' value='".$baskID."'>
                        <input class='field' size='80' type='text' placeholder='Введите адрес' value='".$address."' required>";
                    ?>
                </div>
                <div class="order-item">
                    <div class="order-title">
                        <?php 
                            if($sum < 500) { $total = $sum + 99; }
                                else { $total = $sum; }
                            echo "$prodQty ".caseform($prodQty, "товар", "товара", "товаров").
                                 " <span class='material-symbols-outlined' style='vertical-align: middle; padding-bottom: 4px; font-size: inherit'>east</span> ".
                                 number_format($sum, 2, ",", "")." ₽";
                        ?>
                    </div>
                    <div class="delivery-status">
                        <?php
                            echo "<span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 5px 2px 0px; font-size: inherit'>shopping_cart_checkout</span>";
                            if($sum >= 500) { echo "Бесплатная доставка"; }
                                else { echo "99 ₽ за доставку"; }
                        ?>
                    </div>
                    <button type="submit" class="order">
                        <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0px 1px 2px 0px; font-size: inherit'>credit_card</span>
                        Оплатить<?php echo "&nbsp;&nbsp;|&nbsp;&nbsp;".number_format($total, 2, ",", "")." ₽"; ?>
                    </button>
                </div>
            </form>
            <button class="common-btn" onclick="location.href='basket'">Вернуться в корзину</button>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>