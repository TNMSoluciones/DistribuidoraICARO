<?php 
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Distribuidora ICARO');
?>
<main>
    <div class="container">
        <div id="imgDiv">
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="128" height="128" viewBox="0 0 48 48" style=" fill:#000000;"><path fill="#c8e6c9" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#4caf50" d="M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z"></path></svg>
        </div>    
        <h1>¡Listo! Gracias por comprar en Distribuidora ICARO</h1>
        <p>Le enviaremos un correo cuando su pedido haya sido confirmado.</p>
    </div>
</main>
<?php include_once 'Assets/footer.php';?>
<style>
    .container {
        float: left;
        background-color: rgb(255, 255, 255);
        width: 50%;
        height: 20vw;
        margin: 6vw 0 0 25%;
        border: 1px solid rgb(240, 240, 240);
        border-radius: 5px;
    }
    #imgDiv {
        width: 100%;
        height: 12vw;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container h1, .container p {
        text-align: center;
    }
</style>