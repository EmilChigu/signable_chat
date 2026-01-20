import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, test, vi } from 'vitest';
import { defineComponent, reactive } from 'vue';

import ChatRoom from '@/pages/ChatRoom.vue';

const postForm = vi.fn();

vi.mock('@inertiajs/vue3', () => ({
    Head: defineComponent({
        name: 'Head',
        props: { title: { type: String, required: false } },
        setup(_props, { slots }) {
            return () => slots.default?.();
        },
    }),
    router: {
        post: (...args: unknown[]) => postForm(...args),
    },
    useForm: (initial: { username: string }) =>
        reactive({
            ...initial,
            processing: false,
        }),
    usePoll: (interval: number, options: { onFinish: () => void }) => {
        options.onFinish();
    },
}));

type messages = { data: { id: number; message: string; username: string; created_at: string }[] }

describe('ChatRoom', () => {
    beforeEach(() => {
        postForm.mockClear();
    });

    const mountPage = (auth: { username: string } = { username: '' }, messages: messages = { data: [] }) =>
        mount(ChatRoom, {
            props: { auth, messages },
        });

    test('keeps send message disabled until message is long enough', async () => {
        const wrapper = mountPage();
        const button = wrapper.get('button[type="submit"]');

        expect((button.element as HTMLButtonElement).disabled).toBe(true);

        await wrapper.find('#message').setValue('automated test');

        expect((button.element as HTMLButtonElement).disabled).toBe(false);
    });

});