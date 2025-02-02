<template>
  <div class="main">
    <!-- Navbar que se incluiría como un componente Vue -->
    <navbar></navbar>

    <!-- Contenido principal -->
    <div id="main-content" class="main-content">
      <router-view></router-view>
    </div>

    <!-- Footer -->
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
  }
};
</script>

<style scoped>
/* Estilos para el componente principal */
.main {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  /* Asegura que el contenedor ocupe toda la altura de la ventana */
}

.main-content {
  flex-grow: 1;
  /* Este es el contenedor principal que ocupará el espacio restante */
  padding: 0px;
}

footer {
  margin-top: auto;
  /* Esto empuja el footer al final */
}
</style>
