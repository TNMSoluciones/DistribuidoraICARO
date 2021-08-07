<footer>
        <div>
            <h1>ejemplodecorreo@ejemplo.eje</h1>
        </div>
        <div>
            <h1>+598 34 394 931</h1>
        </div>
        <div>
            <h1>San José de Mayo</h1>
            <p>José Batlle y Ordoñez 783</p>
        </div>
</footer>
<style type="text/css">
footer
{
    width: 100%;
    height: 100px;
    float: left;
    margin-top: 60px;
    background-color: grey;
}
footer div
{
    display: inline-table;
    width: 20vw;
    height: 100px;
    text-align: center;
    font-family: 'Roboto Condensed', sans-serif;
    font-size: 1vw;
}
footer div:first-of-type{margin-left: 20vw}
footer div h1
{
    margin: 0;
    height: 1.6vw;
    margin-top: calc(50px - 0.8vw);
    font-size: 1.3vw;
    font-weight: 700;
}
footer div p{margin: 0;}

/* Header movil */

@media (max-width: 875px){
    footer div
    {
        width: 33%;
        float: left;
    }
    footer div:first-of-type{margin: 0}
    footer div h1{
        height: 5vw;
        font-size: 2.5vw;
    }
    footer div p{
        font-size: 2.5vw;
        font-family: 'Roboto Condensed', sans-serif;
        margin: 0;
    }
}
</style>