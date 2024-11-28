<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    articles: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div v-for="article in articles.data" :key="article.id">{{article.title}}</div>
</template>

<style scoped></style>
