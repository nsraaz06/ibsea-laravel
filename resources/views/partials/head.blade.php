<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />

<title>{{ $siteSettings['site_name'] ?? 'IBSEA' }} | International Business Startup & Entrepreneurs Association</title>

@if(!empty($siteSettings['favicon']))
    <link rel="icon" type="image/png" href="{{ asset($siteSettings['favicon']) }}">
    <link rel="apple-touch-icon" href="{{ asset($siteSettings['favicon']) }}">
@else
    <link rel="icon" type="image/png" href="{{ asset('image/logo-ibsea.png') }}">
@endif

<!-- Immediate Assets & Tailwind CDN Fallback -->
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    tailwind.config = { 
        darkMode: "class", 
        theme: { 
            extend: { 
                colors: { 
                    primary: "#f6790b", 
                    secondary: "#0F172A", 
                    "navy-accent": "#0F172A"
                },
                fontFamily: {
                    sans: ['"Public Sans"', 'sans-serif'],
                }
            }
        }
    };
    // Theme Loader (Defaults to Light)
    (function initTheme() {
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/global.css') }}?v={{ time() }}">
