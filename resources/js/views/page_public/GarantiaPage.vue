<!-- resources/js/views/InicioPage.vue -->
<template>
    <div class="p-4"> <!-- padding agregado -->
        <h1>GARANTIA</h1>
        
        <!-- Datos en duro -->
        <div class="mt-3">
            <p><strong>ID Garantía:</strong> 12345</p>
            <p><strong>Cliente:</strong> Juan Pérez</p>
            <p><strong>Producto:</strong> Laptop Modelo X</p>
            <p><strong>Estado:</strong> En proceso</p>
            <p><strong>Fecha de emisión:</strong> 26/08/2025</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'GarantiaPage',
};
</script>

<style scoped>
/* Opcional: agregar algo de estilo adicional */
p {
    margin: 0.25rem 0;
}
</style>
