<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({ errors: Object });

interface IJoinChatForm {
    username: string;
}

const form = useForm<IJoinChatForm>({
    username: '',
});

const isValid = computed(() => form.username && form.username.length > 3);

function submit() {
    router.post('/', {username:form.username});
}

</script>

<template>
    <Head title="Welcome | The Anonymous Team Chat" />
    <div class="flex h-screen items-center justify-center bg-chat-bg p-6">
        <div class="rounded-base bg-white p-5 shadow-lg sm:p-8">
            <div class="flex flex-col gap-3">
                <h1 class="text-center text-3xl font-bold">Signable Chat</h1>
                <p class="">Real-time vibes, someone will probably steal your cool username though.</p>
            </div>

            <div class="mt-6 sm:mt-12">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="mb-2"> What should we call you this time? </label>
                        <input type="text" placeholder="e.g. R2D2" class="input mt-3" autofocus v-model="form.username" id="username" />
                        <div v-if="errors?.username" class="mt-2 px-1 text-sm font-medium text-error">
                            {{ errors.username }}
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary" :disabled="form.processing || !isValid">Start Chatting</button>
                </form>
            </div>
        </div>
    </div>
</template>