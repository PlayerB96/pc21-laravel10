<template>
  <div class="container servicios-container">

    <!-- Imagen de Servicios -->
    <img src="/assets/imgs/st4_servicios.jpg" alt="Servicios" class="img-fluid rounded mb-4" />

    <h1 class="text-success mb-4">Servicios</h1>

    <ul class="list-group servicios-list">
      <li class="list-group-item">
        ✅ Venta de laptops, computadoras, tablets, televisores, partes y accesorios
      </li>
      <li class="list-group-item">
        ✅ Servicio técnico en hardware y software
      </li>
      <li class="list-group-item">
        ✅ Diseño gráfico, web y multimedia
      </li>
      <li class="list-group-item">
        ✅ Asesoría en proyectos de tecnología
      </li>
    </ul>

  </div>
</template>

<style scoped>
.servicios-container {
  display: flex;
  flex-direction: column;
  align-items: center;     /* centra horizontal */
  text-align: left;        /* texto alineado a la izquierda */
}

.servicios-list {
  width: 600px;            /* ancho fijo para toda la lista */
  max-width: 90%;          /* en móviles no se pasa de la pantalla */
  font-size: 1.8rem;
  font-weight: 500;
}

.servicios-list .list-group-item {
  border: none;
  background: transparent;
}
</style>