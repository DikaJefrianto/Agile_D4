@extends('backend.layouts.app')

@section('title')
    {{ __('Strategis') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
  <div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-semibold">{{ __('Strategis') }}</h2>
    <a href="{{ route('strategis.create') }}" class="btn-primary">
      <i class="bi bi-plus-circle mr-2"></i> {{ __('New Strategi') }}
    </a>
  </div>

  <div class="rounded-2xl border bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
      @include('backend.layouts.partials.messages')
      <table class="w-full">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th class="p-2">{{ __('Sl') }}</th>
            <th class="p-2">{{ __('Judul') }}</th>
            <th class="p-2">{{ __('Deskripsi') }}</th>
            <th class="p-2">{{ __('Action') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse($strategis as $item)
          <tr class="border-b">
            <td class="p-2">{{ $loop->iteration }}</td>
            <td class="p-2">{{ $item->judul }}</td>
            <td class="p-2">{{ Str::limit($item->deskripsi, 50) }}</td>
            <td class="p-2 flex gap-2">
              <a href="{{ route('strategis.edit', $item) }}" class="btn-default !p-2"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('strategis.destroy', $item) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger !p-2"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center py-4">{{ __('No strategi found') }}</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="my-4 px-4">{{ $strategis->links() }}</div>
    </div>
  </div>
</div>
@endsection
