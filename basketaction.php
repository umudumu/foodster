<?php
    require_once("connect.php");
    $type = $_GET["type"];
    $catID = $_GET["cat"];
    $prodID = $_GET["prod"];

    # Если корзины не существует, создаём её и добавляем выбранный товар
    if($type == 1) {
        $createBasketQuery = "INSERT INTO baskets (userID) VALUES (".$_SESSION["userID"].")";
        $createBasket = mysqli_query($link, $createBasketQuery);
        $basketIDQuery = "SELECT * FROM baskets WHERE userID = ".$_SESSION["userID"];
        if($row = mysqli_fetch_array(mysqli_query($link, $basketIDQuery))) {
            $createProductQuery = "INSERT INTO basketsinfo VALUES (".$row["baskID"].", ".$prodID.", 1)";
            $createProduct = mysqli_query($link, $createProductQuery);
        }
    }

    # Узнаём ID корзины по ID пользователя
    $basketIDQuery = "SELECT baskID FROM baskets WHERE userID = ".$_SESSION["userID"];
    if($row = mysqli_fetch_array(mysqli_query($link, $basketIDQuery))) {

        # Если корзина существует, но без выбранного товара, добавляем запись о нём в корзину
        if($type == 2) {
            $createProductQuery = "INSERT INTO basketsinfo VALUES (".$row["baskID"].", ".$prodID.", 1)";
            $createProduct = mysqli_query($link, $createProductQuery);
        }
    
        # Если корзина существует и выбранный товар уже есть в ней:
        # Уменьшение количества или автоматическое удаление
        if($type == 3) {
            $productQuery = "SELECT prodID, prodQty FROM basketsinfo WHERE baskID = ".$row["baskID"]." AND prodID = ".$prodID;
            $product = mysqli_fetch_array(mysqli_query($link, $productQuery));
            if($product) {
                if($product["prodQty"] > 1) {
                    $minusQuery = "UPDATE basketsinfo SET prodQty = prodQty - 1 WHERE prodID = ".$prodID;
                } else {
                    $minusQuery = "DELETE FROM basketsinfo WHERE prodID = ".$prodID;
                }
                mysqli_query($link, $minusQuery);
            }
        }

        # Увеличение количества
        if($type == 4) {
            $productQuery = "SELECT prodID, prodQty FROM basketsinfo WHERE baskID = ".$row["baskID"]." AND prodID = ".$prodID;
            $product = mysqli_fetch_array(mysqli_query($link, $productQuery));
            if($product) {
                $plusQuery = "UPDATE basketsinfo SET prodQty = prodQty + 1 WHERE prodID = ".$prodID;
            }
            mysqli_query($link, $plusQuery);
        }

        # Очистка корзины целиком
        if($type == 5) {
            $basketCleanQuery = "DELETE FROM basketsinfo WHERE baskID = ".$row["baskID"];
            $basketRemoveQuery = "DELETE FROM baskets WHERE baskID = ".$row["baskID"];
            mysqli_query($link, $basketCleanQuery);
            mysqli_query($link, $basketRemoveQuery);
        }

    }

    # Перенаправление по завершении
    if($catID == 0) { header("Location: /"); }
        else { header("Location: /products?cat=".$catID); }
    if($catID == "basket") { header("Location: /basket"); }