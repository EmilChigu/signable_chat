<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({ errors: Object });
const emit = defineEmits(['sent']);
interface IChatMessageForm {
    message: string;
}

const form = useForm<IChatMessageForm>({
    message: '',
});

const isValid = computed(() => form.message && form.message.length >= 1);

function submit() {
    form.post('/chat', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('sent');
        },
    });
}
</script>

<template>
    <div class="w-full max-w-2xl rounded-b-base bg-white p-5 shadow-lg sm:p-8">
        <form @submit.prevent="submit" class="space-y-6">
            <div class="flex items-center gap-3">
                <textarea type="text" class="min-h-[100px] input flex-1 rounded-base py-2" autofocus v-model="form.message" id="message" />
                <button type="submit" class="btn-primary h-16 w-16 rounded-full" :disabled="form.processing || !isValid">Send</button>
            </div>
            <div v-if="errors?.message" class="mt-2 px-1 text-sm font-medium text-error">
                {{ errors.message }}
            </div>
        </form>
    </div>
</template>

<style scoped></style>