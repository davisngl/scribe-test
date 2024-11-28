<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    articles: { type: Object },
});

const deleteArticle = (article) => {
    router.delete(route('articles.destroy', article), {
        onBefore: () =>
            confirm('Are you sure you want to delete this article?'),
    });
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

        <div class="mt-2 flex flex-row justify-between text-sm text-gray-900/50">
            <p>
                {{ article.created_at.formatted }} | Written by
                {{ article.author }}
            </p>
            <p>
                <span
                    class="rounded-lg px-2 py-1"
                    :class="{
                        'bg-green-200 text-green-800':
                            article.status === 'published',
                        'bg-red-200 text-red-800': article.status === 'draft',
                        'bg-yellow-200 text-yellow-800':
                            article.status === 'archived',
                    }"
                >
                    {{ article.status.toUpperCase() }}
                </span>
            </p>
        </div>
    </Link>
</template>
