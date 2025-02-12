<template>
    <div class="skeleton-loader">
        <div class="skeleton-row" v-for="n in rows" :key="n">
            <div v-if="n === 1" class="skeleton-cell first-row"></div>
            <div v-if="n === 1" class="skeleton-cell first-row"></div>
            <div v-else class="skeleton-cell" v-for="i in columns" :key="i"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SkeletonLoaderTable",
    props: {
        rows: {
            type: Number,
            default: 10 // 🔥 Número de filas por defecto
        },
        columns: {
            type: Number,
            default: 5 // 🔥 Número de columnas por defecto
        }
    }
};
</script>

<style scoped>
/* 📌 Estilos para Skeleton Loader */
.skeleton-loader {
    margin: 1rem 0;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.skeleton-row {
    display: flex;
    gap: 10px;
}

.skeleton-cell {
    flex: 1;
    height: 40px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    border-radius: 4px;
}

.first-row {
    flex: 0 0 35%; /* Ajusta el tamaño para que haya más espacio en medio */
    margin-right: 40%; /* Añade espacio en el medio */
}

@keyframes skeleton-loading {
    0% {
        background-position: 200% 0;
    }

    100% {
        background-position: -200% 0;
    }
}
</style>