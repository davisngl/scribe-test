<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineOptions({
    layout: AuthenticatedLayout
});

defineProps({
    article: {
        type: Object,
    },
});

const deleteArticle = article => {
    if (confirm('Are you sure you want to delete this article?')) {
        router.delete(route('articles.destroy', article));
    }
};
</script>

<template>
    <h1 class="mb-1 text-3xl font-semibold">{{ article.title }}</h1>
    <div class="flex justify-between text-sm opacity-60">
        <span>Written By {{ article.author }}</span>
        <span>Published On {{ article.created_at.formatted }}</span>
    </div>

    <p class="prose mt-5">{{ article.description }}</p>

    <div class="flex justify-end space-x-2 mt-5">
        <Link
            v-if="article.can.update"
            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
            :href="route('articles.edit', article)"
        >Edit</Link>

        <DangerButton v-if="article.can.delete" @click="deleteArticle(article)">Delete</DangerButton>
    </div>
</template>
