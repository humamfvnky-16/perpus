import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd', 400: '#a78bfa',
                    500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9', 800: '#5b21b6', 900: '#4c1d95',
                },
                accent: { 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488' },
                ink: '#1a1730',
            },
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui'],
                display: ['Sora', 'Plus Jakarta Sans', 'ui-sans-serif'],
            },
            boxShadow: {
                soft: '0 1px 2px rgba(76,29,149,0.06), 0 6px 20px rgba(76,29,149,0.06)',
                hover: '0 10px 30px rgba(124,58,237,0.18)',
                glow: '0 0 0 3px rgba(139,92,246,0.15)',
            },
        },
    },
    plugins: [forms, typography],
};
