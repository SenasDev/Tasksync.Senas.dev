function toggleDarkMode() {
    const body = document.body;
    const button = document.getElementById('dark-mode-toggle');
    const icon = button.querySelector('i'); // Selecciona el ícono dentro del botón

    // Comprueba si el tema actual es oscuro o claro y actualiza los atributos y clases correspondientes
    if (body.getAttribute('data-theme') === 'dark') {
        body.setAttribute('data-theme', 'light');
        icon.classList.remove('bi-sun-fill');
        icon.classList.add('bi-moon-fill');
    } else {
        body.setAttribute('data-theme', 'dark');
        icon.classList.remove('bi-moon-fill');
        icon.classList.add('bi-sun-fill');
    }
}

// Asignar el evento click al botón de modo oscuro
document.getElementById('dark-mode-toggle').addEventListener('click', toggleDarkMode);


