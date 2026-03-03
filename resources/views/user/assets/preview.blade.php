@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 p-4 md:p-12 overflow-y-auto">
        <div class="max-w-4xl mx-auto space-y-8">
            <header class="flex flex-col md:flex-row justify-between md:items-end gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Asset Preview</h1>
                    <p class="text-slate-500 font-medium">Review your document layout before downloading.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <button onclick="downloadAsImage()" class="w-full sm:w-auto bg-primary text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all flex items-center justify-center gap-2">
                        <span class="material-icons text-sm">photo</span>
                        Download PNG
                    </button>
                    <a href="{{ route('user.assets.'.$type, $booking->id ?? null) }}" class="w-full sm:w-auto bg-slate-900 dark:bg-white text-white dark:text-slate-950 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-2">
                        <span class="material-icons text-sm">picture_as_pdf</span>
                        Download PDF
                    </a>
                </div>
            </header>

            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-4 shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden flex justify-center w-full max-w-full">
                <div id="canvas-wrapper" class="shadow-inner bg-slate-50 dark:bg-slate-800 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 w-full max-w-full flex justify-center">
                    <canvas id="canvas"></canvas>
                </div>
            </div>

            <div class="bg-blue-500/5 border border-blue-500/10 p-6 rounded-[2rem] flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-500/20">
                    <span class="material-icons text-sm">info</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-blue-500 uppercase tracking-widest mb-0.5">Gold Standard Export</h4>
                    <p class="text-xs text-slate-500 font-medium">Use **Download PNG** for 100% visual fidelity matching your screen exactly. Use PDF for professional printing.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
