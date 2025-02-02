// resources/js/app.js
import { createApp } from "vue"; // Importar Vue
import MainComponent from "./components/MainComponent.vue"; // Importar tu componente principal
import Navbar from "./components/Navbar.vue"; // Importar Navbar
import FooterComponent from "./components/FooterComponent.vue"; // Importar Footer
import Chatbot from "./components/Chatbot.vue"; // Importar Chatbot
import router from "./router"; // Importamos el router

// Crear la aplicación Vue
const app = createApp(MainComponent); // Iniciar la app con el componente principal

// Registrar los componentes globalmente
app.component("main-component", MainComponent);
app.component("navbar", Navbar);
app.component("footer-component", FooterComponent);
app.component("chatbot", Chatbot);

// Usar el router
app.use(router);
// Montar la aplicación Vue en el contenedor con id "app"
app.mount("#app");
