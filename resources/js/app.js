import { createApp } from "vue";
import MainComponent from "./components/MainComponent.vue";
import Navbar from "./components/Navbar.vue";
import FooterComponent from "./components/FooterComponent.vue";
import Chatbot from "./components/Chatbot.vue";
import router from "./router";

// document.addEventListener("DOMContentLoaded", () => {
const app = createApp(MainComponent);

app.component("main-component", MainComponent);
app.component("navbar", Navbar);
app.component("footer-component", FooterComponent);
app.component("chatbot", Chatbot);

app.use(router);

if (document.querySelector("#app")) {
    app.mount("#app");
} else {
    console.error(
        "❌ ERROR: No se encontró el div con id 'app'. Asegúrate de que existe en tu HTML."
    );
}
// });
