@extends('backend.layouts.app')

@section('title')
    {{ __('Kendaraans') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
  <div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-semibold">{{ __('Kendaraans') }}</h2>
    <a href="{{ route('kendaraans.create') }}" class="btn-primary">
      <i class="bi bi-plus-circle mr-2"></i> {{ __('New Kendaraan') }}
    </a>
  </div>
  <div class="rounded-2xl border bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-x-auto">
    @include('backend.layouts.partials.messages')
    <table class="w-full">
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <th class="p-2">{{ __('Sl') }}</th>
          <th class="p-2">{{ __('Jenis') }}</th>
          <th class="p-2">{{ __('Bahan Bakar') }}</th>
          <th class="p-2">{{ __('Efisiensi (km/L)') }}</th>
          <th class="p-2">{{ __('Action') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($kendaraans as $item)
        <tr class="border-b">
          <td class="p-2">{{ $loop->iteration }}</td>
          <td class="p-2">{{ $item->jenis }}</td>
          <td class="p-2">{{ $item->bahanBakar->nama }}</td>
          <td class="p-2">{{ $item->efisiensi_km_per_liter }}</td>
          <td class="p-2 flex gap-2">
            <a href="{{ route('kendaraans.edit', $item) }}" class="btn-default !p-2"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('kendaraans.destroy', $item) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger !p-2"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-4">{{ __('No kendaraan found') }}</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="my-4 px-4">{{ $kendaraans->links() }}</div>
  </div>
</div>
@endsection
