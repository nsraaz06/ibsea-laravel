@extends('layouts.admin')

@section('content')
<div class="p-10 shadow-sm xl:w-[80%] lg:w-[90%] md:w-full">
    <header class="mb-10">
        <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">{{ isset($adminRole) ? 'Edit Role' : 'Create New Role' }}</h2>
        <p class="text-slate-500 font-medium">Define access controls and permissions for this role.</p>
    </header>

    <form action="{{ isset($adminRole) ? route('admin.admin-roles.update', $adminRole->id) : route('admin.admin-roles.store') }}" method="POST" class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-8">
        @csrf
        @if(isset($adminRole))
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">Role Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $adminRole->name ?? '') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl px-6 py-4 font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-slate-400">
            @error('name')<p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-4 pb-4 border-b border-slate-100">Permissions Matrix</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($permissions as $key => $label)
                    <label class="flex items-start gap-4 p-5 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition-all cursor-pointer">
                        <div class="flex items-center h-6">
                            <input type="checkbox" name="permissions[]" value="{{ $key }}" 
                                {{ (is_array(old('permissions', $adminRole->permissions ?? [])) && in_array($key, old('permissions', $adminRole->permissions ?? []))) ? 'checked' : '' }}
                                class="w-5 h-5 text-primary bg-white border-slate-300 rounded focus:ring-primary focus:ring-2">
                        </div>
                        <div class="flex-1 mt-0.5">
                            <span class="font-bold text-slate-800 block text-sm">{{ $label }}</span>
                            <span class="text-slate-500 text-xs mt-1 block font-medium">Access module</span>
                        </div>
                    </label>
                @endforeach
            </div>
            @error('permissions')<p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end gap-4 pt-8 border-t border-slate-100">
            <a href="{{ route('admin.admin-roles.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition-colors font-bold text-xs uppercase tracking-widest">Cancel</a>
            <button type="submit" class="px-8 py-4 bg-primary text-white rounded-2xl hover:bg-primary/90 transition-colors font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:-translate-y-0.5">
                {{ isset($adminRole) ? 'Update Role' : 'Save Role' }}
            </button>
        </div>
    </form>
</div>
@endsection
