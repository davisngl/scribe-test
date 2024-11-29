<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import { computed, ref, watch } from 'vue';
import SimplePaginator from '@/Components/Pagination/SimplePaginator.vue';
import ArticlePreview from '@/Components/Article/ArticlePreview.vue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    articles: { type: Object },
    existingFilters: { type: Object },
});

const filters = ref({
    status: props.existingFilters.status ?? 'any',
    date: props.existingFilters.date ?? '',
    sortDirection: props.existingFilters.sortDirection ?? 'desc',
});

const articleCount = computed(() => usePage().props.articles.data.length);

watch(
    filters,
    (filters) => {
        router.get(
            route('articles.index'),
            {
                status: filters.status,
                date: filters.date,
                sortDirection: filters.sortDirection,
            },

            {
                preserveState: true,
                only: ['articles'],
            },
        );
    },
    { deep: true },
);

const resetFilters = () => {
    filters.value = {
        status: 'any',
        date: '',
        sortDirection: 'desc',
    };
};
</script>

<template>
    <Head>
        <title>Blog</title>
    </Head>

    <div class="mb-5 inline-flex space-x-2 rounded-md border p-3">
        <div>
            <InputLabel id="status" label="Filter By Status" />
            <select
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                v-model="filters.status"
            >
                <option value="any">All</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
        </div>

        <div>
            <InputLabel id="date" label="Filter By Status" />
            <input
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                id="date"
                v-model="filters.date"
                type="date"
            />
        </div>

        <div>
            <InputLabel id="sort-direction" label="Sort Direction" />
            <select
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                id="sort-direction"
                v-model="filters.sortDirection"
            >
                <option value="desc">Descending</option>
                <option value="asc">Ascending</option>
            </select>
        </div>

        <div class="flex items-center">
            <button
                class="rounded-md px-2 py-1 transition-colors hover:bg-gray-100"
                @click="resetFilters"
                type="button"
            >
                Reset Filters
            </button>
        </div>
    </div>

    <main v-if="articleCount > 0">
        <Link
            :href="route('articles.show', article)"
            class="mb-3 block cursor-pointer rounded-lg p-5 transition-all duration-150 hover:bg-gray-100"
            v-for="article in articles.data"
            :key="article.id"
        >
            <ArticlePreview :article="article" />
        </Link>

        <SimplePaginator :pagination="articles.links" :only="['articles']" />
    </main>

    <div v-else>
        <span class="opacity-40">No articles found</span>
    </div>
</template>
