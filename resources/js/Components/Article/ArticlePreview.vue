<script setup>
defineProps({
    article: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <h1 class="text-2xl font-semibold">{{ article.title }}</h1>

    <div class="mt-2 flex flex-row justify-between text-sm text-gray-900/50">
        <p>
            {{ article.created_at.formatted }} | Written by
            {{ article.author }}
        </p>
        <p>
            <span
                class="rounded-lg px-2 py-1 text-xs font-semibold"
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
</template>
