<!-- PWA Install Prompt -->
<div id="pwa-install-prompt" class="fixed bottom-0 left-0 right-0 z-[10000] p-4 transform translate-y-full transition-transform duration-500 ease-in-out md:max-w-md md:left-auto md:right-6 md:bottom-6">
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-2xl border border-slate-100 dark:border-slate-700 overflow-hidden p-6 flex items-center gap-4 relative">
        <button onclick="closePwaPrompt()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
            <span class="material-icons text-sm">close</span>
        </button>
        
        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0">
            <img src="{{ asset('pwa-192x192.png') }}" class="w-12 h-12 rounded-xl shadow-lg" alt="IBSEA Logo">
        </div>
        
        <div class="flex-grow pr-4">
            <h4 class="text-secondary dark:text-white font-black text-sm uppercase tracking-tight mb-1">Install IBSEA App</h4>
            <p class="text-slate-500 dark:text-slate-400 text-[10px] font-bold leading-relaxed">Add to home screen for instant access to events and digital ID cards.</p>
            
            <div id="android-prompt-ui" class="mt-4 hidden">
                <button onclick="installPwa()" class="bg-primary hover:bg-orange-600 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">Install Now</button>
            </div>
            
            <div id="ios-prompt-ui" class="mt-4 hidden flex items-center gap-2">
                <span class="text-slate-400 text-[9px] font-bold">Tap <span class="material-icons text-xs align-middle">ios_share</span> then "Add to Home Screen"</span>
            </div>
        </div>
    </div>
</div>

<script>
    let deferredPrompt;
    const pwaPrompt = document.getElementById('pwa-install-prompt');
    const androidUI = document.getElementById('android-prompt-ui');
    const iosUI = document.getElementById('ios-prompt-ui');

    function isStandalone() {
        return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
    }

    function shouldShowPrompt() {
        if (isStandalone()) return false;
        
        const lastSeen = localStorage.getItem('pwa_prompt_last_seen');
        if (!lastSeen) return true;
        
        const oneDay = 24 * 60 * 60 * 1000;
        return (Date.now() - parseInt(lastSeen)) > oneDay;
    }

    function showPwaPrompt() {
        if (!shouldShowPrompt()) return;
        
        pwaPrompt.classList.remove('translate-y-full');
        localStorage.setItem('pwa_prompt_last_seen', Date.now().toString());
    }

    function closePwaPrompt() {
        pwaPrompt.classList.add('translate-y-full');
    }

    // Android / Chrome Logic
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        androidUI.classList.remove('hidden');
        showPwaPrompt();
    });

    async function installPwa() {
        if (!deferredPrompt) return;
        
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        console.log(`User response to the install prompt: ${outcome}`);
        deferredPrompt = null;
        closePwaPrompt();
    }

    // Detection & iOS Logic
    document.addEventListener('DOMContentLoaded', () => {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        
        if (isIOS && !isStandalone()) {
            iosUI.classList.remove('hidden');
            setTimeout(showPwaPrompt, 3000); // Wait 3s before showing on iOS
        }
        
        // General fallback for browsers that support install but didn't trigger event yet
        if (!isStandalone() && !isIOS && shouldShowPrompt()) {
            // Some browsers show Install in menu, we can still show a generic reminder if needed
            // But we prefer waiting for beforeinstallprompt
        }
    });

    // Listen for successful install
    window.addEventListener('appinstalled', () => {
        console.log('PWA was installed');
        closePwaPrompt();
    });
</script>
