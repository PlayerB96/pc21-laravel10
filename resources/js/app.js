import { createApp } from "vue";
import MainComponent from "./components/MainComponent.vue";
import Navbar from "./components/Navbar.vue";
import FooterComponent from "./components/FooterComponent.vue";
import Chatbot from "./components/Chatbot.vue";
import router from "./router";
import axios from 'axios';
import '../css/global.css'; 

// Configura la URL base para Axios
axios.defaults.baseURL = 'http://localhost:8000/api/';

// Crea la instancia de la aplicación Vue
const app = createApp(MainComponent);

// Registra los componentes globales
app.component("main-component", MainComponent);
app.component("navbar", Navbar);
app.component("footer-component", FooterComponent);
app.component("chatbot", Chatbot);

// Usa el router
app.use(router);

// Monta la aplicación si el div con id 'app' existe
if (document.querySelector("#app")) {
    app.mount("#app");
} else {
    console.error(
        "❌ ERROR: No se encontró el div con id 'app'. Asegúrate de que existe en tu HTML."
    );
}