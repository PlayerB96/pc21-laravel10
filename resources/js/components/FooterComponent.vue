<template>
    <footer class="footer">
        <div class="footer-content">
            <p>© 2025 Mi Empresa. Todos los derechos reservados.</p>
            <div class="social-links">
                <a href="#" class="social-link">Facebook</a>
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">Instagram</a>
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
/* Estilos del pie de página */
.footer {
    background-color: var(--dark-secondary-bg);
    color: #fff;
    padding: 20px 0;
    text-align: center;
    position: relative;
    bottom: 0;
    width: 100%;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
}

.social-links {
    margin-top: 10px;
}

.social-link {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    font-size: 14px;
}

.social-link:hover {
    text-decoration: underline;
    color: #f1c40f;
}
</style>