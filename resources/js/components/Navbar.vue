<template>
    <nav class="navbar_main">
        <div class="navbar-logo">
            <img src="/assets/imgs/Grupo-LN1.png" alt="Grupo LN1 Logo" />
        </div>

        <ul class="navbar-menu">
            <li v-for="(item, index) in filteredNavItems" :key="index" class="navbar-item">
                <a v-if="isInternalSection(item.label)" class="navbar-link"
                    :class="{ 'active-link': activeSection === getSectionId(item.label) }"
                    @click="scrollToSection(getSectionId(item.label))">
                    {{ item.label }}
                </a>
                <router-link v-else :to="item.route" class="navbar-link" active-class="active-link">
                    {{ item.label }}
                </router-link>

                <ul v-if="item.subitems.length > 0 && !isInternalSection(item.label)" class="sub-menu">
                    <li v-for="(subitem, subIndex) in item.subitems" :key="subIndex">
                        <router-link :to="subitem.route" class="navbar-link">
                            {{ subitem.label }}
                        </router-link>
                    </li>
                </ul>
            </li>
        </ul>


        <div class="navbar-right d-flex align-items-center">
            <div v-if="userSession" class="dropdown">
                <!-- Icono de usuario que activa el dropdown -->
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user text-white d-flex align-items-center"
                    id="userProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>

                <!-- Dropdown de Bootstrap -->
                <ul class="dropdown-menu dropdown-menu-end  text-white" aria-labelledby="userProfileDropdown">
                    <li class="dropdown-header text-center fw-bold text-white">
                        {{ userSession.nombre_completo }}
                    </li>
                    <li>
                        <a href="javascript:void(0);"
                            class="dropdown-item  d-flex align-items-center text-white"
                            @click="handleLogout">
                            <img :src="assetsUrl + 'icons/quit.svg'" alt="Salir" class="me-2" width="20" />
                            <span>Salir</span>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Botón de inicio de sesión -->
            <button v-if="!userSession" class="btn-primary ms-3" @click="handleLoginClick">
                Iniciar sesión
            </button>

            <login-modal :isVisible="showModal" @update:isVisible="showModal = $event" />
        </div>
    </nav>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import LoginModal from './modals/LoginModal.vue';

