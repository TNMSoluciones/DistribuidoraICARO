<div id="zonaIzquierda">
        <a href="index.php"><img src="img/logoconfondochico.png" alt="Logo de empresa"></a>
</div>
<style type="text/css">
    #zonaIzquierda
    {
        background-color: white;
        width: 33%;
        height: 100vh;
        float: left;
    }
    #zonaIzquierda img, #zonaIzquierda a
    {
        float: left;
        width: 20vw;
        height: 11.25vw;
        margin: calc(50vh - 5.625vw) 0 0 6.5vw;
    }
    #zonaIzquierda img{margin: 0;}

    /* Header movil */

    @media (max-width: 875px)
    {
        #zonaIzquierda{
            width: 100vw;
            height: 50.81vw;
            border-right: none;
            border-bottom: 1px solid black;
            box-sizing: border-box;
        }
        #zonaIzquierda a, #zonaIzquierda img{
            width: 100%;    
            height: 50.81vw;
            margin: 0;
            display:block;
            margin-left:auto;
            margin-right:auto;
        }
    }
</style>