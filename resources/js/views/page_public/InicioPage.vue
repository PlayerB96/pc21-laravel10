<template>
    <div>
        <!-- Fondo del video en la sección de inicio -->
        <section id="inicio" class="video-background-container">
            <div class="gradient-overlay"></div>
            <img src="/assets/imgs/pexels-cookiecutter-1148820.jpg" alt="Grupo LN1 Logo" class="logo" />
        </section>

        <!-- Sección de Visión -->
        <section id="vision" class="section vision">
            <div class="container text-center">
                <h2 class="fw-bold">Nuestra Visión</h2>
                <p>Nos esforzamos por ser líderes en innovación y servicio al cliente.</p>
            </div>
        </section>

        <!-- Sección de Servicios -->
        <section id="servicios" class="section servicios">
            <div class="container text-center">
                <h2 class="fw-bold">Nuestros Servicios</h2>
                <p>Ofrecemos una amplia gama de servicios para satisfacer tus necesidades.</p>
                <img src="/assets/imgs/identidad.jpg" alt="Servicios" class="illustration">
            </div>
        </section>

        <!-- Sección de Productos -->
        <section id="productos" class="section productos">
            <div class="container-fluid text-center">
                <h2 class="fw-bold mb-4">Nuestros Productos</h2>
                <div id="productosCarousel" class="carousel slide w-100" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item text-center" v-for="(producto, index) in productos" :key="index"
                            :class="{ 'active': index === 0 }">
                            <div class="d-flex justify-content-center">
                                <div class="card" style="width: 18rem;">
                                    <img :src="producto.imagen" class="card-img-top" :alt="producto.nombre">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ producto.nombre }}</h5>
                                        <p class="card-text">Precio: ${{ producto.precio }}</p>
                                        <a href="#" class="btn btn-primary">Comprar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productosCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productosCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Sección de Garantía -->
        <section id="garantia" class="section garantia">
            <div class="container text-center">
                <h2 class="fw-bold">Nuestra Garantía</h2>
                <p>Garantizamos la mejor calidad y servicio para nuestros clientes.</p>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "InicioPage",
    data() {
        return {
            productos: [
                { nombre: 'Laptop Lenovo', precio: 750, imagen: '/assets/imgs/laptop1.jpg' },
                { nombre: 'Mouse Gamer', precio: 50, imagen: '/assets/imgs/mouse.jpg' },
                { nombre: 'Teclado Mecánico', precio: 100, imagen: '/assets/imgs/laptop.jpeg' },
                { nombre: 'Monitor 27"', precio: 300, imagen: '/assets/imgs/monitor.jpeg' }
            ]
        };
    }
};
</script>

<style scoped>
.section {
    padding: 50px 0;
    text-align: center;
}

.vision {
    background-color: #f8f9fa;
}

.servicios {
    background-color: #e9ecef;
}

.garantia {
    background-color: #dee2e6;
}

.illustration {
    max-width: 100%;
    height: auto;
    margin-top: 20px;
}
</style>