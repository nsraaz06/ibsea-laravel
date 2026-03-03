@extends('layouts.admin')

@section('content')
<div class="p-10 shadow-sm xl:w-[80%] lg:w-[90%] md:w-full">
    <header class="mb-10">
        <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">{{ isset($adminUser) ? 'Edit Staff Account' : 'Create New Staff Account' }}</h2>
        <p class="text-slate-500 font-medium">Configure credentials and role assignment securely.</p>
    </header>

    <form action="{{ isset($adminUser) ? route('admin.admin-users.update', $adminUser->id) : route('admin.admin-users.store') }}" method="POST" class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-8">
        @csrf
        @if(isset($adminUser))
            @method('PUT')
        @endif

        @if(isset($adminUser) && $adminUser->is_superadmin)
            <div class="bg-amber-50 border border-amber-200 text-amber-700 px-6 py-5 rounded-2xl flex items-start gap-4 shadow-inner">
                <span class="material-icons text-3xl mt-0.5 text-amber-500">security_update_warning</span>
                <div>
                    <strong class="block mb-1 font-black text-amber-800 uppercase tracking-wide">Superadmin Root Profile</strong>
                    <p class="text-sm font-medium">This account overrides all role-based restrictions. Role assignment modification is disabled.</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username', $adminUser->username ?? '') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl px-6 py-4 font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-slate-400">
                @error('username')<p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $adminUser->email ?? '') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl px-6 py-4 font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-slate-400">
                @error('email')<p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>@enderror
            </div>

            @if(!isset($adminUser) || !$adminUser->is_superadmin)
            <div class="md:col-span-2 relative">
                <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">Assign Role <span class="text-red-500">*</span></label>
                <select name="admin_role_id" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl px-6 py-4 font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all appearance-none cursor-pointer">
                    <option value="" disabled selected>Select a specific access role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ (old('admin_role_id', $adminUser->admin_role_id ?? '') == $role->id) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-6 top-[2.5rem] flex items-center text-slate-400">
                    <span class="material-icons">expand_more</span>
                </div>
                @error('admin_role_id')<p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>@enderror
            </div>
            @endif
        </div>
        
        <div class="pt-8 border-t border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 flex items-center gap-2"><span class="material-icons text-slate-400">lock</span> {{ isset($adminUser) ? 'Update Password (Optional)' : 'Set Password' }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">Password {!! !isset($adminUser) ? '<span class="text-red-500">*</span>' : '' !!}</label>
                    <input type="password" name="password" {{ !isset($adminUser) ? 'required' : '' }} class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl px-6 py-4 font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-slate-400" placeholder="{{ isset($adminUser) ? 'Leave blank to keep current' : 'Enter secure password' }}">
                    @error('password')<p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">Confirm Password {!! !isset($adminUser) ? '<span class="text-red-500">*</span>' : '' !!}</label>
                    <input type="password" name="password_confirmation" {{ !isset($adminUser) ? 'required' : '' }} class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-2xl px-6 py-4 font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-slate-400" placeholder="{{ isset($adminUser) ? 'Leave blank to keep current' : 'Confirm password' }}">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-8 border-t border-slate-100">
            <a href="{{ route('admin.admin-users.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition-colors font-bold text-xs uppercase tracking-widest">Cancel</a>
            <button type="submit" class="px-8 py-4 bg-primary text-white rounded-2xl hover:bg-primary/90 transition-colors font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:-translate-y-0.5">
                {{ isset($adminUser) ? 'Update Account' : 'Create Account' }}
            </button>
        </div>
    </form>
</div>
@endsection
