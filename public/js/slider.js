const carouselElement = document.getElementById('carousel-example');

const items = [
    {
        position: 0,
        el: document.getElementById('carousel-item-1'),
    },
    {
        position: 1,
        el: document.getElementById('carousel-item-2'),
    },
    {
        position: 2,
        el: document.getElementById('carousel-item-3'),
    },
    {
        position: 3,
        el: document.getElementById('carousel-item-4'),
    },
];

// options with default values
const options = {
    defaultPosition: 1,
    interval: 3000,

    indicators: {
        activeClasses: 'bg-white dark:bg-gray-800',
        inactiveClasses:
            'bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800',
        items: [
            {
                position: 0,
                el: document.getElementById('carousel-indicator-1'),
            },
            {
                position: 1,
                el: document.getElementById('carousel-indicator-2'),
            },
            {
                position: 2,
                el: document.getElementById('carousel-indicator-3'),
            },
            {
                position: 3,
                el: document.getElementById('carousel-indicator-4'),
            },
        ],
    },

    // callback functions
    onNext: () => {
        console.log('next slider item is shown');
    },
    onPrev: () => {
        console.log('previous slider item is shown');
    },
    onChange: () => {
        console.log('new slider item has been shown');
    },
};

// instance options object
const instanceOptions = {
    id: 'carousel-example',
    override: true
};

// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            animation: {
                marquee: 'marquee 25s linear infinite',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
        },
    },
}
module.exports = {
    theme: {
        extend: {
            keyframes: {
                shrinkGrow: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%': { transform: 'scale(1.1)' },
                },
            },
            animation: {
                'shrink-grow': 'shrinkGrow 2s ease-in-out infinite',
            },
        },
    },
}
module.exports = {
    content: [
        "./src/**/*.{js,jsx,ts,tsx}",
    ],
    theme: {
        extend: {
            keyframes: {
                // Define the keyframes for your custom pulse animation
                'pulse-sm': {
                    '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                    '50%': { opacity: '.5', transform: 'scale(1.1)' }, // Scale to 1.1x
                },
                // Define the keyframes for your custom ping animation
                'ping-sm': {
                    '75%, 100%': {
                        transform: 'scale(1.1)', // Scale to 1.1x
                        opacity: '0',
                    },
                },
            },
            animation: {
                // Define the utility classes that use your custom keyframes
                'pulse-sm': 'pulse-sm 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'ping-sm': 'ping-sm 1s cubic-bezier(0, 0, 0.2, 1) infinite',
            },
        },
    },
    plugins: [],
}

module.exports = {
    theme: {
        extend: {
            animation: {
                marquee: 'marquee 18s linear infinite',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(100%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
        },
    },
}
module.exports = {
    theme: {
        extend: {
            keyframes: {
                shrinkGrow: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%': { transform: 'scale(1.1)' },
                },
            },
            animation: {
                'shrink-grow': 'shrinkGrow 2s ease-in-out infinite',
            },
        },
    },
}