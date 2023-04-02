<?php
    if(empty($_SESSION["userID"])) {
        header("Location: /");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оплачен — Фудстер</title>
</head>
<body>
    <?php include("header.php"); ?>
        <div class="content">
            <div class="content-inner">
                <div class="warning">
                    <span style="margin: 3% 0; font-size: 5em;"><img src="img/logo/success.svg"></span>
                    <span>Заказ успешно оплачен!</span>
                </div>
            </div>
        </div>
    <?php include("footer.php"); ?>
</body>
</html>