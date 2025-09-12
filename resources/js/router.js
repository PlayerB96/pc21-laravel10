import { createRouter, createWebHistory } from "vue-router";
import InicioPage from "./views/page_public/InicioPage.vue";
import ServiciosPage from "./views/page_public/ServiciosPage.vue";
import GarantiaPage from "./views/page_public/GarantiaPage.vue"; // <-- ya existe
import VisionPage from "./views/page_public/VisionPage.vue";
import PerfilPage from "./views/page_public/Perfil.vue"; // <-- nuevo componente Perfil

const routes = [
  { path: "/", component: InicioPage },
  { path: "/inicio", component: InicioPage },
  { path: "/vision", component: VisionPage },
  { path: "/servicios", component: ServiciosPage },
  { path: "/garantia", component: GarantiaPage },
  { path: "/perfil", component: PerfilPage }, // <-- ruta para Mi Perfil
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
