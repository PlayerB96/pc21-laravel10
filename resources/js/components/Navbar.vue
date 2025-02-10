<template>
    <nav class="navbar">
        <!-- Imagen a la derecha -->
        <div class="navbar-logo">
            <img src="/assets/imgs/Grupo-LN1.png" alt="Grupo LN1 Logo" />
        </div>

        <!-- Menú de navegación -->
        <ul class="navbar-menu">
            <li v-for="(item, index) in filteredNavItems" :key="index" class="navbar-item"
                @click="toggleSubMenu(index)">
                <router-link :to="item.route" class="navbar-link" active-class="active-link"
                    @click="setActiveLink($event)">
                    {{ item.label }}
                </router-link>
                <ul v-if="item.subitems.length > 0" class="sub-menu" :id="'sub-menu-' + index">
                    <li v-for="(subitem, subIndex) in item.subitems" :key="subIndex">
                        <router-link :to="subitem.route" class="navbar-link" @click="setActiveLink($event)">
                            {{ subitem.label }}
                        </router-link>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-right">
            <!-- Mostrar el perfil del usuario si hay sesión -->
            <div v-if="userSession" class="nav-item dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <div class="dropdown-menu" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <div class="media-body">
                                <h5>{{ userSession.nombre_completo }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <router-link :to="'/configuracion'">
                            <img :src="assetsUrl + 'icons/setting.svg'" alt="Configuración" />
                            <span>Configuración</span>
                        </router-link>
                    </div>
                    <div class="dropdown-item" id="logoutBtn" @click="handleLogout">
                        <a href="javascript:void(0);">
                            <img :src="assetsUrl + 'icons/quit.svg'" alt="Salir" />
                            <span>Salir</span>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Mostrar el botón de login si no hay sesión -->
            <button v-if="!userSession" id="login-btn" class="btn-primary" @click="handleLoginClick">
                <span class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </span>
                Iniciar sesión
            </button>

            <!-- Modal -->
            <login-modal :isVisible="showModal" @update:isVisible="showModal = $event" />

            <!-- Icono para cambiar el modo -->
            <div class="theme-toggle">
                <button @click="toggleDarkMode" class="theme-toggle-button">
                    <div class="theme-icons">
                        <img v-if="isDarkMode" :src="assetsUrl + 'icons/sun-icon.svg'" alt="Sol Icono"
                            class="theme-icon" />
                        <img v-else :src="assetsUrl + 'icons/moon-icon.svg'" alt="Luna Icono" class="theme-icon" />
                    </div>
                </button>
            </div>
        </div>
    </nav>
</template>

<script>
import LoginModal from './modals/LoginModal.vue';

export default {
    components: {
        LoginModal,
    },
    data() {
        return {
            navItems: [
                { label: 'Inicio', route: '/inicio', subitems: [] },
                { label: 'Inducción', route: '/induccion', subitems: [] },
                { label: 'Ecommerce', route: '/ecommerce', subitems: [] },
                {
                    label: 'Gestión de Personas',
                    route: '/gestionpersonas',
                    subitems: [
                        { label: 'Papeletas', route: '/gestionpersonas/registro_papeletas' },
                        { label: 'Postulantes', route: '/gestionpersonas/registro_postulantes' }
                    ]
                },
                {
                    label: 'Producción', route: '/produccion',
                    subitems: [
                        { label: 'Fichas Técnicas', route: '/produccion/fichas_produccion' }
                    ]
                },
                { label: 'Identidad Corporativa', route: '/identidadcorporativa', subitems: [] },
                { label: 'Empresas', route: '/empresas', subitems: [] },
                { label: 'Productos', route: '/productos', subitems: [] },
                { label: 'Blog', route: '/blog', subitems: [] }
            ],
            userSession: null, // Esto lo debes manejar desde tu lógica de autenticación
            assetsUrl: '/assets/', // URL para acceder a los assets, ajústalo según tu configuración
            isDarkMode: false, // Variable para el tema oscuro
            showModal: false // Definir aquí el estado del modal
        };
    },
    mounted() {
        const storedSession = localStorage.getItem('userSession');
        if (storedSession) {
            console.log('Sesión almacenada:', storedSession);
            this.userSession = JSON.parse(storedSession);
        } else {
            console.log('No se encontró ninguna sesión almacenada.');
        }
    },

    computed: {
        filteredNavItems() {
            // if (!this.userSession) {
            // return this.navItems.filter(item => !['Inducción', 'Gestión de Personas', 'Producción'].includes(item.label));
            // }
            return this.navItems;
        }
    },
    methods: {
        setActiveLink(event) {
            // Lógica para cambiar el enlace activo
        },
        toggleSubMenu(index) {
            // Lógica para mostrar/ocultar submenús
        },
        handleLoginClick() {
            console.log("Botón Iniciar sesión presionado"); // Verificar si se ejecuta
            this.showModal = true;
            console.log(this.showModal); // Verifica si se actualiza el estado
        },

        handleLogout() {
            console.log("####111");
            localStorage.removeItem('userSession');
            console.log("####222");
            this.userSession = null;
            console.log("####333");
            // window.location.reload();

        }
        ,
        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
        }
    }
};
</script>

