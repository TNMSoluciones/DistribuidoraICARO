<div id="zonaIzquierda">
        <a href="/codigo"><img src="http://localhost/codigo/img/logoconfondochico.png" alt="Logo de empresa"></a>
</div>
<style type="text/css">
#zonaIzquierda
{
    width: 33%;
    height: 100vh;
    float: left;
    border-right: 1px solid black;
    box-sizing: border-box;
}
#zonaIzquierda img
{
    width: 20vw;
    height: 11.25vw;
    margin: calc(50vh - 5.625vw) 0 0 6.5vw;
}

/* Header movil */

@media (max-width: 875px)
{
    #zonaIzquierda{
        width: 100%;
        height: 18vh;
        border-right: none;
        border-bottom: 1px solid black;
        box-sizing: border-box;
    }
    #zonaIzquierda img{
        width: fit-content;
        height: 16vh;
        margin: 1vh 0;
        display:block;
        margin-left:auto;
        margin-right:auto;
    }
}

</style>