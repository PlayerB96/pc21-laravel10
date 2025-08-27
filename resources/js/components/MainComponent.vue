<template>
  <div class="main">
    <navbar @update-active-section="updateActiveSection"></navbar>

    <div id="main-content" class="main-content">
      <router-view></router-view>
    </div>

    <footer>
      <footer-component></footer-component>
    </footer>
  </div>
  <floating-button />
</template>

<script>
import Navbar from './Navbar.vue';
import FooterComponent from './FooterComponent.vue';
import FloatingButton from './FloatingButton.vue';

export default {
  name: 'MainComponent',
  components: {
    Navbar,
    FooterComponent,
    FloatingButton
  },
  data() {
    return {
      activeSection: "",
      isChatbotOpen: false
    };
  },
  methods: {
    updateActiveSection(section) {
      this.activeSection = section;
    },
    toggleChatbot() {
      this.isChatbotOpen = !this.isChatbotOpen;
    }
  },
  mounted() {
    console.log('Router:', this.$router);
  }

};
</script>

<style scoped>
.main {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex-grow: 1;
  padding: 3rem;
}

footer {
  margin-top: auto;
}

/* Estilos del botón flotante */
.chatbot-button {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  font-size: 24px;
  cursor: pointer;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

/* Contenedor del chatbot */
.chatbot-container {
  position: fixed;
  bottom: 80px;
  right: 20px;
  width: 300px;
  background: white;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
  padding: 10px;
  display: flex;
  flex-direction: column;
}

/* Botón de cerrar */
.close-button {
  position: absolute;
  top: 5px;
  right: 5px;
  background: red;
  color: white;
  border: none;
  border-radius: 50%;
  width: 25px;
  height: 25px;
  font-size: 16px;
  cursor: pointer;
}
</style>