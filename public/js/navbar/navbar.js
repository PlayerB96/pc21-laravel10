// Selecciona el botón del dropdown y el menú
const userProfileDropdown = document.getElementById('userProfileDropdown');
const dropdownMenu = document.querySelector('.dropdown-menu');

// Muestra u oculta el menú al hacer clic en el botón
userProfileDropdown.addEventListener('click', function (event) {
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
        localStorage.setItem('theme', 'light'); // Guardar en localStorage

    } else {
        body.classList.remove('light');
        body.classList.add('dark');
        moonIcon.style.display = 'none';
        sunIcon.style.display = 'block';
        localStorage.setItem('theme', 'dark'); // Guardar en localStorage

    }
}


// Configurar el tema al cargar la página
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const body = document.body;

    if (savedTheme) {
        body.classList.add(savedTheme);
    } else {
        body.classList.add('light'); // Tema predeterminado
    }

});
let lastScrollTop = 0; // Variable para almacenar la última posición de desplazamiento


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



document.addEventListener("DOMContentLoaded", function () {
    // Verifica si el usuario está en el localStorage
    const user = localStorage.getItem("user");

    // Obtén el contenedor donde se debería mostrar el perfil o el botón de inicio de sesión
    const userProfileDropdown = document.querySelector(".nav-item.dropdown");
    const loginButton = document.querySelector(".login-button");

    if (user) {
        // Si el usuario está en el localStorage, muestra el perfil con el nombre del usuario
        const dropdownMenu = userProfileDropdown.querySelector(".dropdown-menu");
        const userNameElement = dropdownMenu.querySelector("h5");
        // Inserta el nombre del usuario
        userNameElement.textContent = user;
        // Asegúrate de que el dropdown se muestre
        userProfileDropdown.style.display = "block";
    } else {
        // Si no hay usuario en el localStorage, muestra el botón de inicio de sesión
        if (loginButton) {
            loginButton.style.display = "block";
        }
        // Oculta el dropdown
        userProfileDropdown.style.display = "none";
    }
});

function redirectToLogin(button) {
    // Obtener el valor de 'data-route' que contiene la URL de redirección
    const loginUrl = button.getAttribute('data-route');
    // Redirigir al usuario a la URL especificada en 'data-route'
    window.location.href = loginUrl;
}

// Función de cierre de sesión
function logout() {
    localStorage.removeItem('user'); // Eliminar datos del usuario en localStorage
    location.reload(); // Recargar la página para reflejar el cambio
}




function handleLoginClick() {
    console.log("#######111");
    // Obtener el modal por su ID
    var modalId = 'modalLogin'; // El mismo ID que asignaste al modal en Blade
    var modalElement = document.getElementById(modalId);
    console.log("#######2222");
    console.log(modalElement);

    // Verifica si el modal existe
    if (modalElement) {
        modalElement.style.display = 'block';  // Muestra el modal
        modalElement.style.zIndex = '9999'; // Asegura que el modal esté sobre otros elementos
        modalElement.classList.add('show'); // Si usas clases para el modal, añade una clase 'show' para visibilidad

        console.log("#######333");

        // Si quieres ocultarlo al hacer clic fuera del modal
        window.onclick = function (event) {
            console.log("#######333----");
            if (event.target === modalElement) {
                modalElement.style.display = 'none';  // Oculta el modal cuando se hace clic fuera de él
            }
        };
    }

    console.log("#######4444");
}