export default {
    components: {
        LoginModal,
    },
    setup() {
        const router = useRouter();
        const userSession = ref(null);
        const showModal = ref(false);
        const activeSection = ref(null);
        const assetsUrl = '/assets/';

        // Lista de navegación
        const navItems = [
            { label: 'Inicio', route: 'inicio', subitems: [] },
            { label: 'Home', route: '/home', subitems: [] },
            {
                label: 'Inducción',
                route: '/induccion',
                subitems: [{ label: 'Video Inducción', route: '/induccion/video_induccion' }]
            },
            { label: 'Ecommerce', route: '/ecommerce', subitems: [] },
            {
                label: 'Gestión de Personas',
                route: '/gestionpersonas',
                subitems: [
                    { label: 'Papeletas', route: '/gestionpersonas/registro_papeletas' },
                    { label: 'Datos Colaboradores', route: '/gestionpersonas/registro_colaboradores' }
                ]
            },
            {
                label: 'Producción', route: '/produccion',
                subitems: [{ label: 'Fichas Técnicas', route: '/produccion/fichas_produccion' }]
            },
            { label: 'Identidad Corporativa', route: 'identidadcorporativa', subitems: [] },
            { label: 'Empresas', route: 'empresas', subitems: [] },
            { label: 'Productos', route: 'productos', subitems: [] },
            { label: 'Blog', route: 'blog', subitems: [] }
        ];

        // Cargar usuario desde localStorage
        const updateUserSession = () => {
            userSession.value = JSON.parse(localStorage.getItem('userSession')) || null;
        };

        // Escuchar cambios en localStorage y scroll
        onMounted(() => {
            updateUserSession();
            window.addEventListener("storage", updateUserSession);
            window.addEventListener("scroll", updateActiveSection);
        });

        onUnmounted(() => {
            window.removeEventListener("storage", updateUserSession);
            window.removeEventListener("scroll", updateActiveSection);
        });

        // Actualizar la sección activa en el scroll
        const updateActiveSection = () => {
            const sections = document.querySelectorAll("section");
            let currentSection = "";

            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 100 && rect.bottom >= 100) {
                    currentSection = section.id;
                }
            });

            activeSection.value = currentSection;
        };

        // Filtrar elementos de navegación dinámicamente
        const filteredNavItems = computed(() => {
            if (!userSession.value) {
                return navItems.filter(item => !['Home', 'Inducción', 'Gestión de Personas', 'Producción'].includes(item.label));
            }
            const userRestrictions = {
                induccion: userSession.value.induccion === 1,
                datosCompletos: userSession.value.datos_completos === 1
            };
            return navItems
                .filter(item => {
                    if (userRestrictions.induccion) {
                        return ['Home', 'Gestión de Personas', 'Producción'].includes(item.label);
                    }
                    return ['Home', 'Inducción'].includes(item.label);
                })
                .map(item => ({
                    ...item,
                    subitems: item.subitems.filter(subitem => {
                        if (userRestrictions.induccion && userRestrictions.datosCompletos && subitem.label === 'Datos Colaboradores') {
                            return false;
                        }
                        return true;
                    })
                }));
        });



        // Métodos de navegación
        const isInternalSection = label => ['Inicio', 'Ecommerce', 'Identidad Corporativa', 'Empresas', 'Productos', 'Blog'].includes(label);

        const getSectionId = label => {
            const sectionMap = {
                'Inicio': 'inicio',
                'Ecommerce': 'ecommerce',
                'Identidad Corporativa': 'identidadcorporativa',
                'Empresas': 'empresas',
                'Productos': 'productos',
                'Blog': 'blog'
            };
            return sectionMap[label] || '';
        };

        const scrollToSection = sectionId => {
            setTimeout(() => {
                const section = document.getElementById(sectionId);
                if (section) {
                    section.style.scrollMarginTop = "20px";
                    section.scrollIntoView({ behavior: "smooth" });
                }
            }, 100);
        };

        const handleLoginClick = () => {
            showModal.value = true;
        };

        const handleLogout = () => {
            localStorage.removeItem('userSession');
            userSession.value = null;
            router.push('/inicio');
        };

        return {
            userSession,
            filteredNavItems,
            updateUserSession,
            updateActiveSection,
            handleLogout,
            handleLoginClick,
            showModal,
            activeSection,
            assetsUrl,
            isInternalSection,
            getSectionId,
            scrollToSection
        };
    }
};
</script>



<style>
/* 🔹 Estilos globales */
:root {
    --navbar-bg: var(--dark-secondary-bg-transparent);
    --submenu-bg: var(--dark-secondary-bg-transparent);
    --dropdown-bg: var(--dark-secondary-bg-transparent);
    --dropdown-hover-bg: var(--menu-hover);
    --text-color: white;
}

/* 🔹 Barra de navegación principal */
.navbar_main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: var(--navbar-bg);
    color: var(--text-color);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}

/* 🔹 Logo */
.navbar-logo img {
    max-height: 40px;
}

/* 🔹 Enlaces de navegación */
.navbar-menu {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar-item {
    position: relative;
    margin-right: 2rem;
    cursor: pointer;
}

.navbar-link {
    text-decoration: none;
    color: var(--text-color);
    font-size: 1rem;
    font-weight: bold;
    padding: 0.5rem 1rem;
    display: inline-block;
    transition: all 0.3s ease-in-out;
}

.navbar-link:hover,
.active-link {
    background-color: var(--dropdown-hover-bg);
    border-radius: 5px;
}

/* 🔹 Submenú */
.sub-menu {
    list-style: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: var(--submenu-bg);
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
    color: var(--text-color);
}

.sub-menu li a:hover {
    background-color: var(--dropdown-hover-bg);
}

/* 🔹 Sección derecha de la navbar */
.navbar-right {
    display: flex;
    align-items: center;
}

/* 🔹 Dropdown (Usuario) */
.nav-item.dropdown {
    position: relative;
}

.dropdown-menu {
    background-color:  var(--dropdown-bg) !important;
    border: none;
    min-width: 200px;
}

.nav-item:hover .dropdown-menu {
    display: block;
}

.dropdown-item {
    color: var(--text-color) !important;
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
    background-color: var(--dropdown-hover-bg) !important;
}

/* 🔹 Media Queries para responsive */
@media (max-width: 1380px) {
    .navbar-link {
        font-size: 0.8rem;
        padding: 0.5rem 0.8rem;
    }
}

@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
        position: static;
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

@media (max-width: 480px) {
    .navbar {
        padding: 0.5rem 1rem;
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