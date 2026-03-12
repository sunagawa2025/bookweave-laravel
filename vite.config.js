import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // ▼追加 260218 クイズゲーム用
                'resources/js/games/quiz1.js',
                'resources/js/games/quiz2.js',
                'resources/css/games/quiz.css'
                // ▲追加 260223 quiz2追加
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
