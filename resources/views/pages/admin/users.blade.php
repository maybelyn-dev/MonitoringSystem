@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-black text-slate-900">User Access</h1>
        <p class="text-slate-500 mt-2">Assign roles and agencies for predefined users.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
            <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] p-4 md:p-6 lg:p-8 shadow-sm border border-blue-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs md:text-sm">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-widest border-b border-slate-100">
                        <th class="pb-4 px-4 font-bold">Name</th>
                        <th class="pb-4 px-4 font-bold">Email</th>
                        <th class="pb-4 px-4 font-bold">Role</th>
                        <th class="pb-4 px-4 font-bold">Agency (Focal Only)</th>
                        <th class="pb-4 px-4 font-bold">Action</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @foreach ($users as $user)
                        <tr class="border-b border-slate-50 hover:bg-blue-50/30 transition" x-data="{ role: '{{ $user->role ?? 'focal' }}' }">
                            <td class="py-4 px-4 font-bold text-slate-800">{{ $user->name }}</td>
                            <td class="py-4 px-4">{{ $user->email }}</td>
                            <td class="py-4 px-4">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" x-model="role" class="w-40 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium">
                                        <option value="admin">Admin</option>
                                        <option value="focal">Focal</option>
                                        <option value="focal_viewer">Focal Viewer</option>
                                    </select>
                            </td>
                            <td class="py-4 px-4">
                                    <select name="agency_name" :disabled="role !== 'focal'" class="w-32 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium disabled:opacity-60">
                                        <option value="" {{ empty($user->agency_name) ? 'selected' : '' }}>--</option>
                                        <option value="DICT" {{ $user->agency_name === 'DICT' ? 'selected' : '' }}>DICT</option>
                                        <option value="PSA" {{ $user->agency_name === 'PSA' ? 'selected' : '' }}>PSA</option>
                                    </select>
                                    @if ($errors->has('agency_name') && session('errors')->getBag('default')->any())
                                        <p class="text-xs text-red-600 mt-1">{{ $errors->first('agency_name') }}</p>
                                    @endif
                            </td>
                            <td class="py-4 px-4">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
