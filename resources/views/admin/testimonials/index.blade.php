@extends('layouts.admin')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-black text-secondary tracking-tight">Ecosystem Voices</h2>
            <p class="text-slate-500 font-medium mt-1">Manage member testimonials displayed on the homepage.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="bg-accent text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-600 transition-all flex items-center gap-2 shadow-action">
            <span class="material-icons">add</span> Add Testimonial
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-500">
                        <th class="p-4 font-black">Member Info</th>
                        <th class="p-4 font-black">Content</th>
                        <th class="p-4 font-black text-center">Status</th>
                        <th class="p-4 font-black text-center">Sort Order</th>
                        <th class="p-4 font-black text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($testimonials as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-secondary text-sm">{{ $item->name }}</p>
                                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">{{ $item->designation }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="text-sm text-slate-600 line-clamp-2 max-w-sm" title="{{ $item->content }}">
                                    "{{ Str::limit($item->content, 100) }}"
                                </p>
                            </td>
                            <td class="p-4 text-center">
                                @if($item->is_active)
                                    <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-[10px] uppercase tracking-wider">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-700 font-bold px-3 py-1 rounded-full text-[10px] uppercase tracking-wider">Hidden</span>
                                @endif
                            </td>
                            <td class="p-4 text-center text-sm font-bold text-slate-600">
                                {{ $item->sort_order }}
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.testimonials.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors">
                                        <span class="material-icons text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors">
                                            <span class="material-icons text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <span class="material-icons text-5xl mb-4 opacity-50">forum</span>
                                <p class="font-bold uppercase tracking-widest text-xs">No voices added yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