<style>
.active-link {
    font-weight: bold;
    color: #ffcc00;
    /* Puedes cambiar el color para que se vea resaltado */
    border-bottom: 2px solid #ffcc00;
}

/* Estilos globales para la barra de navegación */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: var(--dark-secondary-bg);
    /* Fondo oscuro, cambia según tu tema */
    color: white;
}

/* Estilos de la imagen de logo */
.navbar-logo img {
    max-height: 40px;
    /* Ajusta el tamaño del logo */
}

/* Estilos para los enlaces de la barra de navegación */
.navbar-menu {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar-item {
    position: relative;
    margin-right: 2rem;
}

.navbar-link {
    text-decoration: none;
    color: white;
    font-size: 1rem;
    font-weight: bold;
    padding: 0.5rem 1rem;
    display: inline-block;
}

.navbar-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    /* Fondo al pasar el ratón */
    border-radius: 5px;
}

/* Submenú */
.sub-menu {
    list-style: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #444;
    display: none;
    padding: 0;
    margin: 0;
    z-index: 10;
}

.navbar-item:hover .sub-menu {
    display: block;
}

.sub-menu li {
    padding: 0.5rem 1rem;
}

.sub-menu li a {
    color: white;
}

.sub-menu li a:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Estilo para la sección de la derecha (login, usuario, tema) */
.navbar-right {
    display: flex;
    align-items: center;
}

/* Estilos para el botón de login */
#login-btn {
    background-color: #007bff;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

#login-btn:hover {
    background-color: #0056b3;
}

#login-btn .btn-icon {
    margin-right: 0.5rem;
}

/* Icono de usuario y dropdown */
.nav-item.dropdown {
    position: relative;
}

.nav-item .dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #444;
    border-radius: 5px;
    min-width: 200px;
    display: none;
    z-index: 10;
}

.nav-item .dropdown-menu .user-profile-section {
    padding: 1rem;
    background-color: #333;
}

.nav-item:hover .dropdown-menu {
    display: block;
}

.dropdown-item {
    padding: 0.75rem;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.dropdown-item img {
    max-width: 20px;
    margin-right: 0.75rem;
}

.dropdown-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Estilos del toggle para el modo oscuro */
.theme-toggle-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
}

.theme-icon {
    width: 24px;
    height: 24px;
}

/* Media queries para pantallas pequeñas */
@media (max-width: 768px) {
    .navbar-menu {
        flex-direction: column;
    }

    .navbar-item {
        margin-right: 0;
        margin-bottom: 1rem;
    }

    .navbar-right {
        flex-direction: column;
        margin-top: 1rem;
    }
}
</style>