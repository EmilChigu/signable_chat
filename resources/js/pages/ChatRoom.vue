<script setup lang="ts">
import { Head, usePoll } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, ref } from 'vue';

import ChatBubbleComponent from '@/components/chat/ChatBubbleComponent.vue';
import ChatFormComponent from '@/components/chat/ChatFormComponent.vue';

const props = defineProps<{
    auth: {
        username: string;
    };
    messages: {
        data: Array<{
            id: number;
            message: string;
            username: string;
            created_at: string;
        }>;
    };
}>();

const sortedMessages = computed(() => [...props.messages?.data].reverse());

const scrollContainer = ref<HTMLElement | null>(null);

const scrollToBottom = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollTop = scrollContainer.value.scrollHeight;
    }
};


onMounted(() => {
    nextTick(() => {
        scrollToBottom();
    });
});

usePoll(3000, {
    onFinish() {
    },
});
</script>

<template>
    <Head title="Welcome | The Anonymous Team Chat" />
    <div class="flex h-screen flex-col items-center justify-center bg-chat-bg p-6">
        <div class="w-full max-w-2xl rounded-t-base bg-white p-5 shadow-lg sm:p-8">
            <h1 class="text-2xl font-bold">Signable Team chat</h1>
            <p>Where people can sign messages anonymously</p>
            <p class="text-primary">signed in as {{ auth?.username }}</p>
        </div>
        <div ref="scrollContainer" class="w-full max-w-2xl flex-1 overflow-y-scroll p-6">
            <ChatBubbleComponent
                v-for="message in sortedMessages"
                :key="message.id"
                :message="message.message"
                :mine="message.username === auth?.username"
                :dateSent="message.created_at"
                :sentBy="message.username"
            />
        </div>
        <ChatFormComponent @sent="scrollToBottom" />
    </div>
</template>