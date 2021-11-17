<footer>
    <img id="logoicaro" src="img/logoconfondochico.png" alt="">
    <div id="divlink">
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="contactanos.php">Contáctanos</a>
        <?=isset($_SESSION['user'])?'<a href="perfilUsuario.php">Perfil</a>':''?>
    </div>
    <div id="contacto">
        <img src="svg/logoinstagram.png" alt="">
        <img src="svg/logotwitter.png" alt="">
        <img src="svg/logofacebook.png" alt="">
    </div>
        <h2 id="hechopor">Powered&nbsp;&nbsp;by&nbsp;&nbsp;TNMSoluciones</h2>
    </footer>
<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
footer{
    background-color: #fff;
    width: 100%;
    float: left;
    clear: both;
}
#logoicaro{
    width: 15vw;
    margin: 0 0 2vw 42.5vw;
    display: block;
}
#contacto{
    display: inline-flex;
    width: 18%;
    margin-left: 41%;
    justify-content: space-around;
}
#contacto img{
    margin-top: 2vw;
    width: 3vw;
}
#divlink{
    display: inline-flex;
    width: 40%;
    margin: 0 30%;
    justify-content: space-around;
}
#divlink a{
    text-decoration: none;
    color: black;
}
#divlink a:link, #divlink a:visited{
    color: black;
}
#hechopor{
    font-family: 'Bebas Neue', cursive;
    letter-spacing: 0.8vw;
    margin-top: 5vw;
    color: rgb(155, 154, 154);
    text-align: center;
    font-size: 1.2vw;
}
/* Footer movil */

@media (max-width: 1024px){
    #logoicaro{
        width: 70%;
        margin-left: 15%;
    }
    #contacto img{
        margin-left: 3vw;
        width: 12vw;
    }
    #divlink a{
        margin-left: 5vw;
    }
    #hechopor{
        font-size: 4vw;
        font-weight: 500;
    }
}
</style>