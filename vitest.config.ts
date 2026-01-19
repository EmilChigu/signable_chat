import vue from '@vitejs/plugin-vue';
import { defineConfig } from 'vitest/config';
import { fileURLToPath } from 'node:url';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        },
    },
    test: {
        environment: 'jsdom',
        include: ['resources/js/**/*.test.ts'],
        coverage: {
            provider: 'v8',
            enabled: true,
            include: ['resources/js/components/**/*.{ts,vue}', 'resources/js/pages/**/*.{ts,vue}'],
            exclude: ['**/node_modules/**', '**/vendor/**'],
        },
    },
});