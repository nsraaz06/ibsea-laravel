@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">Define Institutional Role</h2>
            <p class="text-slate-500 font-semibold">Add a new strategic designation to the IBSEA leadership hierarchy.</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
            Back to Role Manager
        </a>
    </header>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-6 rounded-3xl mb-8 border border-red-100">
            <h3 class="font-black uppercase text-xs tracking-widest mb-2 flex items-center gap-2">
                <span class="material-icons text-sm">error</span> Validation Failed
            </h3>
            <ul class="list-disc pl-5 text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100 max-w-4xl">
        <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Designation Name</label>
                    <input type="text" name="role_name" value="{{ old('role_name') }}" required placeholder="e.g. Strategic Advisor" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Hierarchy Level (Lower = Higher Rank)</label>
                    <input type="number" name="hierarchy_level" value="{{ old('hierarchy_level', 1) }}" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2 px-1">1: Founder, 2: Council, 3: Chapter Lead...</p>
                </div>
            </div>

            <div class="bg-slate-50 p-8 rounded-3xl space-y-4">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Platform Intelligence & Visibility</h4>
                
                <label class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-100 cursor-pointer hover:border-primary transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                            <span class="material-icons text-sm">visibility</span>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-800 uppercase tracking-widest">Show in Leadership Hub</div>
                            <div class="text-[9px] font-semibold text-slate-400 mt-0.5">Allow public viewing of members assigned to this role.</div>
                        </div>
                    </div>
                    <input type="hidden" name="show_in_leadership" value="0">
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_in_leadership" value="1" {{ old('show_in_leadership', true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </div>
                </label>

                <div class="pt-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Designation Display Pattern</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                        @foreach([
                            'automatic' => 'Automatic (Chapter & Council)',
                            'alliance' => 'Alliance Focused',
                            'chapter' => 'Chapter Only',
                            'council' => 'Council Only',
                            'designation' => 'Designation Only'
                        ] as $value => $label)
                        <label class="relative flex items-center p-4 bg-white rounded-2xl border border-slate-100 cursor-pointer hover:border-primary group transition-all">
                            <input type="radio" name="card_display_pattern" value="{{ $value }}" {{ old('card_display_pattern', 'automatic') == $value ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-full">
                                <span class="text-[10px] font-bold text-slate-800 uppercase tracking-tight group-hover:text-primary transition-colors">{{ $label }}</span>
                            </div>
                            <div class="hidden peer-checked:block">
                                <span class="material-icons text-primary text-sm">check_circle</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-8 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-3xl font-bold text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-3">
                    Authorize Designation <span class="material-icons text-sm">verified_user</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
