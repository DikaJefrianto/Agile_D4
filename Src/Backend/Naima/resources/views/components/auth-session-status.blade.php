@props(['status'])

@if (session('status'))
    <div {{ $attributes->merge(['class' => 'mb-4 text-sm text-green-600']) }}>
        {{ session('status') }}
    </div>
@endif
