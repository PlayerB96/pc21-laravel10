
// Selecciona el botón del dropdown y el menú
const userProfileDropdown = document.getElementById('userProfileDropdown');
const dropdownMenu = document.querySelector('.dropdown-menu');

// Muestra u oculta el menú al hacer clic en el botón
userProfileDropdown.addEventListener('click', function () {
    dropdownMenu.classList.toggle('show');
});

// Cierra el menú si se hace clic fuera de él
document.addEventListener('click', function (event) {
    if (!userProfileDropdown.contains(event.target)) {
        dropdownMenu.classList.remove('show');
    }
});

// Función para alternar entre modo claro y oscuro
function toggleDarkMode() {
    const body = document.body; // Asegúrate de que trabajas con el <body>
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    // Alterna las clases de modo claro y oscuro
    if (body.classList.contains('dark')) {
        body.classList.remove('dark');
        body.classList.add('light');
        moonIcon.style.display = 'block';
        sunIcon.style.display = 'none';
        localStorage.setItem('theme', 'light');

    } else {
        body.classList.remove('light');
        body.classList.add('dark');
        moonIcon.style.display = 'none';
        sunIcon.style.display = 'block';
        localStorage.setItem('theme', 'dark');

    }
}

// Configurar el tema al cargar la página
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const user = localStorage.getItem('user');
    const userProfileDropdown = document.querySelector(".nav-item.dropdown");

    var loginButton = document.querySelector('[id^="login-btn-"]');
    const body = document.body;
    if (savedTheme) {
        body.classList.add(savedTheme);
    } else {
        body.classList.add('light'); // Tema predeterminado
    }

    if (!user) {
        loginButton.style.display = 'inline-block';
    } else {
        loginButton.style.display = 'none';
        const dropdownMenu = userProfileDropdown.querySelector(".dropdown-menu");
        const userNameElement = dropdownMenu.querySelector("h5");
        userNameElement.textContent = user;
        userProfileDropdown.style.display = "block";
    }

});

let lastScrollTop = 0;
window.addEventListener("scroll", function () {
    let navbar = document.querySelector(".navbar");
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    if (currentScroll > lastScrollTop) {
        // Si estamos desplazándonos hacia abajo
        navbar.classList.add("sticky");
    } else {
        // Si estamos desplazándonos hacia arriba
        navbar.classList.remove("sticky");
    }
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Evita que el scroll sea negativo
});

// Función para manejar la clase activa en los enlaces
function setActiveLink(link) {
    console.log(link)
    // Eliminar la clase activa de todos los enlaces
    const links = document.querySelectorAll('.navbar-link');
    links.forEach(function (item) {
        item.classList.remove('active');
    });
    // Agregar la clase activa al enlace seleccionado
    link.classList.add('active');
}

function toggleSubMenu(index) {
    const subMenu = document.getElementById('sub-menu-' + index);
    if (subMenu) {
        if (subMenu.style.display === 'block') {
            subMenu.style.display = 'none';
        } else {
            subMenu.style.display = 'block';
        }
    } else {
        console.warn("Submenu no encontrado para el índice: " + index);
    }
}

// Función de cierre de sesión
document.getElementById('logoutBtn').addEventListener('click', function () {
    localStorage.removeItem('user');
    location.reload();
});

function handleLoginClick() {
    modalElement = document.querySelector('[id^="modal-"]')
    // Verifica si el modal existe
    if (modalElement) {
        modalElement.style.display = 'block';  // Muestra el modal
        modalElement.style.zIndex = '9999'; // Asegura que el modal esté sobre otros elementos
        modalElement.classList.add('show'); // Si usas clases para el modal, añade una clase 'show' para visibilidad
        // Si quieres ocultarlo al hacer clic fuera del modal
        window.onclick = function (event) {
            if (event.target === modalElement) {
                modalElement.style.display = 'none';  // Oculta el modal cuando se hace clic fuera de él
            }
        };
    }
}
