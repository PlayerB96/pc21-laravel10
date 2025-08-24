<template>
    <nav class="navbar_main">
        <!-- Botón para abrir Sidebar en móvil -->
        <div v-if=userSession>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>

        <div class="navbar-logo">
            <img src="/assets/imgs/pc21v1.png" alt="Grupo LN1 Logo" />
        </div>


        <!-- Menú principal en desktop -->
        <ul class="navbar-menu d-none d-md-flex ">
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

        <!-- Sidebar Mobile -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menú</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
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

                        <ul v-if="item.subitems.length > 0" class="sub-menu">
                            <li v-for="(subitem, subIndex) in item.subitems" :key="subIndex">
                                <router-link :to="subitem.route" class="navbar-link">
                                    {{ subitem.label }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Icono de usuario o botón de login -->
        <div class="navbar-right">
            <div v-if="userSession" class="dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user text-white" id="userProfileDropdown"
                    data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header text-center fw-bold text-white">
                        {{ userSession.nombre_completo }}
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center text-white"
                            @click="handleLogout">
                            <img :src="assetsUrl + 'icons/quit.svg'" alt="Salir" class="me-2" width="20" />
                            <span>Salir</span>
                        </a>
                    </li>
                </ul>
            </div>
            <button v-if="!userSession" class="btn btn-danger ms-3" @click="handleLoginClick">
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
            { label: 'Vision', route: '/vision', subitems: [] },
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
            { label: 'Servicios', route: 'servicios', subitems: [] },
            { label: 'Productos', route: 'productos', subitems: [] },
            { label: 'Garantia', route: 'garantia', subitems: [] }
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
            // Si no hay sesión, mostrar solo los elementos permitidos
            if (!userSession.value) {
                return navItems.filter(item => !['Home', 'Inducción', 'Gestión de Personas', 'Producción'].includes(item.label));
            }

            // Si hay sesión, mostrar lo mismo que cuando no hay sesión
            return navItems.filter(item => !['Home', 'Inducción', 'Gestión de Personas', 'Producción'].includes(item.label));
        });




        // Métodos de navegación
        const isInternalSection = label => ['Inicio', 'Vision', 'Servicios', 'Empresas', 'Productos', 'Garantia'].includes(label);

        const getSectionId = label => {
            const sectionMap = {
                'Inicio': 'inicio',
                'Vision': 'vision',
                'Servicios': 'servicios',
                'Empresas': 'empresas',
                'Productos': 'productos',
                'Garantia': 'garantia'
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
    --dropdown-bg: var(--dark-secondary-bg);
    --dropdown-hover-bg: var(--menu-hover);
    --text-color: white;
}

/* 🔹 Barra de navegación principal */
.navbar_main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #00BFFF;
    /* DeepSkyBlue */

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
    background-color: var(--dropdown-bg) !important;
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


@media (max-width: 480px) {

    .offcanvas-header {
        background-color: var(--dark-secondary-bg);
        color: white;
    }

    .offcanvas-body {
        background-color: var(--dark-secondary-bg-transparent);
    }

    /* 🔹 Enlaces de navegación */
    .navbar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .navbar-item {
        display: block;
        padding: 8px 0;
    }

    /* Asegura que los submenús estén siempre visibles y correctamente espaciados */
    .sub-menu {
        list-style: none;
        padding-left: 20px;
        /* Desplaza un poco a la derecha */
        margin-top: 5px;
        display: block;
        /* Siempre visible */
        background-color: transparent;
    }

    .sub-menu li {
        padding: 5px 0;
    }

    /* Evita que los submenús se sobrepongan */
    .navbar-item,
    .sub-menu {
        position: relative;
        width: 100%;
        /* Ocupa todo el ancho disponible */
    }

    .navbar-toggler-icon {
        width: 30px;
        height: 30px;
        background: url("https://cdn-icons-png.flaticon.com/512/1828/1828859.png") no-repeat center;
        background-size: contain;
    }

    .offcanvas {
        background-color: var(--navbar-bg);
        color: var(--text-color);
    }

    .navbar-link {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px 15px;
        border-left: 4px solid transparent;
        /* Borde inicial transparente */
        transition: border-color 0.3s ease-in-out;
    }

    .navbar-link:hover {
        color: white;
        border-left: 4px solid var(--dropdown-hover-bg);
        /* Borde visible al pasar el mouse */
    }

}
</style>
