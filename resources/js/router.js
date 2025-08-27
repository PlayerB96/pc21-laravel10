import { createRouter, createWebHistory } from "vue-router";
import InicioPage from "./views/page_public/InicioPage.vue";
import ServiciosPage from "./views/page_public/ServiciosPage.vue";
import GarantiaPage from "./views/page_public/GarantiaPage.vue"; // <-- crea este componente
import VisionPage from "./views/page_public/VisionPage.vue";

const routes = [
  { path: "/", component: InicioPage },
  { path: "/inicio", component: InicioPage },
  { path: "/vision", component: VisionPage },
  { path: "/servicios", component: ServiciosPage },
  { path: "/garantia", component: GarantiaPage }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
