import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'
import { optimizeLodashImports } from '@optimize-lodash/rollup-plugin'

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm.browser.js'
        }
    },
    plugins: [
        optimizeLodashImports(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true
        }),
        vue({
            template: {
                transformAssetUrlsOptions: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
})