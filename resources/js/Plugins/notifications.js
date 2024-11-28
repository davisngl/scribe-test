import { useToast } from 'vue-toastification';
import { router, usePage } from '@inertiajs/vue3';
import "vue-toastification/dist/index.css"

const toast = useToast();

export const notifications = () => {
    router.on('finish', () => {
        const flashMessage = usePage().props.notification;

        if (flashMessage) {
            toast(flashMessage);
        }
    });
};
