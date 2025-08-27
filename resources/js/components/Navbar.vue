<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-info shadow-sm position-fixed w-100 top-0" style="z-index: 1100;">
    <div class="container-fluid px-4">
      <!-- Botón para abrir Sidebar en móvil -->
      <button v-if="userSession" class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Logo -->
      <router-link class="navbar-brand" to="/inicio" @click.prevent="$router.push('/inicio')">
        <img src="/assets/imgs/pc21v1.png" alt="PC 21" class="d-inline-block align-text-top" height="40" width="40">
      </router-link>

      <!-- Botón menú móvil -->
      <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú principal en desktop -->
      <div class="collapse navbar-collapse justify-content-center">
        <ul class="navbar-nav me-auto">
          <li v-for="(item, index) in filteredNavItems" :key="index" class="nav-item">
            <router-link 
              :to="item.route" 
              class="nav-link fw-bold px-3" 
              exact-active-class="active"
              @click.prevent="$router.push(item.route)"
            >
              {{ item.label }}
            </router-link>
          </li>
        </ul>
      </div>

      <!-- Sidebar Mobile -->
      <div class="offcanvas offcanvas-start bg-info text-white" tabindex="-1" id="mobileSidebar" ref="mobileSidebarRef">
        <div class="offcanvas-header border-bottom border-light">
          <h5 class="offcanvas-title" >Menú</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav">
            <li v-for="(item, index) in filteredNavItems" :key="index" class="nav-item">
              <router-link 
                :to="item.route" 
                class="nav-link py-2 px-3 text-white" 
                exact-active-class="active bg-primary rounded"
                @click.prevent="$router.push(item.route)"
                data-bs-dismiss="offcanvas"
              >
                {{ item.label }}
              </router-link>
            </li>
          </ul>
        </div>
      </div>

      <!-- Sección derecha: Usuario o Login -->
      <div class="d-flex align-items-center">
        <div v-if="userSession" class="dropdown">
          <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" id="userProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end bg-dark">
            <li><h6 class="dropdown-header text-info text-center">{{ userSession.nombre_completo }}</h6></li>
            <li><hr class="dropdown-divider border-secondary"></li>
            <li>
              <a href="#" class="dropdown-item d-flex align-items-center text-white" @click="handleLogout">
                <img :src="assetsUrl + 'icons/quit.svg'" alt="Salir" class="me-2" width="20">
                <span>Salir</span>
              </a>
            </li>
          </ul>
        </div>

        <button v-if="!userSession" class="btn btn-danger" @click="handleLoginClick">
          Iniciar sesión
        </button>
      </div>

      <login-modal :isVisible="showModal" @update:isVisible="showModal = $event" />
    </div>
  </nav>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import LoginModal from './modals/LoginModal.vue';

export default {
  components: { LoginModal },
  setup() {
    const router = useRouter();
    const userSession = ref(null);
    const showModal = ref(false);
    const assetsUrl = '/assets/';

    const navItems = [
      { label: 'Inicio', route: '/inicio' },
      { label: 'Vision', route: '/vision' },
      { label: 'Servicios', route: '/servicios' },
    //   { label: 'Garantia', route: '/garantia' }
    ];

    const updateUserSession = () => {
      userSession.value = JSON.parse(localStorage.getItem('userSession')) || null;
    };

    onMounted(() => {
      updateUserSession();
      window.addEventListener("storage", updateUserSession);
    });

    onUnmounted(() => {
      window.removeEventListener("storage", updateUserSession);
    });

    const filteredNavItems = computed(() => navItems);

    const handleLoginClick = () => { showModal.value = true; };
    const handleLogout = () => {
      localStorage.removeItem('userSession');
      userSession.value = null;
      router.push('/inicio');
    };

    return {
      userSession,
      filteredNavItems,
      handleLogout,
      handleLoginClick,
      showModal,
      assetsUrl
    };
  }
};
</script>

<style scoped>
/* Hover y activo para navbar */
.navbar-nav .nav-link:hover {
  background-color: rgba(255, 255, 255, 0.2);
  border-radius: 5px;
}

.navbar-nav .nav-link.active {
  background-color: rgba(255, 255, 255, 0.4);
  border-radius: 5px;
}
</style>
