<template>
    <div>
        <!-- Fondo del video -->
        <section id="inicio" class="video-background-container">
            <div class="gradient-overlay"></div>
            <video autoplay loop muted class="video-background">
                <source :src="videoSrc" type="video/mp4">
            </video>
            <div class="content">
            </div>
        </section>
        <!-- Secciones -->
        <section id="ecommerce" class="section">
            <h2>Ecommerce</h2>
            <p>Explora nuestra plataforma de comercio electrónico.</p>
        </section>

        <section id="identidadcorporativa" class="section">
            <h2>Identidad Corporativa</h2>
            <p>Descubre nuestra imagen y valores de marca.</p>
        </section>

        <section id="empresas" class="section">
            <h2>Empresas</h2>
            <p>Conoce nuestras empresas y aliados estratégicos.</p>
        </section>

        <section id="productos" class="section">
            <h2>Productos</h2>
            <p>Explora nuestro catálogo de productos.</p>
        </section>

        <section id="blog" class="section">
            <h2>Blog</h2>
            <p>Lee nuestros artículos y novedades.</p>
        </section>
    </div>
</template>

<script>
export default {
    name: "InicioPage",
    data() {
        return {
            videoSrc: '/assets/videos/RETAIL_LN1.mp4',
        };
    },
    mounted() {
        const userSession = localStorage.getItem('userSession');
        if (userSession) {
            this.$router.push('/home'); // Redirigir a la vista de inicio si no hay sesión
        }
    },
    methods: {
        handleButtonClick() {
            alert("Botón de ejemplo clickeado");
        }
    }
};
</script>

<style scoped>
/* Estilos de la página */
.video-background-container {
    position: relative;
    width: 100%;
    height: calc(100vh - 80px);
    /* Ajusta 80px según la altura del navbar */
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
}

.content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-align: center;
}

/* Secciones */
.section {
    padding: 100px 20px;
    text-align: center;
    background: #f4f4f4;
    margin-bottom: 20px;
    min-height: 50rem;
}

.section:nth-child(even) {
    background: #ddd;
}

.section h2 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.section p {
    font-size: 1.2rem;
}
</style>
