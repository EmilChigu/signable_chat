import vue from '@vitejs/plugin-vue';
import { defineConfig } from 'vitest/config';

export default defineConfig({
    plugins: [vue()],
    test: {
        include: ['resources/js/**/*.test.ts'],
        coverage: {
            provider: 'v8',
            enabled: true,
            include: ['resources/js/components/**/*.{ts,vue}', 'resources/js/pages/**/*.{ts,vue}'],
            exclude: ['**/node_modules/**', '**/vendor/**'],
        },
    },
});