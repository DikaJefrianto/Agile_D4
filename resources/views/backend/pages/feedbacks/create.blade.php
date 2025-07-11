@extends('backend.layouts.app')

@section('title')
    {{ __('Feedback Create') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div x-data="{ pageName: '{{ __('New Feedback') }}' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('New Feedback') }}</h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                            {{ __('Home') }}<i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.feedbacks.index') }}">
                            {{ __('Feedbacks') }}<i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">{{ __('New Feedback') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Create New Feedback') }}</h3>
            </div>
            <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                @include('backend.layouts.partials.messages')

                <form action="{{ route('admin.feedbacks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- Kategori --}}
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Kategori') }}</label>
                            <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" required
                                placeholder="{{ __('Enter Feedback Category') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                        {{-- </div>
                        {{-- Lampiran --}}
                        {{-- <div>
                            <label for="lampiran" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Lampiran (opsional)') }}</label>
                            <input type="file" name="lampiran" id="lampiran"
                                class="mt-1 block w-full text-gray-700 dark:text-gray-300">
                        </div> --}} 
                        {{-- Perusahaan --}}
                        {{-- <div>
                            <label for="perusahaan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Pilih Perusahaan') }}</label>
                            <select name="perusahaan_id" id="perusahaan_id" required
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                <option value="">{{ __('Select Perusahaan') }}</option>
                                @foreach($perusahaans as $perusahaan)
                                    <option value="{{ $perusahaan->id }}" {{ old('perusahaan_id') == $perusahaan->id ? 'selected' : '' }}>
                                        {{ $perusahaan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- Deskripsi --}}
                        <div class="sm:col-span-2">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Deskripsi') }}</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" required
                                placeholder="{{ __('Write your feedback...') }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                       text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="">
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('admin.feedbacks.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </div>

                    {{-- Buttons --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
