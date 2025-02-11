<template>
    <div class="skeleton-loader">
        <div class="skeleton-row" v-for="n in rows" :key="n"></div>
    </div>
</template>

<script>
export default {
    name: "SkeletonLoaderTable",
    props: {
        rows: {
            type: Number,
            default: 10 // 🔥 Número de filas por defecto
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
    width: 100%;
    height: 40px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    border-radius: 4px;
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
