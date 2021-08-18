<script>
    let menuBandera = false;
    document.getElementById('btnCat').addEventListener('click',()=>{
        if (menuBandera)
        {
            document.getElementById('btnCat').style.transform= 'rotate(0deg)';
            document.getElementById('categorias').style.marginLeft = '-100vw';
        }
        else
        {
            document.getElementById('btnCat').style.transform= 'rotate(-90deg)';
            document.getElementById('categorias').style.marginLeft = '0vw';
        }
        menuBandera = !menuBandera;
    });
</script>