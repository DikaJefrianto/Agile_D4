@extends('backend.layouts.app') {{-- Sesuaikan ini dengan layout dashboard admin Anda --}}

@section('title')
    {{ __('Tambah Strategi') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-white">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Tambah Panduan Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900 dark:border-red-700 dark:text-red-200" role="alert">
                <ul class="mt-3 list-disc list-inside text-sm text-red-600 dark:text-red-200">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-lg dark:bg-gray-800">
            <form action="{{ route('admin.guides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Panduan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500
                                      dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-emerald-400">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori (Opsional)</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500
                                      dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-emerald-400">
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500
                                        dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-emerald-400">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">File Panduan (PDF/DOC/DOCX/XLS/XLSX - Max 5MB) (Opsional)</label>
                        <input type="file" name="file" id="file"
                            class="mt-1  py-0,5 ps-3 block w-full text-sm
                                    border border-gray-300 rounded-md
                                    text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:text-sm file:font-semibold
                                    file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100
                                    dark:text-gray-400 dark:file:bg-emerald-800 dark:file:text-emerald-100 dark:hover:file:bg-emerald-700
                                    dark:border-gray-700">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">File utama yang akan tampil di daftar panduan.</p>
                    </div>
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gambar Thumbnail (JPG/PNG - Max 2MB) (Opsional)</label>
                        <input type="file" name="thumbnail" id="thumbnail"
                               class="mt-1  py-0,5 ps-3 block w-full text-sm
                                    border border-gray-300 rounded-md
                                    text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:text-sm file:font-semibold
                                    file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100
                                    dark:text-gray-400 dark:file:bg-emerald-800 dark:file:text-emerald-100 dark:hover:file:bg-emerald-700
                                    dark:border-gray-700">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Digunakan untuk tampilan galeri jika diaktifkan nanti.</p>
                    </div>
                    <div>
                        <label for="thumbnail_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alt Text Thumbnail (Opsional)</label>
                        <input type="text" name="thumbnail_alt" id="thumbnail_alt" value="{{ old('thumbnail_alt') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500
                                      dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-emerald-400">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.guides.index') }}" class="px-4 py-2 text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors">
                        Simpan Panduan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
