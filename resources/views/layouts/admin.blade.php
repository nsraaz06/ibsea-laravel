<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'IBSEA Admin | Mission Control' }}</title>
    
    <!-- IBSEA Design System Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#004a95',
                        accent: '#f26f21',
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
                    }
                }
            }
        }
    </script>
    
    <!-- Immediate Assets & Tailwind CDN Fallback -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- IBSEA Design System Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@400;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
    <style>
        :root {
            --primary: #004a95;
            --accent: #f26f21;
        }
        body { font-family: 'Inter', 'Montserrat', sans-serif; }
        .stat-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-card:hover { transform: translateY(-5px); }
        
        /* Institutional Utility Overrides */
        .bg-primary { background-color: var(--primary) !important; }
        .text-primary { color: var(--primary) !important; }
        .bg-accent { background-color: var(--accent) !important; }
        .text-accent { color: var(--accent) !important; }
        .border-primary { border-color: var(--primary) !important; }
        .border-accent { border-color: var(--accent) !important; }
        .shadow-primary\/20 { --tw-shadow-color: rgba(0, 74, 149, 0.2); --tw-shadow: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color); }
    </style>
    @stack('styles')
</head>
<body class="bg-ibsea-background text-slate-900 transition-colors duration-300">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 z-50" style="background-color: #004a95;">
        <div class="p-8 pb-12">
            <h1 class="text-white text-2xl font-black flex items-center gap-2">
                <span class="material-icons text-3xl" style="color: #f26f21;">account_balance</span>
                IBSEA
            </h1>
            <p class="text-[10px] text-slate-300 font-bold uppercase tracking-widest mt-1">Admin Portal</p>
        </div>
        
        <nav class="space-y-2 px-4 overflow-y-auto h-[calc(100vh-200px)]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.dashboard') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.dashboard') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.dashboard') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.dashboard') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">dashboard</span>
                Dashboard
            </a>
            
            @if(auth('admin')->user()->hasPermission('manage_members'))
            <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.members.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.members.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.members.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.members.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">groups</span>Directory
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_roles'))
            <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.roles.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.roles.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.roles.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.roles.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">admin_panel_settings</span>Role Manager
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_plans'))
            <a href="{{ route('admin.plans.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.plans.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.plans.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.plans.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.plans.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">workspace_premium</span>Plans Hub
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.coupons.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.coupons.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.coupons.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.coupons.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">confirmation_number</span>Coupon Hub
            </a>
            @endif
            @if(auth('admin')->user()->hasPermission('manage_communication'))
            <a href="{{ route('admin.communication.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.communication.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.communication.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.communication.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.communication.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">send</span>
                Communication
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_posts'))
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.posts.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.posts.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.posts.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.posts.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">article</span>
                News & Blog
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_chapters'))
            <a href="{{ route('admin.chapters.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.chapters.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.chapters.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.chapters.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.chapters.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">map</span>
                Chapters
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_events'))
            <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.events.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.events.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.events.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.events.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">event</span>
                Events
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_initiatives'))
            <a href="{{ route('admin.initiatives.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.initiatives.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.initiatives.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.initiatives.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.initiatives.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">flag</span>
                Initiatives
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_design_templates'))
            <a href="{{ route('admin.design-templates.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.design-templates.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.design-templates.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.design-templates.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.design-templates.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">palette</span>
                Design Templates
            </a>
            @endif

            <!-- Form Builder Sub-menu -->
            @if(auth('admin')->user()->hasPermission('manage_forms'))
            <div x-data="{ open: {{ Request::routeIs('admin.forms.*') || Request::routeIs('admin.submissions.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.forms.*') || Request::routeIs('admin.submissions.*') ? 'font-semibold shadow-lg bg-primary/10 text-white' : 'text-slate-300' }}" style="{{ Request::routeIs('admin.forms.*') || Request::routeIs('admin.submissions.*') ? 'color: white;' : 'color: #cbd5e1;' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-icons">dynamic_form</span>
                        Form Builder
                    </div>
                    <span class="material-icons text-sm transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition class="mt-2 ml-6 space-y-1 border-l-2 border-white/10 pl-4">
                    <a href="{{ route('admin.forms.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.forms.*') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Manage Protocols
                    </a>
                    <a href="{{ route('admin.submissions.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.submissions.*') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Intelligence Log
                    </a>
                </div>
            </div>
            @endif

            {{-- Email Campaigns --}}
            @if(auth('admin')->user()->hasPermission('manage_email_campaigns'))
            <div x-data="{ open: {{ Request::routeIs('admin.email-templates.*') || Request::routeIs('admin.email-campaigns.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.email-templates.*') || Request::routeIs('admin.email-campaigns.*') ? 'font-semibold shadow-lg bg-primary/10 text-white' : 'text-slate-300' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-icons">campaign</span>
                        Email Campaigns
                    </div>
                    <span class="material-icons text-sm transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition class="mt-2 ml-6 space-y-1 border-l-2 border-white/10 pl-4">
                    <a href="{{ route('admin.email-campaigns.compose') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.email-campaigns.compose') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Compose
                    </a>
                    <a href="{{ route('admin.email-templates.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.email-templates.*') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Templates
                    </a>
                    <a href="{{ route('admin.email-campaigns.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.email-campaigns.index') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Send History
                    </a>
                </div>
            </div>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_bulk_import'))
            <a href="{{ route('admin.bulk-import') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.bulk-import') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.bulk-import') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.bulk-import') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.bulk-import') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">upload_file</span>
                Bulk Import
            </a>
            @endif
            <!-- Resource Management Sub-menu -->
            @if(auth('admin')->user()->hasPermission('manage_resources'))
            <div x-data="{ open: {{ Request::routeIs('admin.resources.*') || Request::routeIs('admin.resource-categories.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.resources.*') || Request::routeIs('admin.resource-categories.*') ? 'font-semibold shadow-lg bg-primary/10 text-white' : 'text-slate-300' }}" style="{{ Request::routeIs('admin.resources.*') || Request::routeIs('admin.resource-categories.*') ? 'color: white;' : 'color: #cbd5e1;' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-icons">inventory_2</span>
                        Resource Hub
                    </div>
                    <span class="material-icons text-sm transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition class="mt-2 ml-6 space-y-1 border-l-2 border-white/10 pl-4">
                    <a href="{{ route('admin.resources.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.resources.index') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Manage Dossiers
                    </a>
                    <a href="{{ route('admin.resource-categories.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.resource-categories.*') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Sector Intelligence
                    </a>
                </div>
            </div>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_gallery'))
            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.gallery.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.gallery.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.gallery.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.gallery.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">photo_library</span>
                Asset Gallery
            </a>
            @endif

            @if(($siteSettings['allow_course_cms'] ?? '0') == '1' && auth('admin')->user()->hasPermission('manage_courses'))
            <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.courses.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.courses.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.courses.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.courses.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">school</span>
                Learning Hub
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_analytics'))
            <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.analytics.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.analytics.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.analytics.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.analytics.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">trending_up</span>
                Sales Analytics
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_referrals'))
            <a href="{{ route('admin.referrals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.referrals.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.referrals.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.referrals.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.referrals.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                <span class="material-icons">hub</span>
                Referral Network
            </a>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_settings'))
            <div x-data="{ open: {{ Request::routeIs('admin.settings.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.settings.*') ? 'font-semibold shadow-lg bg-primary/10 text-white' : 'text-slate-300' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-icons">settings</span>
                        Portal Settings
                    </div>
                    <span class="material-icons text-sm transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition class="mt-2 ml-6 space-y-1 border-l-2 border-white/10 pl-4">
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.settings.index') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        General Config
                    </a>
                    <a href="{{ route('admin.settings.payment') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ Request::routeIs('admin.settings.payment') ? 'text-accent' : 'text-slate-400 hover:text-white' }}">
                        Payment Gateways
                    </a>
                </div>
            </div>
            @endif

            @if(auth('admin')->user()->hasPermission('manage_system'))
            <div class="pt-6 mt-4 border-t border-white/10">
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4 px-4">System Administration</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.admin-roles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.admin-roles.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.admin-roles.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.admin-roles.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.admin-roles.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                        <span class="material-icons">admin_panel_settings</span>
                        Staff Roles
                    </a>
                    <a href="{{ route('admin.admin-users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ Request::routeIs('admin.admin-users.*') ? 'font-semibold shadow-lg' : '' }}" style="{{ Request::routeIs('admin.admin-users.*') ? 'background-color: #f26f21; color: white;' : 'color: #cbd5e1;' }}" onmouseover="if(!'{{ Request::routeIs('admin.admin-users.*') }}') { this.style.backgroundColor='rgba(0,74,149,0.4)'; this.style.color='white'; }" onmouseout="if(!'{{ Request::routeIs('admin.admin-users.*') }}') { this.style.backgroundColor=''; this.style.color='#cbd5e1'; }">
                        <span class="material-icons">manage_accounts</span>
                        Staff Accounts
                    </a>
                </div>
            </div>
            @endif
            
            <div class="pt-6 px-4">
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4">Account</p>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all">
                        <span class="material-icons">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 min-h-screen">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
