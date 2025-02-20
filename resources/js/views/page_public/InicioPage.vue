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
            <div class="container text-center">
                <h2 class="fw-bold">{{ section.title }}</h2>
                <p>{{ section.description }}</p>
                <a :href="'https://www.google.com'" target="_blank" class="btn-primary">Ir a Sitio</a>
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
            // sections: [
            //     { id: 'ecommerce', title: 'Ecommerce', description: 'Compra fácil...', background: '/assets/imgs/ecommerce_ln1.jpg' },
            //     { id: 'identidadcorporativa', title: 'Identidad Corporativa', description: 'Nuestra identidad...', background: '/assets/imgs/identidad_ln1.jpg' },
            //     { id: 'empresas', title: 'Empresas', description: 'Colaboramos con grandes marcas...', background: '/assets/imgs/empresa1_ln1.jpg' },
            //     { id: 'productos', title: 'Productos', description: 'Descubre nuestra variedad...', background: '/assets/imgs/productos_ln1.jpg' },
            //     { id: 'blog', title: 'Blog', description: 'Últimas noticias...', background: '/assets/imgs/blog1_ln1.jpg' }
            // ]
        };
    },
    mounted() {
        window.addEventListener('scroll', this.updateBackground);
        this.updateBackground(); // Llamar al cargar la página
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.updateBackground);
    },
    methods: {
        updateBackground() {
            requestAnimationFrame(() => {
                this.sections.forEach(section => {
                    const sectionElement = document.getElementById(section.id);
                    if (sectionElement) {
                        const { top, bottom } = sectionElement.getBoundingClientRect();
                        if (top < window.innerHeight / 2 && bottom > window.innerHeight / 2) {
                            this.currentBackground = section.background;
                        }
                    }
                });
            });
        }
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

.content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-align: center;
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
}
</style>
