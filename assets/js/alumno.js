const userIcon = document.getElementById('userIcon');
    const userMenu = document.getElementById('userMenu');

    userIcon.addEventListener('click', () => {
        userMenu.classList.toggle('active');   

    });

const navLinks = document.querySelectorAll('.nav_links a');

navLinks.forEach(link => {
    link.addEventListener('click', function() {
        navLinks.forEach(nav => nav.classList.remove('active')); // Remover la clase activa de todos
        this.classList.add('active'); // Agregar la clase activa al enlace clicado
    });
});