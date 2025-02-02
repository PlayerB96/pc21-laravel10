import { createRouter, createWebHistory } from "vue-router";
import InicioPage from "./views/InicioPage.vue";
import InduccionPage from "./views/InduccionPage.vue";
import EcommercePage from "./views/EcommercePage.vue";
import BlogPage from "./views/BlogPage.vue";
import ProductosPage from "./views/ProductosPage.vue";
import EmpresasPage from "./views/EmpresasPage.vue";
import ProduccionPage from "./views/ProduccionPage.vue";
import IdentidadCorporativaPage from "./views/IdentidadCorporativaPage.vue";
import GestionPersonasPage from "./views/GestionPersonasPage.vue";
import RegistroPapeletasPage from "./views/gestionpersonas/RegistroPapeletasPage.vue";
import RegistroPostulantesPage from "./views/gestionpersonas/RegistroPostulantesPage.vue";
import FichasProduccionPage from "./views/fichas_produccion/FichasProduccionPage.vue";

const routes = [
    { path: "/", component: InicioPage },
    { path: "/inicio", component: InicioPage },
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
                path: "registro_postulantes",
                component: RegistroPostulantesPage,
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
