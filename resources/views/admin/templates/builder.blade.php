@extends('layouts.admin')

@section('content')
<div class="h-screen flex flex-col bg-slate-50">
    <!-- Builder Header -->
    <div class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between shadow-sm z-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.design-templates.index') }}" class="w-8 h-8 flex items-center justify-center bg-slate-100 rounded-lg text-slate-500 hover:text-primary transition-all">
                <span class="material-icons text-sm">arrow_back</span>
            </a>
            <div class="flex items-baseline gap-3">
                <h1 class="text-lg font-black text-slate-800 uppercase tracking-tight leading-none">{{ $designTemplate->name }}</h1>
                <div class="flex gap-1 ml-4 text-white">
                    <button onclick="setDimension(1123, 794)" title="A4 Landscape (1123x794px)" class="px-2 py-1 bg-slate-100 rounded text-[8px] font-black uppercase text-slate-600 hover:bg-primary hover:text-white transition-all">A4 Cert</button>
                    <button onclick="setDimension(204, 324)" title="ID Card (204x324px)" class="px-2 py-1 bg-slate-100 rounded text-[8px] font-black uppercase text-slate-600 hover:bg-primary hover:text-white transition-all">ID Card</button>
                    <button onclick="setDimension(1080, 1920)" title="Mobile Ticket (1080x1920px)" class="px-2 py-1 bg-slate-100 rounded text-[8px] font-black uppercase text-slate-600 hover:bg-primary hover:text-white transition-all">Ticket</button>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center bg-slate-100 rounded-xl p-1 mr-4">
                <button onclick="zoomCanvas(0.9)" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg transition-all text-slate-500 shadow-sm"><span class="material-icons text-sm">zoom_out</span></button>
                <div class="px-3 text-[10px] font-black text-slate-400 w-16 text-center" id="zoom_level">100%</div>
                <button onclick="zoomCanvas(1.1)" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg transition-all text-slate-500 shadow-sm"><span class="material-icons text-sm">zoom_in</span></button>
                <button onclick="resetZoom()" class="ml-1 w-8 h-8 flex items-center justify-center hover:bg-slate-200 rounded-lg transition-all text-slate-500" title="Reset Zoom"><span class="material-icons text-sm">restart_alt</span></button>
            </div>
            <button onclick="downloadAsImage()" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-2">
                <span class="material-icons text-sm">photo</span>
                Export Image
            </button>
            <button onclick="saveLayout()" id="save_btn" class="bg-primary text-white px-6 py-2 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
                <span class="material-icons text-sm">save</span>
                Save Design
            </button>
        </div>
    </div>

    <!-- Main Builder Area -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- Sidebar Tools -->
        <div class="w-72 bg-white border-r border-slate-200 flex flex-col overflow-y-auto">
            <div class="p-6 space-y-8">
                
                <!-- Field Inserters -->
                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">User & Membership</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="addTextField('@{{name}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">person</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Full Name</span>
                        </button>
                        <button onclick="addTextField('@{{membership_type}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">military_tech</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Member Type</span>
                        </button>
                        <button onclick="addTextField('@{{certificate_no}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">verified_user</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Doc Serial</span>
                        </button>
                        <button onclick="addTextField('@{{id}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">badge</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Member ID</span>
                        </button>
                        <button onclick="addImageField('@{{profile_image}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">account_circle</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Profile Photo</span>
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Event Related</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="addTextField('@{{event_name}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">event</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Event Name</span>
                        </button>
                        <button onclick="addTextField('@{{event_venue}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">place</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Venue</span>
                        </button>
                        <button onclick="addTextField('@{{event_time}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">schedule</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Time</span>
                        </button>
                        <button onclick="addTextField('@{{ticket_type}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">confirmation_number</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Tkt Type</span>
                        </button>
                        <button onclick="addTextField('@{{ticket_no}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">tag</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Ticket #</span>
                        </button>
                        <button onclick="addTextField('@{{transaction_id}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">receipt</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase text-center">Trans ID</span>
                        </button>
                        <button onclick="addImageField('@{{event_image}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">image</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase text-center">Feat. Img</span>
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Dates & Timeline</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="addTextField('@{{event_date}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">event_note</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Event Date</span>
                        </button>
                        <button onclick="addTextField('@{{date}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">calendar_today</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Today</span>
                        </button>
                        <button onclick="addTextField('@{{start_date}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">event_available</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Valid From</span>
                        </button>
                        <button onclick="addTextField('@{{end_date}}')" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">event_busy</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Valid Until</span>
                        </button>
                        <button onclick="addQRField()" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">qr_code_2</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">QR Code</span>
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Static Blocks</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="addTextField('ADD HEADING HERE', {fontSize: 42, fontWeight: 'bold'})" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">title</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Heading</span>
                        </button>
                        <button onclick="addTextField('Enter paragraph text here...', {fontSize: 14, fontWeight: 'normal'})" class="flex flex-col items-center justify-center p-3 bg-slate-50 rounded-2xl border border-slate-100 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                            <span class="material-icons text-slate-400 group-hover:text-primary mb-1 text-base">notes</span>
                            <span class="text-[9px] font-black text-slate-600 uppercase">Paragraph</span>
                        </button>
                    </div>
                </div>

                <!-- Object Properties -->
                <div id="properties_panel" class="hidden space-y-6 pt-6 border-t border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Element Settings</h3>
                    
                    <!-- Font Size -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Font Size</label>
                        <input type="range" min="8" max="120" value="20" id="prop_font_size" class="w-full accent-primary" oninput="updateObject('fontSize', parseInt(this.value))">
                    </div>

                    <!-- Color -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Text Color</label>
                        <div class="flex gap-2 flex-wrap">
                            <button onclick="updateObject('fill', '#000000')" class="w-6 h-6 rounded-full border border-slate-200" style="background:#000"></button>
                            <button onclick="updateObject('fill', '#ffffff')" class="w-6 h-6 rounded-full border border-slate-200" style="background:#fff"></button>
                            <button onclick="updateObject('fill', '#002855')" class="w-6 h-6 rounded-full border border-slate-200" style="background:#002855"></button>
                            <button onclick="updateObject('fill', '#F26F21')" class="w-6 h-6 rounded-full border border-slate-200" style="background:#F26F21"></button>
                            <input type="color" id="prop_color" class="w-6 h-6 p-0 border-none bg-transparent cursor-pointer" oninput="updateObject('fill', this.value)">
                        </div>
                    </div>

                    <!-- Alignment & Positioning -->
                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-slate-500 uppercase">Alignment & Positioning</label>
                        
                        <!-- Text Alignment (Only for Text) -->
                        <div id="text_align_box" class="flex bg-slate-50 rounded-xl p-1 gap-1">
                            <button onclick="updateObject('textAlign', 'left')" class="flex-1 p-2 hover:bg-white rounded-lg transition-all text-slate-500 hover:text-primary" title="Left Align"><span class="material-icons text-sm">format_align_left</span></button>
                            <button onclick="updateObject('textAlign', 'center')" class="flex-1 p-2 hover:bg-white rounded-lg transition-all text-slate-500 hover:text-primary" title="Center Align"><span class="material-icons text-sm">format_align_center</span></button>
                            <button onclick="updateObject('textAlign', 'right')" class="flex-1 p-2 hover:bg-white rounded-lg transition-all text-slate-500 hover:text-primary" title="Right Align"><span class="material-icons text-sm">format_align_right</span></button>
                        </div>

                        <!-- Canvas Centering -->
                        <div class="flex gap-2">
                            <button onclick="centerObject('h')" class="flex-1 bg-slate-50 p-3 rounded-xl hover:bg-primary hover:text-white transition-all group flex flex-col items-center gap-1 border border-slate-100">
                                <span class="material-icons text-base text-slate-400 group-hover:text-white">align_horizontal_center</span>
                                <span class="text-[8px] font-black uppercase">Center H</span>
                            </button>
                            <button onclick="centerObject('v')" class="flex-1 bg-slate-50 p-3 rounded-xl hover:bg-primary hover:text-white transition-all group flex flex-col items-center gap-1 border border-slate-100">
                                <span class="material-icons text-base text-slate-400 group-hover:text-white">align_vertical_center</span>
                                <span class="text-[8px] font-black uppercase">Center V</span>
                            </button>
                        </div>
                    </div>

                    <button onclick="deleteSelected()" class="w-full bg-red-50 text-red-500 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all mt-4 border border-red-100">
                        Remove Element
                    </button>
                </div>
            </div>
        </div>

        <!-- Canvas Container -->
        <div class="flex-1 bg-slate-200 p-12 flex items-center justify-center overflow-hidden pattern-dots">
            <div class="bg-white shadow-2xl relative" id="canvas_wrapper">
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
.pattern-dots {
    background-color: #e2e8f0;
    background-image: radial-gradient(#cbd5e1 1px, transparent 0);
    background-size: 20px 20px;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
<script>
let canvas;
const bgPath = "{{ $designTemplate->background_url }}";

document.addEventListener('DOMContentLoaded', () => {
    canvas = new fabric.Canvas('canvas', {
        preserveObjectStacking: true
    });

    const targetWidth = {{ $designTemplate->width ?? 1123 }};
    const targetHeight = {{ $designTemplate->height ?? 794 }};
    
    canvas.setWidth(targetWidth);
    canvas.setHeight(targetHeight);

    if (bgPath) {
        updateBackground(bgPath);
    } else {
        canvas.setBackgroundColor('#fff', canvas.renderAll.bind(canvas));
    }

    // Load existing layout
    const savedLayout = @json($designTemplate->layout_json);
    if (savedLayout && savedLayout.objects) {
        canvas.loadFromJSON(savedLayout, canvas.renderAll.bind(canvas));
    }

    canvas.on('selection:created', showProperties);
    canvas.on('selection:updated', showProperties);
    canvas.on('selection:cleared', hideProperties);

    // Zoom on mouse wheel
    canvas.on('mouse:wheel', function(opt) {
        var delta = opt.e.deltaY;
        var zoom = canvas.getZoom();
        zoom *= 0.999 ** delta;
        if (zoom > 20) zoom = 20;
        if (zoom < 0.01) zoom = 0.01;
        
        // Zoom relative to mouse point
        canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
        
        opt.e.preventDefault();
        opt.e.stopPropagation();
        updateZoomLabel();
    });

    // Panning (Alt + Drag)
    canvas.on('mouse:down', function(opt) {
        var evt = opt.e;
        if (evt.altKey === true) {
            this.isDragging = true;
            this.selection = false;
            this.lastPosX = evt.clientX;
            this.lastPosY = evt.clientY;
        }
    });

    canvas.on('mouse:move', function(opt) {
        if (this.isDragging) {
            var e = opt.e;
            var vpt = this.viewportTransform;
            vpt[4] += e.clientX - this.lastPosX;
            vpt[5] += e.clientY - this.lastPosY;
            this.requestRenderAll();
            this.lastPosX = e.clientX;
            this.lastPosY = e.clientY;
        }
    });

    canvas.on('mouse:up', function(opt) {
        // on mouse up we want to recalculate new interaction
        // for all objects, so we call setViewportTransform
        this.setViewportTransform(this.viewportTransform);
        this.isDragging = false;
        this.selection = true;
    });
});

function zoomCanvas(factor) {
    let zoom = canvas.getZoom() * factor;
    if (zoom > 20) zoom = 20;
    if (zoom < 0.01) zoom = 0.01;
    
    // Zoom relative to center of view
    canvas.zoomToPoint({ 
        x: canvas.getWidth() / 2, 
        y: canvas.getHeight() / 2 
    }, zoom);
    
    updateZoomLabel();
}

function resetZoom() {
    canvas.setZoom(1);
    canvas.setViewportTransform([1, 0, 0, 1, 0, 0]);
    updateZoomLabel();
}

function updateZoomLabel() {
    document.getElementById('zoom_level').innerText = Math.round(canvas.getZoom() * 100) + '%';
}

function setDimension(w, h) {
    canvas.setWidth(w);
    canvas.setHeight(h);
    // If background exists, re-scale it to fit new dimensions
    if (canvas.backgroundImage) {
        const bg = canvas.backgroundImage;
        bg.scaleX = w / bg.width;
        bg.scaleY = h / bg.height;
    }
    resetZoom();
}

function updateBackground(path) {
    fabric.Image.fromURL(path, (img) => {
        img.set({
            originX: 'left',
            originY: 'top',
            scaleX: canvas.getWidth() / img.width,
            scaleY: canvas.getHeight() / img.height
        });
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
    }, { crossOrigin: 'anonymous' });
}

function addTextField(tag, options = {}) {
    const text = new fabric.IText(tag, {
        left: 100,
        top: 100,
        fontSize: options.fontSize || 30,
        fontFamily: 'Arial',
        fontWeight: options.fontWeight || 'bold',
        fill: '#000000',
        cornerStyle: 'circle',
        originX: 'center',
        originY: 'center',
        textAlign: 'center'
    });
    canvas.add(text);
    centerObject('h', text);
    centerObject('v', text);
    canvas.setActiveObject(text);
}

function addQRField() {
    const qr = new fabric.Rect({
        left: 100,
        top: 100,
        width: 100,
        height: 100,
        fill: '#eee',
        stroke: '#ccc',
        dashArray: [5, 5]
    });
    
    const label = new fabric.Text('QR CODE', {
        fontSize: 12,
        originX: 'center',
        originY: 'center',
        left: 50,
        top: 50,
        fontFamily: 'Arial',
        fontWeight: 'black'
    });

    const group = new fabric.Group([qr, label], {
        left: 100,
        top: 100,
        name: '@{{qr_code}}',
        originX: 'left',
        originY: 'top'
    });

    canvas.add(group);
    canvas.setActiveObject(group);
}

function addImageField(tag) {
    const rect = new fabric.Rect({
        width: 200,
        height: 120,
        fill: '#f8fafc',
        stroke: '#e2e8f0',
        strokeWidth: 2,
        dashArray: [5, 5],
        cornerStyle: 'circle'
    });
    
    const label = new fabric.Text('IMAGE: ' + tag.replace('@{{','').replace('}}','').toUpperCase(), {
        fontSize: 10,
        originX: 'center',
        originY: 'center',
        left: 100,
        top: 60,
        fontFamily: 'Arial',
        fontWeight: 'black',
        fill: '#94a3b8'
    });

    const group = new fabric.Group([rect, label], {
        left: 100,
        top: 100,
        name: tag,
        originX: 'left',
        originY: 'top'
    });

    canvas.add(group);
    centerObject('h', group);
    centerObject('v', group);
    canvas.setActiveObject(group);
}

function showProperties() {
    const obj = canvas.getActiveObject();
    if (!obj) return;
    
    document.getElementById('properties_panel').classList.remove('hidden');
    
    // Show/Hide Text Align based on type
    if (obj.type === 'i-text' || obj.type === 'text') {
        document.getElementById('text_align_box').classList.remove('hidden');
    } else {
        document.getElementById('text_align_box').classList.add('hidden');
    }

    if (obj.fontSize) {
        document.getElementById('prop_font_size').value = obj.fontSize;
    }
}

function hideProperties() {
    document.getElementById('properties_panel').classList.add('hidden');
}

function updateObject(key, val) {
    const obj = canvas.getActiveObject();
    if (!obj) return;

    if (obj.type === 'activeSelection') {
        obj.getObjects().forEach(o => {
            if (key === 'textAlign') updateTextAlignWithOrigin(o, val);
            else o.set(key, val);
        });
    } else {
        if (key === 'textAlign') updateTextAlignWithOrigin(obj, val);
        else obj.set(key, val);
    }
    canvas.renderAll();
}

function updateTextAlignWithOrigin(obj, align) {
    const originMap = { 'left': 'left', 'center': 'center', 'right': 'right' };
    const newOriginX = originMap[align];
    
    if (obj.originX === newOriginX) {
        obj.set('textAlign', align);
        return;
    }

    const centerPoint = obj.getCenterPoint();
    obj.set({
        textAlign: align,
        originX: newOriginX
    });
    obj.setPositionByOrigin(centerPoint, 'center', 'center');
    obj.setCoords();
}

function deleteSelected() {
    const activeObjects = canvas.getActiveObjects();
    canvas.discardActiveObject();
    if (activeObjects.length) {
        canvas.remove(...activeObjects);
    }
    hideProperties();
}

function centerObject(dir, specificObj = null) {
    const obj = specificObj || canvas.getActiveObject();
    if (!obj) return;

    if (dir === 'h') {
        canvas.centerObjectH(obj);
    } else {
        canvas.centerObjectV(obj);
    }
    obj.setCoords();
    canvas.requestRenderAll();
}

function saveLayout() {
    const btn = document.getElementById('save_btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="material-icons animate-spin text-sm">sync</span> Saving...';
    btn.disabled = true;

    const layout = canvas.toJSON();

    fetch("{{ route('admin.design-templates.update', $designTemplate->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            _method: 'PUT',
            name: @json($designTemplate->name),
            type: "{{ $designTemplate->type }}",
            width: canvas.getWidth(),
            height: canvas.getHeight(),
            layout_json: layout
        })
    })
    .then(response => response.json())
    .then(data => {
        btn.innerHTML = '<span class="material-icons text-sm">check</span> Saved!';
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    })
    .catch(err => {
        alert('Error saving layout');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function downloadAsImage() {
    const dataURL = canvas.toDataURL({
        format: 'png',
        quality: 1,
        multiplier: 2 // High Res
    });
    
    const link = document.createElement('a');
    link.download = 'IBSEA_Design_' + Date.now() + '.png';
    link.href = dataURL;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection
