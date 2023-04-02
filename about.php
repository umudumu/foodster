<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты — Фудстер</title>
</head>
<body>
    <?php include("header.php"); ?>
    <div class="content">
        <div class="content-inner">
            <div class="title">Контакты</div>
            <div class="about-item">
                <div class="about-inner">
                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0 20px 0 0; font-size: 2vw'>info</span>
                    ООО «Фудстер»
                </div>
                <div class="about-inner">
                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0 20px 0 0; font-size: 2.5vw'>home</span>
                    354000, Краснодарский&nbsp;край, г.&nbsp;Сочи, ул.&nbsp;Московская, д.&nbsp;3, корп.&nbsp;3
                </div>
                <div class="about-inner">
                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0 20px 0 0; font-size: 2vw'>phone</span>
                    (862) 264-36-63
                </div>
            </div>
            <div class="social">
                <button class="common-btn" onclick="location.href='mailto:hello@foodster.ru'">
                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0 5px 0 0; font-size: inherit'>email</span>
                    Связаться по электронной почте
                </button>
                <button class="common-btn" style='background-color: lightblue' onclick="location.href='#'">
                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0 5px 0 0; font-size: inherit'>forum</span>
                    Написать в Telegram
                </button>
                <button class="common-btn" style='background-color: lightgreen' onclick="location.href='#'">
                    <span class='material-symbols-outlined' style='vertical-align: middle; padding: 0 5px 0 0; font-size: inherit'>forum</span>
                    Написать в WhatsApp
                </button>
            </div>
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ae5783caecf66d9184822c9d8fc4845149a377baa506eaf07388edbfc3e6999fe&amp;source=constructor" width="100%" height="300" frameborder="0"></iframe>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>