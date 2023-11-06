var tiempoRestante = {{ contador }}; // Obtén el valor del contador desde la vista Mustache

function actualizarContador() {
    tiempoRestante--;
    document.getElementById('contador').innerHTML = 'Redirigiendo en ' + tiempoRestante + ' segundos';

    if (tiempoRestante <= 0) {
        window.location.href = '../controller/juegoIniciado/perder';
    }
}

var intervalo = setInterval(actualizarContador, 1000);