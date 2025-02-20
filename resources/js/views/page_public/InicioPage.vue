<template>
    <div>
        <!-- Fondo del video en la sección de inicio -->
        <section id="inicio" class="video-background-container">
            <div class="gradient-overlay"></div>
            <video autoplay loop muted class="video-background">
                <source src="/assets/videos/RETAIL_LN1.mp4" type="video/mp4">
            </video>
        </section>
        
        <!-- Fondo dinámico -->
        <div class="dynamic-background" :style="{ backgroundImage: `url(${currentBackground})`, transition: 'background-image 1s ease-in-out' }"></div>
        
        <!-- Contenido de la página -->
        <section v-for="(section, index) in sections" :key="index" :id="section.id" class="section">
            <div class="container text-center d-flex align-items-center">
                <div class="text-content">
                    <h2 class="fw-bold">{{ section.title }}</h2>
                    <p>{{ section.description }}</p>
                    <a :href="'https://www.google.com'" target="_blank" class="btn-primary">Ir a Sitio</a>
                </div>
                <div class="image-content">
                    <img src="/assets/imgs/ilustrationln1.png" alt="Illustration" class="illustration">
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
            currentBackground: '/assets/imgs/default.jpg', // Imagen por defecto
            sections: [
                { id: 'ecommerce', title: 'Ecommerce', description: 'Compra fácil...' },
                { id: 'identidadcorporativa', title: 'Identidad Corporativa', description: 'Nuestra identidad...' },
                { id: 'empresas', title: 'Empresas', description: 'Colaboramos con grandes marcas...' },
                { id: 'productos', title: 'Productos', description: 'Descubre nuestra variedad...' },
                { id: 'blog', title: 'Blog', description: 'Últimas noticias...' }
            ]
        };
    }
};
</script>

<style scoped>
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
}

.dynamic-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    z-index: -1;
}

.section {
    padding: 100px 50px;
    text-align: center;
    min-height: 100vh;
    background: rgba(255, 255, 255, 0.505);
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    width: 100%;
}

.text-content {
    flex: 1;
    text-align: left;
}

.image-content {
    flex: 1;
    text-align: right;
}

.illustration {
    max-width: 300px;
    height: auto;
}
</style>
