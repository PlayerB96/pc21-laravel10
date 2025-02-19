<template>
    <div class="container">
      <h1>Bienvenido a la Inducción</h1>
      <h3>
        Una vez que finalice el video, se habilitará una encuesta para evaluar tu experiencia. ¡Gracias por tu
        participación!
      </h3>
  
      <div class="video-container">
        <video id="induccionVideo" class="video" controls @ended="mostrarContenido">
          <source src="/assets/videos/induccion.mp4" type="video/mp4" />
          Tu navegador no soporta el video.
        </video>
      </div>
  
      <div v-show="contenidoVisible" class="content-section">
        <button @click="descargarManual" class="btn btn-download">Descargar Manual</button>
        <button @click="continuar" class="btn btn-continue">Continuar</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        contenidoVisible: true,
      };
    },
    methods: {
      mostrarContenido() {
        this.contenidoVisible = true;
      },
      descargarManual() {
        window.location.href = "/ruta/al/manual.pdf"; // Reemplaza con la URL real del manual
      },
      continuar() {
        this.$router.push("/induccion/formulario_induccion"); // Ajusta según tu configuración de rutas en Vue Router
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    text-align: center;
  }
  
  h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
  }
  
  .video-container {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
  }
  
  .video {
    width: 100%;
    max-width: 900px;
    border: 1px solid #e0e0e0;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .content-section {
    margin-top: 1.5rem;
  }
  
  .btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.375rem;
    text-decoration: none;
    transition: background-color 0.3s ease;
    cursor: pointer;
    border: none;
  }
  
  .btn-download {
    background-color: #1d4ed8;
    color: white;
  }
  
  .btn-download:hover {
    background-color: #2563eb;
  }
  
  .btn-continue {
    background-color: #10b981;
    color: white;
    margin-top: 1rem;
  }
  
  .btn-continue:hover {
    background-color: #059669;
  }
  </style>
  