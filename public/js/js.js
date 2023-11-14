document.addEventListener("DOMContentLoaded", function() {
    var indice = 0;
    var imagenes = document.querySelectorAll(".carrusel div");
    var totalImagenes = imagenes.length;

    function actualizarCarrusel() {
        var desplazamiento = -indice * 100;
        for (var i = 0; i < imagenes.length; i++) {
            imagenes[i].style.transform = 'translateX(' + desplazamiento + '%)';
        }
        
        indice++;

        if (indice >= totalImagenes) {
            indice = 0;
        }
    }

    setInterval(actualizarCarrusel, 2000);
});
