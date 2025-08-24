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
        <!-- <section id="productos" class="section productos">
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
        </section> -->
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">📋 Tickets</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-300 shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="px-4 py-2 border border-gray-300">ID</th>
                            <th class="px-4 py-2 border border-gray-300">Nombre Completo</th>
                            <th class="px-4 py-2 border border-gray-300">Teléfono</th>
                            <th class="px-4 py-2 border border-gray-300">Fecha de Registro</th>
                            <th class="px-4 py-2 border border-gray-300">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ticket in tickets" :key="ticket.id" class="hover:bg-gray-100">
                            <td class="px-4 py-2 border border-gray-300">{{ ticket.id }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ ticket.nombre_completo }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ ticket.telefono }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ ticket.created_at }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ ticket.estado }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Sección de Garantía -->
        <!-- <section id="garantia" class="section garantia">
            <div class="container text-center">
                <h2 class="fw-bold">Nuestra Garantía</h2>
                <p>Garantizamos la mejor calidad y servicio para nuestros clientes.</p>
            </div>
        </section> -->
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "InicioPage",
    data() {
        return {
            productos: [
                { nombre: 'Laptop Lenovo', precio: 750, imagen: '/assets/imgs/laptop1.jpg' },
                { nombre: 'Mouse Gamer', precio: 50, imagen: '/assets/imgs/mouse.jpg' },
                { nombre: 'Teclado Mecánico', precio: 100, imagen: '/assets/imgs/laptop.jpeg' },
                { nombre: 'Monitor 27"', precio: 300, imagen: '/assets/imgs/monitor.jpeg' }
            ],
            tickets: []

        };
    },
    mounted() {
        this.fetchTickets();
    },
    methods: {
        async fetchTickets() {
            try {
                const response = await axios.get('/tickets');
                console.log(response)
                this.tickets = response.data;
            } catch (error) {
                console.error('Error al obtener los tickets:', error);
            }
        }
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