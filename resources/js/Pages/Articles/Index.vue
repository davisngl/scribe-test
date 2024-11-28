<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    articles: { type: Object },
});

const deleteArticle = (article) => {
    router.delete(route('articles.destroy', article), {
        onBefore: () => confirm('Are you sure you want to delete this article?')
    })
};
</script>

<template>
    <Link
        :href="route('articles.show', article)"
        class="mb-3 block cursor-pointer rounded-lg p-5 transition-all duration-150 hover:bg-gray-100"
        v-for="article in articles.data"
        :key="article.id"
    >
        <h1 class="text-2xl font-semibold">{{ article.title }}</h1>
        <div class="flex flex-row justify-between text-sm text-gray-900/50">
            <p>{{ article.created_at.formatted }} | Written by {{ article.author }}</p>

            <div v-if="article.can.update">
                <Link
                    class="rounded-sm border px-2 py-1 text-gray-500 transition-colors hover:border-blue-600 hover:text-blue-600"
                    :href="route('articles.edit', article)"
                >Edit</Link>
            </div>

            <div v-if="article.can.delete">
                <button @click="deleteArticle(article)">Delete</button>
            </div>
        </div>
    </Link>
</template>
