<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';
import intus from 'intus';
import { isIn, isRequired } from 'intus/rules';

defineProps({
    countries: {
        type: Array,
        required: true,
    },
});

const country = ref('');
const languages = ref([]);
const notification = useToast();

const form = useForm({
    name: '',
    email: '',
    country: '',
    language: '',
    password: '',
    password_confirmation: '',
});

watch(
    country,
    (country) => {
        form.country = country;

        axios
            .post(route('countries.get-languages'), { country })
            .then(({ data }) => languages.value = data)
            .catch(({ response }) => notification.error(response.data.message));
    },
    { deep: true },
);

const submit = () => {
    const validation = intus.validate(form.data(), {
        country: [isRequired(), isIn(...usePage().props.countries)],
        language: [isRequired()],
    });

    if (validation.passes()) {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    } else {
        form.setError(validation.errors());
    }
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="country" value="Country" />

                <select
                    id="country"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="country"
                    required
                >
                    <option value="">Select Country</option>
                    <option :value="country" v-for="country in countries">
                        {{ country }}
                    </option>
                </select>

                <InputError class="mt-2" :message="form.errors.country" />
            </div>

            <div class="mt-4">
                <InputLabel for="language" value="Country" />

                <select
                    id="language"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="form.language"
                    required
                >
                    <option value="">Select Language</option>
                    <template v-if="languages.length">
                        <option
                            :value="language"
                            v-for="language in languages"
                        >{{ language }}</option>
                    </template>
                </select>

                <InputError class="mt-2" :message="form.errors.language" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
