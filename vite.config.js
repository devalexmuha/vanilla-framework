import { defineConfig } from 'vite'

export default defineConfig({
    root: 'resources',
    build: {
        outDir: '../public/js',
        emptyOutDir: false,
        lib: {
            entry: 'js/app.js',
            formats: ['iife'],
            name: 'App',
            fileName: () => 'app.js',
        },
    },
})