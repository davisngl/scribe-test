<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';

defineOptions({
    layout: AuthenticatedLayout,
});

defineProps({
    article: {
        type: Object,
    },
});

const deleteArticle = (article) => {
    router.delete(route('articles.destroy', article), {
        onBefore: () =>
            confirm('Are you sure you want to delete this article?'),
    });
};
</script>

<template>
    <Head>
        <title>{{ article.title }}</title>
    </Head>

    <Link
        :href="route('articles.index')"
        class="mb-3 block text-sm text-gray-700 underline"
    >
        &laquo; Go Back
    </Link>

    <h1 class="mb-1 text-3xl font-semibold">{{ article.title }}</h1>
    <div class="flex justify-between text-sm opacity-60">
        <span>Written By {{ article.author }}</span>
        <span>Published On {{ article.created_at.formatted }}</span>
    </div>

    <p class="prose mt-5">{{ article.description }}</p>

    <div class="mt-5 flex justify-end space-x-2">
        <Link
            v-if="article.can.update"
            class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
            :href="route('articles.edit', article)"
            >Edit</Link
        >

        <DangerButton v-if="article.can.delete" @click="deleteArticle(article)"
            >Delete</DangerButton
        >
    </div>
</template>
