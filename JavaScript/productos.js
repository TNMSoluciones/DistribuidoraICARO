document.addEventListener('DOMContentLoaded', ()=>{
    const articulosPadre = document.getElementById('section1');
    articulosPadre.addEventListener('click', e=>{
        if(e.target && e.target.tagName==="INPUT")
        {
            const producto = e.target.parentElement
            const popUp = document.getElementById('popup');
            
            popUp.querySelector('img').setAttribute('src', producto.querySelector('img').getAttribute('src'));
            popUp.querySelector('h1:first-of-type').textContent = producto.querySelector('h1').textContent;
            popUp.querySelector('h1:nth-of-type(2)').textContent = producto.querySelector('p:first-of-type').textContent;

        }
    })
});