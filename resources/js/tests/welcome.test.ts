import { mount } from '@vue/test-utils';
import { beforeEach, describe, expect, test, vi } from 'vitest';
import { defineComponent, reactive } from 'vue';

import WelcomePage from '@/pages/Welcome.vue';

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
}));

describe('WelcomePage', () => {
    beforeEach(() => {
        postForm.mockClear();
    });

    const mountPage = (errors: Record<string, string> = {}) =>
        mount(WelcomePage, {
            props: { errors },
        });

    test('keeps submit disabled until the username is long enough', async () => {
        const wrapper = mountPage();
        const button = wrapper.get('button[type="submit"]');

        expect((button.element as HTMLButtonElement).disabled).toBe(true);

        await wrapper.find('#username').setValue('signable');

        expect((button.element as HTMLButtonElement).disabled).toBe(false);
    });

    test('renders validation errors from props', () => {
        const wrapper = mountPage({ username: 'Username is required.' });
        expect(wrapper.text()).toContain('Username is required.');
    });

    test('submits the username via Inertia router', async () => {
        const wrapper = mountPage();
        await wrapper.find('#username').setValue('emil_chigu');

        await wrapper.find('form').trigger('submit.prevent');

        expect(postForm).toHaveBeenCalledWith('/', { username: 'emil_chigu' });
    });
});