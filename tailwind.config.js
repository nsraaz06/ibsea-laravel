module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#004a95', // IBSEA Navy (Institutional Authority)
                accent: '#f26f21',  // IBSEA Orange (Action/Innovation)
                ibsea: {
                    navy: '#004a95',
                    orange: '#f26f21',
                    green: '#078e31',
                    slate: '#475569',
                    gold: '#d4af37',
                    background: '#f8fafc'
                }
            },
            fontFamily: {
                sans: ['Inter', 'Montserrat', 'Public Sans', 'system-ui', 'sans-serif'],
                display: ['Poppins', 'sans-serif'],
            },
            borderRadius: {
                'ibsea-sm': '4px',
                'ibsea-md': '12px',
                'ibsea-lg': '24px',
                'ibsea-full': '9999px',
            },
            boxShadow: {
                'premium': '0 10px 30px -10px rgba(0, 74, 149, 0.15)',
                'action': '0 10px 20px -5px rgba(242, 111, 33, 0.3)',
            },
            screens: {
                'xs': '375px',
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
