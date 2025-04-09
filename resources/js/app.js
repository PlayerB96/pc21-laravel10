import { createApp } from "vue";
import MainComponent from "./components/MainComponent.vue";
import Navbar from "./components/Navbar.vue";
import FooterComponent from "./components/FooterComponent.vue";
import FloatingButton from "./components/FloatingButton.vue";
import router from "./router";
import axios from "axios";
import VueLazyload from "vue-lazyload";

import "../css/global.css";

// Importar estilos de Bootstrap 5
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

// Importar Bootstrap Icons (opcional)
import "bootstrap-icons/font/bootstrap-icons.css";
// Configura la URL base para Axios
// axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.baseURL = `${window.location.origin}/api/`;

// Crea la instancia de la aplicación Vue
const app = createApp(MainComponent);

// Configura la clave de API de Google Maps

// Registra los componentes globales
app.component("main-component", MainComponent);
app.component("navbar", Navbar);
app.component("footer-component", FooterComponent);
app.component("chatbot", FloatingButton);

// Usa el router
app.use(router);
app.use(VueLazyload);

// Monta la aplicación si el div con id 'app' existe
if (document.querySelector("#app")) {
    app.mount("#app");
} else {
    console.error(
        "❌ ERROR: No se encontró el div con id 'app'. Asegúrate de que existe en tu HTML."
    );
}
