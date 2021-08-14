<?php 
    session_start();
    if (isset($_SESSION["email"])) {}
?> 
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
        <img src="img/3img.jpg"><img src="img/3img.jpg"><img src="img/3img.jpg">
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
    <link rel="stylesheet" href="Style/indexStyle.css">
    <link rel="stylesheet" href="Style/indexStyleMovil.css">
</html>