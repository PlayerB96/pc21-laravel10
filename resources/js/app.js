import { createApp } from "vue";
import MainComponent from "./components/MainComponent.vue";
import Navbar from "./components/Navbar.vue";
import FooterComponent from "./components/FooterComponent.vue";
import FloatingButton from "./components/FloatingButton.vue";
import router from "./router";
import axios from "axios";
import VueLazyload from "vue-lazyload";

import "../css/global.css";

// Bootstrap
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";

// Axios base URL
axios.defaults.baseURL = `${window.location.origin}/api/`;

// Crear instancia de Vue
const app = createApp(MainComponent);

// Registrar componentes globales
app.component("navbar", Navbar);
app.component("footer-component", FooterComponent);
app.component("floating-button", FloatingButton);

// Usar Router y Lazyload
app.use(router);
app.use(VueLazyload);

// Montar Vue
const appDiv = document.querySelector("#app");
if (appDiv) {
    app.mount("#app");
} else {
    console.error("❌ ERROR: No se encontró el div con id 'app'.");
}
