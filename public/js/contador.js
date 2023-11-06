var tiempoRestante = parseInt(document.getElementById('contador').getAttribute('data-contador'));

function actualizarContador() {
    tiempoRestante--;
    document.getElementById('contador').innerHTML = 'Redirigiendo en ' + tiempoRestante + ' segundos';

    if (tiempoRestante <= 0) {
        window.location.href = '/juegoIniciado/perder';
    }
}

var intervalo = setInterval(actualizarContador, 1000);