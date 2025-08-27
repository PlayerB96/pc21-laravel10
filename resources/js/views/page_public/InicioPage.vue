<template>
    <div>
        <!-- Sección Hero con imagen de fondo -->
        <section id="inicio" class="position-relative vh-100 d-flex align-items-center justify-content-center overflow-hidden">
            <!-- Overlay gradient -->
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
            
            <!-- Imagen de fondo -->
            <img src="/assets/imgs/pexels-cookiecutter-1148820.jpg" 
                 alt="PC 21 Logo" 
                 class="position-absolute top-0 start-0 w-100 h-50 object-fit-cover" 
                 style="z-index: -1;" />
            
            <!-- Contenido principal -->
            <div class="position-relative text-center text-white z-3">
                <h1 class="display-1 fw-bold mb-4">PC 21</h1>
                <p class="lead fs-4">Innovación y excelencia en cada proyecto</p>
                <a href="#vision" class="btn btn-primary btn-lg mt-3">Conoce más</a>
            </div>
        </section>

       
        <!-- Sección de Tickets (Tabla mejorada con Bootstrap) -->
        <section class="py-5 bg-white">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="display-5 fw-bold text-center text-primary mb-5">
                            <i class="bi bi-ticket-perforated me-2"></i>Tickets de Soporte
                        </h2>
                        
                        <div class="card shadow">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="px-4 py-3">ID</th>
                                                <th class="px-4 py-3">Nombre Completo</th>
                                                <th class="px-4 py-3">Teléfono</th>
                                                <th class="px-4 py-3">Fecha de Registro</th>
                                                <th class="px-4 py-3">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ticket in tickets" :key="ticket.id">
                                                <td class="px-4 py-3 fw-bold">{{ ticket.id }}</td>
                                                <td class="px-4 py-3">{{ ticket.nombre_completo }}</td>
                                                <td class="px-4 py-3">
                                                    <a :href="'tel:' + ticket.telefono" class="text-decoration-none">
                                                        {{ ticket.telefono }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <small class="text-muted">{{ ticket.created_at }}</small>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="badge" 
                                                          :class="{
                                                              'bg-success': ticket.estado === 'Completado',
                                                              'bg-warning': ticket.estado === 'En Proceso',
                                                              'bg-danger': ticket.estado === 'Pendiente',
                                                              'bg-secondary': ticket.estado === 'Cancelado'
                                                          }">
                                                        {{ ticket.estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr v-if="tickets.length === 0">
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                                    No hay tickets disponibles
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección comentada de Productos (Carousel Bootstrap) -->
        <!-- <section id="productos" class="py-5 bg-light">
            <div class="container-fluid text-center">
                <h2 class="display-4 fw-bold text-primary mb-5">Nuestros Productos</h2>
                <div id="productosCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item text-center" v-for="(producto, index) in productos" :key="index"
                            :class="{ 'active': index === 0 }">
                            <div class="d-flex justify-content-center">
                                <div class="card shadow" style="width: 20rem;">
                                    <img :src="producto.imagen" class="card-img-top" :alt="producto.nombre" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ producto.nombre }}</h5>
                                        <p class="card-text text-primary fs-5 fw-bold">${{ producto.precio }}</p>
                                        <a href="#" class="btn btn-primary">
                                            <i class="bi bi-cart-plus me-2"></i>Comprar
                                        </a>
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

        <!-- Sección comentada de Garantía -->
        <!-- <section id="garantia" class="py-5 bg-secondary bg-opacity-25">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="display-4 fw-bold text-primary mb-4">Nuestra Garantía</h2>
                        <p class="lead">Garantizamos la mejor calidad y servicio para nuestros clientes, 
                           respaldando cada proyecto con nuestro compromiso de excelencia.</p>
                    </div>
                </div>
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
/* Estilos mínimos para complementar Bootstrap 5 */

/* Hero section - imagen de fondo */
#inicio {
    background: linear-gradient(135deg, rgba(0, 123, 255, 0.8), rgba(0, 0, 0, 0.6));
    min-height: 100vh;
}

/* Efecto parallax opcional */
#inicio img {
    transform: translateZ(-1px) scale(1.1);
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Ajustes para el spacing de Bootstrap */
section {
    scroll-margin-top: 80px; /* Para compensar la navbar fija */
}

/* Hover effects para badges */
.badge:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}

/* Card hover effects */
.card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}

/* Table hover enhancement */
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.1) !important;
}

/* Custom badge colors for status */
.badge.bg-success { background-color: #198754 !important; }
.badge.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
.badge.bg-danger { background-color: #dc3545 !important; }
.badge.bg-secondary { background-color: #6c757d !important; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .display-1 {
        font-size: 2.5rem;
    }
    
    .display-4 {
        font-size: 2rem;
    }
    
    #inicio {
        min-height: 70vh;
    }
}
</style>