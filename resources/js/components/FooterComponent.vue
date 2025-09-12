<template>
    <footer class="footer">
        <div class="footer-content">
            <!-- Sección Izquierda: Redes Sociales -->
            <div class="footer-section">
                <h3>Contacto</h3>
                <div class="social-links">
                    <a href="https://www.facebook.com/people/Pc21-Laptops/100054459159404/?sk=about_contact_and_basic_info"
                        class="social-link">
                        Facebook
                    </a>
                
                    <a href="https://wa.me/51986514012" target="_blank" class="social-link flex">
                        <!-- Icono de WhatsApp con Lucide -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp"
                            width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 0.9z" />
                            <path d="M9 10a1 1 0 0 0 0 2c.5 1 .5 1.5 1.5 2c1 .5 1.5 .5 2.5 0a1 1 0 0 0 0 -2" />
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>


            <!-- Sección Centro: Formas de Pago + QR + Horario -->
            <!-- <div class="footer-section">
                <h3>Formas de Pago</h3>
                <img src="/assets/imgs/YAPE-QR.webp" alt="QR Plin/Yape" class="qr-code" />
                <p>Escanea el código para pagar con Plin o Yape</p>
                <h4>Horario de Atención</h4>
                <p>Lunes a Sábado: 9:00 AM - 6:00 PM</p>
                <p>Domingo: Cerrado</p>
            </div> -->

            <!-- Sección Derecha: Ubicación -->
            <div class="footer-section">
                <h3>Ubicación</h3>
                <p>1-Lima</p>
                <p>2-Huancayo, Perú</p>
                <p>Dirección: Av. Principal 123</p>
                <p>Teléfono: +51 986 514 012</p>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'FooterComponent'
};
</script>

<style scoped>
.footer {
    background-color: var(--dark-secondary-bg);
    color: #fff;
    padding: 20px 0;
    text-align: center;
    width: 100%;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    text-align: left;
}

.footer-section {
    flex: 1;
    min-width: 280px;
    padding: 10px;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.social-link {
    color: #fff;
    text-decoration: none;
    font-size: 14px;
}

.social-link:hover {
    text-decoration: underline;
    color: #f1c40f;
}

.qr-code {
    width: 120px;
    height: 120px;
    margin: 10px 0;
}

/* Estilos responsivos */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}
</style>
