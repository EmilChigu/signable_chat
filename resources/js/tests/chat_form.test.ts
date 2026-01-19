import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, test, vi } from 'vitest';
import { reactive } from 'vue';

import ChatFormComponent from '@/components/chat/ChatFormComponent.vue';

const postForm = vi.fn();
const resetForm = vi.fn();
let latestFormState: {
    message: string;
    processing: boolean;
    post: (url: string, options?: { onSuccess?: () => void }) => void;
    reset: () => void;
} | null = null;

vi.mock('@inertiajs/vue3', () => ({
    router: {},
    useForm: (initial: { message: string }) => {
        const state = reactive({
            ...initial,
            processing: false,
            post: (url: string, options?: { onSuccess?: () => void }) => {
                postForm(url, options);
                options?.onSuccess?.();
            },
            reset: () => {
                resetForm();
                state.message = initial.message ?? '';
            },
        });

        latestFormState = state;
        return state;
    },
}));

describe('ChatFormComponent', () => {
    beforeEach(() => {
        postForm.mockClear();
        resetForm.mockClear();
        latestFormState = null;
    });

    const mountForm = (errors: Record<string, string> = {}) =>
        mount(ChatFormComponent, {
            props: { errors },
        });

    test('disables the send button until the message is valid', async () => {
        const wrapper = mountForm();
        const submitButton = wrapper.get('button[type="submit"]');

        expect((submitButton.element as HTMLButtonElement).disabled).toBe(true);

        await wrapper.find('#message').setValue('Hello world');

        expect((submitButton.element as HTMLButtonElement).disabled).toBe(false);
    });

    test('renders validation errors from props', () => {
        const wrapper = mountForm({ message: 'Message is required.' });
        expect(wrapper.text()).toContain('Message is required.');
    });

    test('submits the form, resets it, and emits sent event', async () => {
        const wrapper = mountForm();
        await wrapper.find('#message').setValue('Sending a message');

        await wrapper.find('form').trigger('submit.prevent');

        expect(postForm).toHaveBeenCalledWith(
            '/chat',
            expect.objectContaining({
                preserveScroll: true,
                onSuccess: expect.any(Function),
            }),
        );
        expect(resetForm).toHaveBeenCalled();
        expect(wrapper.emitted().sent).toHaveLength(1);
        expect(latestFormState?.message).toBe('');
    });
});