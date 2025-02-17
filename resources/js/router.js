import { createRouter, createWebHistory } from "vue-router";
import InicioPage from "./views/page_public/InicioPage.vue";
import InduccionPage from "./views/page_auth/InduccionPage.vue";
import EcommercePage from "./views/page_public/EcommercePage.vue";
import BlogPage from "./views/page_public/BlogPage.vue";
import ProductosPage from "./views/page_public/ProductosPage.vue";
import EmpresasPage from "./views/page_public/EmpresasPage.vue";
import ProduccionPage from "./views/page_auth/ProduccionPage.vue";
import IdentidadCorporativaPage from "./views/page_public/IdentidadCorporativaPage.vue";
import GestionPersonasPage from "./views/page_auth/GestionPersonasPage.vue";
import RegistroPapeletasPage from "./views/page_auth/gestionpersonas/RegistroPapeletasPage.vue";
import RegistroColaboradorPage from "./views/page_auth/gestionpersonas/RegistroColaboradorPage.vue";
import FichasProduccionPage from "./views/page_auth/fichas_produccion/FichasProduccionPage.vue";
import HomePage from "./views/page_auth/HomePage.vue";

const routes = [
    { path: "/", component: InicioPage },
    { path: "/inicio", component: InicioPage },
    { path: "/home", component: HomePage },
    { path: "/induccion", component: InduccionPage },
    { path: "/ecommerce", component: EcommercePage },
    {
        path: "/produccion",
        component: ProduccionPage,
        children: [
            { path: "fichas_produccion", component: FichasProduccionPage },
        ],
    },
    { path: "/identidadcorporativa", component: IdentidadCorporativaPage },
    { path: "/empresas", component: EmpresasPage },
    { path: "/productos", component: ProductosPage },
    { path: "/blog", component: BlogPage },

    {
        path: "/gestionpersonas",
        component: GestionPersonasPage,
        children: [
            { path: "registro_papeletas", component: RegistroPapeletasPage },
            {
                path: "registro_colaboradores",
                component: RegistroColaboradorPage,
            },
        ],
    },

    // Agrega más rutas según las necesidades
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
