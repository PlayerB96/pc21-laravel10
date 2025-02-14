<template>
  <div class="main">
    <navbar @update-active-section="updateActiveSection"></navbar>

    <div id="main-content" class="main-content" :class="{ 'no-padding': activeSection === 'inicio' }">
      <router-view></router-view>
    </div>

    <footer>
      <footer-component></footer-component>
    </footer>
  </div>
</template>

<script>
import Navbar from './Navbar.vue';
import FooterComponent from './FooterComponent.vue';

export default {
  name: 'MainComponent',
  components: {
    Navbar,
    FooterComponent
  },
  data() {
    return {
      activeSection: "" // Guardará la sección activa
    };
  },
  methods: {
    updateActiveSection(section) {
      this.activeSection = section;
    }
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
  padding: 5rem 2rem;
}

.main-content.no-padding {
  padding: 0;
  /* Quita el padding cuando se está en la sección "Inicio" */
}

footer {
  margin-top: auto;
}
</style>
