<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineOptions({
    layout: AuthenticatedLayout,
});

const props = defineProps({
    article: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.article.title,
    status: props.article.status,
    description: props.article.description,
});

const submit = () => {
    form.patch(route('articles.update', props.article));
};
</script>

<template>
    <form class="flex flex-col space-y-2" @submit.prevent="submit">
        <div>
            <InputLabel for="title" value="Article Title" />
            <TextInput
                class="mt-1 block w-full"
                id="title"
                type="text"
                required
                autofocus
                v-model="form.title"
            />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div>
            <InputLabel for="status" value="Status" />
            <select
                class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                id="status"
                v-model="form.status"
            >
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
            <InputError class="mt-2" :message="form.errors.status" />
        </div>

        <div>
            <InputLabel for="description" value="Content" />
            <TextArea
                class="mt-1 block w-full"
                rows="20"
                id="description"
                required
                v-model="form.description"
            />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div class="flex justify-end">
            <PrimaryButton>Save Article</PrimaryButton>
        </div>
    </form>
</template>
