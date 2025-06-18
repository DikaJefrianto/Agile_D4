@extends('backend.layouts.app')

@section('title')
    {{ __('Feedbacks') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
  <div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-semibold">{{ __('Feedbacks') }}</h2>
    <a href="{{ route('admin.feedbacks.create') }}" class="btn-primary">
      <i class="bi bi-plus-circle mr-2"></i> {{ __('New Feedback') }}
    </a>
  </div>
  <div class="rounded-2xl border bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-x-auto">
    @include('backend.layouts.partials.messages')
    <table class="w-full text-sm">
      <thead class="bg-gray-50 dark:bg-gray-800 text-left">
        <tr>
          <th class="p-3">{{ __('NO') }}</th>
          <th class="p-3">{{ __('Kategori') }}</th>
          <th class="p-3">{{ __('Deskripsi') }}</th>
          <th class="p-3">{{ __('Action') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($feedbacks as $item)
        <tr class="border-b">
          <td class="p-3">{{ $loop->iteration }}</td>
          <td class="p-3">{{ $item->kategori }}</td>
          <td class="p-3">{{ Str::limit($item->deskripsi, 50) }}</td>
          <td class="p-3">
            <form action="{{ route('admin.feedbacks.destroy', $item) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-danger !p-2"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center py-4">{{ __('No feedback found') }}</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
s