<!-- <?php 
session_start();
    if (isset($_SESSION["email"])) {
        ?><script>alert("Si")</script><?php
    }else{
        ?><script>alert("No")</script><?php
    }

?> -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
    <title>Distribuidora ICARO</title>
</head>
<body>

    <?php include 'Assets/header.php';?>

    <div id="slidervista">
        <figure id="slidercontenido">
            <img src="imgSlider/1.jpg">
            <img src="imgSlider/2.jpg">
            <img src="imgSlider/3.jpg">
            <img src="imgSlider/4.jpg">
            <img src="imgSlider/5.jpg">
            <img src="imgSlider/6.jpg">
            <img src="imgSlider/7.jpg">
            <img src="imgSlider/8.jpg">
            <img src="imgSlider/1.jpg">
            <img src="imgSlider/2.jpg">
            <img src="imgSlider/3.jpg">
        </figure>
    </div>

    <div id="section1">
        <img src="http://localhost/codigo/img/3img.jpg"><img src="http://localhost/codigo/img/3img.jpg"><img src="http://localhost/codigo/img/3img.jpg">
    </div>
    
    <div id="section2">
        <h1>Articulos</h1>
        <div class="articulos">

        </div>
        <div class="articulos">
        
        </div>
        <div class="articulos">

        </div>
    </div>

    <div id="section3">
        <h1>Articulos</h1>
        <div class="articulos2"></div>
        <div class="articulos2"></div>
        <div class="articulos2"></div>
        <div class="articulos2"></div>
        <div class="articulos2"></div>
        <div class="articulos2"></div>
    </div>
    <?php include 'Assets/footer.php';?>
</body>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_movil.css">
</html>