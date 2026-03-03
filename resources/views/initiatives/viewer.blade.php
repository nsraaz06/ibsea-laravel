@extends('layouts.app')

@section('content')
@section('content')
<div class="bg-navy-accent dark:bg-slate-950 min-h-screen pt-[72px] relative overflow-x-hidden">
    {{-- Loading Overlay --}}
    <div id="pdf-loader" class="fixed inset-0 z-[100] bg-navy-accent dark:bg-slate-950 flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative w-24 h-24 mb-6">
            <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-t-primary rounded-full animate-spin"></div>
        </div>
        <p class="text-white font-black uppercase tracking-[0.3em] text-[10px] animate-pulse">Initializing Strategic Intel...</p>
        <div id="load-progress-container" class="w-48 h-1 bg-white/10 rounded-full mt-6 overflow-hidden">
            <div id="load-progress-bar" class="h-full bg-primary transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>

    {{-- Viewer Controls --}}
    <div class="fixed top-[88px] right-6 z-[80] flex flex-col gap-3">
        <button onclick="window.print()" class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-accent transition-all shadow-2xl group">
            <span class="material-icons text-xl">print</span>
            <span class="absolute right-full mr-4 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap">Print Intel</span>
        </button>
        <a href="{{ asset($initiative->pdf_path) }}" download class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-accent transition-all shadow-2xl group">
            <span class="material-icons text-xl">download</span>
            <span class="absolute right-full mr-4 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap">Download Dossier</span>
        </a>
    </div>

    {{-- PDF Container --}}
    <div id="pdf-container" class="max-w-5xl mx-auto p-4 md:p-8 space-y-8 relative z-10 min-h-screen">
        {{-- Pages will be injected here --}}
    </div>
</div>

{{-- PDF.js Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    document.addEventListener('DOMContentLoaded', () => {
        const url = '{{ asset($initiative->pdf_path) }}';
        const container = document.getElementById('pdf-container');
        const loader = document.getElementById('pdf-loader');
        const progressBar = document.getElementById('load-progress-bar');
        
        let pdfDoc = null;
        let pagesRendered = new Set();
        
        // Load the PDF
        const loadingTask = pdfjsLib.getDocument({
            url: url,
            cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
            cMapPacked: true,
        });
        
        loadingTask.onProgress = function(progress) {
            if (progress.total > 0) {
                const percent = Math.round((progress.loaded / progress.total) * 100);
                progressBar.style.width = percent + '%';
            }
        };

        loadingTask.promise.then(pdf => {
            pdfDoc = pdf;
            
            // Create placeholders for all pages
            for (let i = 1; i <= pdf.numPages; i++) {
                const pageWrapper = document.createElement('div');
                pageWrapper.className = 'pdf-page-wrapper bg-white shadow-2xl rounded-sm overflow-hidden relative min-h-[400px] md:min-h-[800px] transition-transform duration-500 hover:scale-[1.01]';
                pageWrapper.id = `page-${i}`;
                pageWrapper.dataset.pageNumber = i;
                
                pageWrapper.innerHTML = `
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                        <div class="flex flex-col items-center gap-4 text-slate-300">
                            <span class="material-icons text-4xl animate-pulse">description</span>
                            <span class="text-[10px] font-black tracking-widest uppercase">Syncing Page ${i}...</span>
                        </div>
                    </div>
                `;
                
                container.appendChild(pageWrapper);
                observer.observe(pageWrapper);
            }
            
            // Priority: Render Page 1 immediately
            renderPage(1, document.getElementById('page-1'));

            // Hide global loader quickly
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => loader.style.display = 'none', 500);
            }, 300);
            
        }).catch(err => {
            console.error('Error loading PDF:', err);
            container.innerHTML = `
                <div class="bg-red-500/10 border border-red-500/20 p-12 rounded-3xl text-center">
                    <span class="material-icons text-6xl text-red-500 mb-4">error_outline</span>
                    <h3 class="text-white text-xl font-black uppercase mb-4 tracking-tighter">Security Protocol Error</h3>
                    <p class="text-red-400 font-medium mb-8">Unable to decrypt or load the requested dossier. Please ensure you are authorized.</p>
                    <a href="{{ route('public.initiatives.index') }}" class="inline-block bg-navy-accent text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest">Return to Initiatives</a>
                </div>
            `;
            loader.style.display = 'none';
        });

        // Intersection Observer for Lazy Loading
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const pageNum = parseInt(entry.target.dataset.pageNumber);
                    if (!pagesRendered.has(pageNum)) {
                        renderPage(pageNum, entry.target);
                    }
                }
            });
        }, { threshold: 0.1, rootMargin: '100px' });

        function renderPage(num, wrapper) {
            pagesRendered.add(num);
            
            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({ scale: 2 }); // High res for premium feel
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.className = 'w-full h-auto block';
                
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                page.render(renderContext).promise.then(() => {
                    wrapper.innerHTML = '';
                    wrapper.appendChild(canvas);
                    wrapper.classList.remove('min-h-[400px]', 'md:min-h-[800px]');
                });
            });
        }

        // Header Auto-Hide Logic
        let lastScrollTop = 0;
        const header = document.querySelector('.primary_nav');
        
        if (header) {
            header.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            window.addEventListener('scroll', () => {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    header.style.transform = 'translateY(-100%)';
                } else if (scrollTop < lastScrollTop) {
                    header.style.transform = 'translateY(0)';
                }
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            }, { passive: true });
        }
    });
</script>

<style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: rgba(10, 31, 73, 0.1); }
    ::-webkit-scrollbar-thumb { background: #f26f21; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #e05e1a; }
    
    canvas {
        image-rendering: crisp-edges;
    }

    @media print {
        .fixed, #pdf-loader { display: none !important; }
        #pdf-container { padding: 0 !important; space-y: 0 !important; }
        .pdf-page-wrapper { break-after: page; box-shadow: none !important; }
    }
</style>
@endsection
