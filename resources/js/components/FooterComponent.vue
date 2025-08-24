<template>
    <footer class="footer">
        <div class="footer-content">
            <!-- Sección Izquierda: Redes Sociales -->
            <div class="footer-section">
                <h3>Redes Sociales</h3>
                <div class="social-links">
                    <a href="https://www.facebook.com/PC21GT" class="social-link">Facebook</a>
                    <a href="#" class="social-link">Twitter</a>
                    <a href="#" class="social-link">Instagram</a>
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
                <p>Huancayo, Perú</p>
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
