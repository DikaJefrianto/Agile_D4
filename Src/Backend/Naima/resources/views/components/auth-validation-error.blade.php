<!-- filepath: resources/views/components/auth-validation-errors.blade.php -->
@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4 text-sm text-red-600']) }}>
        <ul class="list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
