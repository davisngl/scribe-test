<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    pagination: {
        type: Object,
        required: true,
    },
    only: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav class="relative flex items-center justify-between">
        <Link
            preserve-scroll
            :only="only"
            :href="pagination.prev ?? ''"
            class="flex items-center justify-center rounded-lg px-3 py-2 text-sm text-gray-800"
            :class="{
                'bg-gray-200': pagination.prev,
                '!text-gray-300': ! pagination.prev,
            }"
        >
            Previous
        </Link>

        <Link
            preserve-scroll
            :only="only"
            :href="pagination.next ?? ''"
            class="flex items-center justify-center rounded-lg px-3 py-2 text-sm text-gray-600"
            :class="{
                'bg-gray-200': pagination.next,
                '!text-gray-300': !pagination.next,
            }"
        >
            Next
        </Link>
    </nav>
</template>
