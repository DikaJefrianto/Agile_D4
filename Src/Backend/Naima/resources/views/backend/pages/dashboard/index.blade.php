@extends('backend.layouts.app')

@section('title')
    {{ __('Dashboard') }} | {{ config('app.name') }}
@endsection

@section('before_vite_build')
    <script>
        var userGrowthData = @json($user_growth_data['data']);
        var userGrowthLabels = @json($user_growth_data['labels']);
    </script>
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Dashboard') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Dashboard') }}</h2>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-4 md:gap-6">
                    @include('backend.pages.dashboard.partials.card', [
                        'icon_svg' => asset('images/icons/user.svg'),
                        'label' => __('Users'),
                        'value' => $total_users,
                        'bg' => '#635BFF',
                        'class' => 'bg-white',
                        'url' => route('admin.users.index'),
                    ])
                    @include('backend.pages.dashboard.partials.card', [
                        'icon_svg' => asset('images/icons/key.svg'),
                        'label' => __('Roles'),
                        'value' => $total_roles,
                        'bg' => '#00D7FF',
                        'class' => 'bg-white',
                        'url' => route('admin.roles.index'),
                    ])
                    @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-shield-check',
                        'label' => __('Permissions'),
                        'value' => $total_permissions,
                        'bg' => '#FF4D96',
                        'class' => 'bg-white',
                        'url' => route('admin.permissions.index'),
                    ])
                    @include('backend.pages.dashboard.partials.card', [
                        'icon' => 'bi bi-translate',
                        'label' => __('Translations'),
                        'value' => $languages['total'] . ' / ' . $languages['active'],
                        'bg' => '#22C55E',
                        'class' => 'bg-white',
                        'url' => route('admin.translations.index'),
                    ])
                </div>
            </div>
        </div>

        {{-- ✨ Tambahan: Menu CRUD --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">{{ __('Quick Access to CRUD Modules') }}</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @php
                    $crudModules = [
                        ['label' => 'Perusahaans', 'route' => 'admin.perusahaans.index', 'icon' => 'bi bi-buildings', 'color' => '#0EA5E9'],
                        ['label' => 'Karyawans', 'route' => 'admin.karyawans.index', 'icon' => 'bi bi-person-badge', 'color' => '#9333EA'],
                        ['label' => 'Strategis', 'route' => 'admin.strategis.index', 'icon' => 'bi bi-lightbulb', 'color' => '#F59E0B'],
                        ['label' => 'Bahan Bakars', 'route' => 'admin.bahan-bakars.index', 'icon' => 'bi bi-fuel-pump', 'color' => '#EF4444'],
                        ['label' => 'Kendaraans', 'route' => 'admin.kendaraans.index', 'icon' => 'bi bi-truck-front', 'color' => '#10B981'],
                        ['label' => 'Feedbacks', 'route' => 'admin.feedbacks.index', 'icon' => 'bi bi-chat-left-text', 'color' => '#3B82F6'],
                        ['label' => 'Perjalanan Dinas', 'route' => 'admin.perjalanan-dinas.index', 'icon' => 'bi bi-geo-alt', 'color' => '#8B5CF6'],
                        ['label' => 'Perhitungans', 'route' => 'admin.perhitungans.index', 'icon' => 'bi bi-calculator', 'color' => '#F97316'],
                    ];
                @endphp

                @foreach ($crudModules as $modul)
                    <a href="{{ route($modul['route']) }}" class="rounded-xl p-4 text-white shadow hover:shadow-md transition-all duration-200 flex items-center gap-3" style="background-color: {{ $modul['color'] }}">
                        <i class="{{ $modul['icon'] }} text-xl"></i>
                        <span class="text-sm font-semibold">{{ __($modul['label']) }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Grafik & History --}}
        <div class="mt-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
                <div class="col-span-12">
                    <div class="grid grid-cols-12 gap-4 md:gap-6">
                        <div class="col-span-12 md:col-span-8">
                            @include('backend.pages.dashboard.partials.user-growth')
                        </div>
                        <div class="col-span-12 md:col-span-4">
                            @include('backend.pages.dashboard.partials.user-history')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
