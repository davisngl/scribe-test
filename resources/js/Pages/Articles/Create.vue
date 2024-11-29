<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { isIn, isMax, isMin, isRequired } from 'intus/rules';
import intus from 'intus';

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
    title: '',
    status: '',
    description: '',
});

const submit = () => {
    const validation = intus.validate(form.data(), {
        title: [isRequired(), isMin(3), isMax(255)],
        status: [isRequired(), isIn('published', 'draft', 'archived')],
        description: [isRequired(), isMin(10), isMax(65535)],
    });

    if (validation.passes()) {
        form.post(route('articles.store', props.article));
    } else {
        form.setError(validation.errors());
    }
};

const navigateBack = () => {
    if (form.isDirty) {
        if (confirm('Are you sure you want to leave? Changes will be lost')) {
            // Only issue is that if full page reload has happened on "edit" page
            // there's no browser history to navigate "back to".
            // Unlikely in usage but a bug.
            router.visit(route('articles.index'));
        }
    } else {
        router.visit(route('articles.index'));
    }
};
</script>

<template>
    <Head>
        <title>New Article</title>
    </Head>

    <button @click="navigateBack" class="mb-3 text-sm text-gray-700 underline">
        &laquo; Go Back
    </button>

    <form class="flex flex-col space-y-2" @submit.prevent="submit" novalidate>
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
            <PrimaryButton>Create Article</PrimaryButton>
        </div>
    </form>
</template>
