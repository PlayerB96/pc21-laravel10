<template>
    <nav class="navbar">
        <div class="navbar-logo">
            <img src="/assets/imgs/Grupo-LN1.png" alt="Grupo LN1 Logo" />
        </div>

        <ul class="navbar-menu">
            <li v-for="(item, index) in filteredNavItems" :key="index" class="navbar-item">
                <!-- Si es una sección interna, usa scroll -->
                <a v-if="isInternalSection(item.label)" class="navbar-link"
                    :class="{ 'active-link': activeSection === getSectionId(item.label) }"
                    @click="scrollToSection(getSectionId(item.label))">
                    {{ item.label }}
                </a>

                <!-- Si no es interna, usa router-link -->
                <router-link v-else :to="item.route" class="navbar-link" active-class="active-link">
                    {{ item.label }}
                </router-link>

                <!-- Submenús solo si no es una sección interna -->
                <ul v-if="item.subitems.length > 0 && !isInternalSection(item.label)" class="sub-menu">
                    <li v-for="(subitem, subIndex) in item.subitems" :key="subIndex">
                        <router-link :to="subitem.route" class="navbar-link">
                            {{ subitem.label }}
                        </router-link>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-right">
            <!-- Si hay sesión, mostrar perfil -->
            <div v-if="userSession" class="nav-item dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <div class="dropdown-menu">
                    <div class="user-profile-section">
                        <h5>{{ userSession.nombre_completo }}</h5>
                    </div>
                    <div class="dropdown-item" id="logoutBtn" @click="handleLogout">
                        <a href="javascript:void(0);">
                            <img :src="assetsUrl + 'icons/quit.svg'" alt="Salir" />
                            <span>Salir</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Si NO hay sesión, mostrar login -->
            <button v-if="!userSession" id="btn-primary" class="btn-secondary" @click="handleLoginClick">
                Iniciar sesión
            </button>

            <!-- Modal -->
            <login-modal :isVisible="showModal" @update:isVisible="showModal = $event" />
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
                { label: 'Inicio', route: 'inicio', subitems: [] },
                { label: 'Home', route: 'home', subitems: [] },
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
                { label: 'Identidad Corporativa', route: 'identidadcorporativa', subitems: [] },
                { label: 'Empresas', route: 'empresas', subitems: [] },
                { label: 'Productos', route: 'productos', subitems: [] },
                { label: 'Blog', route: 'blog', subitems: [] }
            ],
            userSession: null, // Se obtiene desde el localStorage
            assetsUrl: '/assets/', // Ruta de assets
            isDarkMode: false, // Control de modo oscuro
            showModal: false,
            activeSection: null,
        };
    },
    mounted() {
        window.addEventListener("scroll", this.updateActiveSection);
        const storedSession = localStorage.getItem('userSession');
        if (storedSession) {
            this.userSession = JSON.parse(storedSession);
        }
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.updateActiveSection);
    },
    computed: {
        filteredNavItems() {
            return this.userSession
                ? this.navItems.filter(item => ['Home', 'Inducción', 'Gestión de Personas', 'Producción'].includes(item.label))
                : this.navItems.filter(item => !['Home', 'Inducción', 'Gestión de Personas', 'Producción'].includes(item.label));
        }
    },
    methods: {
        updateActiveSection() {
            const sections = document.querySelectorAll("section");
            let currentSection = "";

            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 100 && rect.bottom >= 100) { // Detectar la sección visible
                    currentSection = section.id;
                }
            });

            this.activeSection = currentSection;
            this.$emit("update-active-section", currentSection); // Emitimos la sección activa

        },
        isInternalSection(label) {
            return ['Inicio', 'Ecommerce', 'Identidad Corporativa', 'Empresas', 'Productos', 'Blog'].includes(label);
        },
        getSectionId(label) {
            // Asigna los valores correctos para los IDs de las secciones en `InicioPage.vue`
            const sectionMap = {
                'Inicio': 'inicio',
                'Ecommerce': 'ecommerce',
                'Identidad Corporativa': 'identidadcorporativa',
                'Empresas': 'empresas',
                'Productos': 'productos',
                'Blog': 'blog'
            };
            return sectionMap[label] || '';
        },
        scrollToSection(sectionId) {
            this.$nextTick(() => {
                const section = document.getElementById(sectionId);
                if (section) {
                    section.scrollIntoView({ behavior: "smooth" });
                }
            });
        },
        handleLoginClick() {
            this.showModal = true;
        },
        handleLogout() {
            localStorage.removeItem('userSession');
            this.userSession = null;
            this.$router.push('/inicio');
        }
    }
};
</script>

<style>
/* Activo: mismo estilo de active para router-link y scroll interno */
.active-link {
    color: #00aaff !important;
    font-weight: bold;
    border-bottom: 2px solid #00aaff;
    padding-bottom: 2px;
}

/* Efecto para hacer que se note más la transición */
.active-link,
.navbar-link:hover {
    transition: all 0.3s ease-in-out;
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
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;


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

.navbar-item:hover .sub-menu {
    display: block;
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


@media (max-width: 1380px) {
    .navbar-link {
        text-decoration: none;
        color: white;
        font-size: 0.8rem;
        font-weight: bold;
        padding: 0.5rem 0.8rem;
        display: inline-block;
    }

}

/* Media queries for responsive design */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
        position: static;
        /* Elimina el efecto de sticky/fixed */
    }

    .navbar-logo {
        margin-bottom: 1rem;
    }

    .navbar-menu {
        flex-direction: column;
        width: 100%;
    }

    .navbar-item {
        margin-right: 0;
        margin-bottom: 1rem;
        width: 100%;
    }

    .navbar-link {
        width: 100%;
        text-align: left;
    }

    .navbar-right {
        flex-direction: column;
        width: 100%;
        margin-top: 1rem;
    }

    .theme-toggle {
        margin-top: 1rem;
    }
}

/* Media queries for very small screens */
@media (max-width: 480px) {
    .navbar {
        padding: 0.5rem 1rem;
        position: static;
        /* Asegura que no sea sticky/fixed */
    }

    .navbar-logo img {
        max-height: 30px;
    }

    .navbar-link {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    .dropdown-item {
        padding: 0.5rem;
    }

    .dropdown-item img {
        max-width: 16px;
        margin-right: 0.5rem;
    }
}
</style>