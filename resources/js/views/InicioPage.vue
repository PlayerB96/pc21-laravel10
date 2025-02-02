<template>
    <div>
        <!-- Fondo del video -->
        <section class="video-background-container">
            <div class="gradient-overlay"></div>
            <video autoplay loop muted class="video-background">
                <source :src="videoSrc" type="video/mp4">
            </video>
            <!-- Contenido sobre el video -->
            <div class="content">
                <!-- Aquí puedes agregar más contenido si lo deseas -->
            </div>
        </section>

        <button class="button px-4 py-2 rounded mt-6" @click="handleButtonClick">Botón de ejemplo</button>

        <!-- Servicios -->
        <section class="services mt-10">
            <div class="container mx-auto">
                <div class="service-cards real-content hidden" id="real-content">
                    <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                        <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                        <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
                    </div>
                    <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                        <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                        <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
                    </div>
                    <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                        <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                        <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "InicioPage",
    data() {
        return {
            videoSrc: '/assets/videos/induccion.mp4', // Ruta del video
        };
    },
    methods: {
        handleButtonClick() {
            // Aquí puedes agregar la lógica para el botón
            alert("Botón de ejemplo clickeado");
        },
    },
};
</script>



<style scoped>
/* Estilos locales si los necesitas */
.video-background-container {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.video-background {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
}

.gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    /* Gradiente oscuro */
}

.content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-align: center;
}

.services .service-cards {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.card {
    width: 300px;
    text-align: center;
}

.card h3 {
    font-size: 1.5rem;
}

.card p {
    font-size: 1rem;
}
</style>