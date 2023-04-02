<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров — Фудстер</title>
</head>
<body>
    <?php
        include("header.php");
        require_once("connect.php");
        $catQuery = "SELECT * FROM categories";
        $categories = mysqli_query($link, $catQuery);
    ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Каталог товаров</div>
            <div class="common-flex">
                <?php
                while($row = mysqli_fetch_array($categories)) {
                    $catLink = "location.href='products?cat=".$row["catID"]."'";
                    echo
                    "<div onclick=$catLink class='cat-item'>
                        <div class='cat-title'>".$row["catName"]."</div>
                        <div class='cat-image'><img src='".$row["catImg"]."'></div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>