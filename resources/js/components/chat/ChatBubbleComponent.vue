<script setup lang="ts">
defineProps({ message: String, mine: Boolean, dateSent: String, sentBy: String });

const formatDate = (date: string) => {
    const parsedDate = new Date(date);
    return parsedDate.toLocaleString('en-GB');
};
</script>

<template>
    <div class="mb-4 flex max-w-[70%] flex-col gap-1" :class="{ 'ml-auto': mine }">
        <span v-if="!mine" class="text-xs">{{ sentBy }}</span>
        <div class="rounded-base bg-other-message p-3" :class="{ 'bg-white': mine }">
            <p>{{ message }}</p>
        </div>
        <span class="text-xs">{{ dateSent ? formatDate(dateSent) : '' }}</span>
    </div>
</template>

<style scoped></style>