<script>
    const canvas = new fabric.Canvas('canvas', {
        interactive: false,
        selection: false,
        backgroundColor: '#ffffff'
    });

    const templateData = @json($template->layout_json);
    const targetWidth = {{ $template->width }};
    const targetHeight = {{ $template->height }};
    
    // Store scale globally
    let currentScale = 1;

    function scaleCanvas() {
        const wrapper = document.getElementById('canvas-wrapper');
        const maxWidth = wrapper.offsetWidth;
        // Calculate new scale, defaulting to 1 if wrapper width is somehow larger than target
        currentScale = Math.min(1, maxWidth / targetWidth);

        canvas.setWidth(targetWidth);
        canvas.setHeight(targetHeight);
        canvas.setZoom(currentScale);
        canvas.setWidth(targetWidth * currentScale);
        canvas.setHeight(targetHeight * currentScale);
    }

    // Initial Scale Set
    scaleCanvas();

    // Listen to window resize events to keep canvas reactive
    window.addEventListener('resize', scaleCanvas);

    // Load Background
    fabric.Image.fromURL('{{ $background }}', function(img) {
        img.scaleToWidth(targetWidth);
        img.scaleToHeight(targetHeight);
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
            originX: 'left',
            originY: 'top',
            top: 0,
            left: 0
        });
    });

    // Replace and Load Elements
    const objects = templateData.objects || [];
    objects.forEach(obj => {
        if (obj.type === 'i-text' || obj.type === 'text' || obj.type === 'textbox') {
            obj.text = replacePlaceholders(obj.text);
            // Delete old width/height so Fabric recalculates bounding box correctly for center alignment
            delete obj.width;
            delete obj.height;
        } else if (
            (obj.name && (obj.name.includes('qr_code') || obj.name.includes('QR_CODE'))) ||
            (obj.type === 'group' && obj.objects && obj.objects.some(sub => (sub.type === 'text' || sub.type === 'i-text') && sub.text && sub.text.toUpperCase().includes('QR CODE')))
        ) {
            @if(isset($qrCode) && $qrCode)
                fabric.Image.fromURL('{{ $qrCode }}', function(qrImg) {
                    qrImg.set({
                        left: obj.left,
                        top: obj.top,
                        scaleX: (obj.scaleX || 1) * (obj.width / qrImg.width),
                        scaleY: (obj.scaleY || 1) * (obj.height / qrImg.height)
                    });
                    canvas.add(qrImg);
                });
            @endif
            return;
        } else if (
            (obj.name && (obj.name.includes('event_image') || obj.name.includes('EVENT_IMAGE'))) ||
            (obj.type === 'group' && obj.objects && obj.objects.some(sub => (sub.type === 'text' || sub.type === 'i-text') && sub.text && sub.text.toUpperCase().includes('EVENT_IMAGE')))
        ) {
            @if(isset($event_image) && $event_image)
                fabric.Image.fromURL('{{ $event_image }}', function(evtImg) {
                    const width = (obj.width * (obj.scaleX || 1));
                    const height = (obj.height * (obj.scaleY || 1));
                    evtImg.set({
                        left: obj.left,
                        top: obj.top,
                        scaleX: width / evtImg.width,
                        scaleY: height / evtImg.height
                    });
                    canvas.add(evtImg);
                });
            @endif
            return;
        } else if (
            (obj.name && (obj.name.includes('profile_image') || obj.name.includes('PROFILE_IMAGE'))) ||
            (obj.type === 'group' && obj.objects && obj.objects.some(sub => (sub.type === 'text' || sub.type === 'i-text') && sub.text && sub.text.toUpperCase().includes('PROFILE_IMAGE')))
        ) {
            @if(isset($profile_image) && $profile_image)
                fabric.Image.fromURL('{{ $profile_image }}', function(profImg) {
                    const size = Math.min(obj.width * (obj.scaleX || 1), obj.height * (obj.scaleY || 1));
                    profImg.set({
                        left: obj.left + (obj.width * (obj.scaleX || 1) / 2),
                        top: obj.top + (obj.height * (obj.scaleY || 1) / 2),
                        originX: 'center',
                        originY: 'center',
                        scaleX: size / profImg.width,
                        scaleY: size / profImg.height,
                        clipPath: new fabric.Circle({
                            radius: profImg.width / 2,
                            originX: 'center',
                            originY: 'center'
                        })
                    });
                    canvas.add(profImg);
                    canvas.renderAll();
                });
            @endif
            return;
        }        
        fabric.util.enlivenObjects([obj], function(enlivenedObjects) {
            enlivenedObjects.forEach(function(o) {
                o.selectable = false;
                canvas.add(o);
            });
        });
    });

    function replacePlaceholders(text) {
        const data = {
            'name': @json($user->name ?? ''),
            'id': @json($user->id ?? ''),
            'date': @json($date ?? ''),
            'serial_id': @json($serial_id ?? ''),
            'certificate_no': @json($certificate_no ?? ''),
            'membership_type': @json($membership_type ?? ''),
            'start_date': @json($start_date ?? ''),
            'end_date': @json($end_date ?? ''),
            'event_name': @json($booking->event->title ?? $booking->event->name ?? $event->title ?? $event->name ?? ''),
            'event_venue': @json($event_venue ?? ''),
            'event_time': @json($event_time ?? ''),
            'event_date': @json($event_date ?? ''),
            'ticket_type': @json($ticket_type ?? ''),
            'ticket_no': @json($ticket_no ?? ''),
            'ticket_id': @json($ticket_no ?? ''),
            'transaction_id': @json($transaction_id ?? ''),
            'profile_image': @json($profile_image ?? '')
        };

        Object.keys(data).forEach(key => {
            const val = data[key] || '';
            text = text.replace(new RegExp('@{{' + key + '}}', 'g'), val);
            text = text.replace(new RegExp('{{' + key + '}}', 'g'), val);
        });
        return text;
    }

    function downloadAsImage() {
        // Render at full resolution (multiplier 2)
        const currentZoom = canvas.getZoom();
        canvas.setZoom(1);
        canvas.setWidth(targetWidth);
        canvas.setHeight(targetHeight);

        const dataURL = canvas.toDataURL({
            format: 'png',
            quality: 1,
            multiplier: 2
        });

        // Reset display zoom using tracked scale
        canvas.setZoom(currentScale);
        canvas.setWidth(targetWidth * currentScale);
        canvas.setHeight(targetHeight * currentScale);

        const link = document.createElement('a');
        link.download = 'IBSEA_{{ $type }}_{{ $user->id }}.png';
        link.href = dataURL;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
