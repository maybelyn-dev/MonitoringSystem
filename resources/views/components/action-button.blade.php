@props([
    'variant' => 'primary',
    'size' => 'sm',
    'icon' => null,
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';
    $sizeClasses = match ($size) {
        'xs' => 'text-[11px] px-2.5 py-1.5',
        'sm' => 'text-xs px-3 py-2',
        'md' => 'text-sm px-4 py-2.5',
        'lg' => 'text-base px-5 py-3',
        default => 'text-xs px-3 py-2',
    };
    $variantClasses = match ($variant) {
        'create' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus-visible:ring-emerald-300 shadow-sm shadow-emerald-200',
        'view' => 'bg-slate-100 text-slate-700 hover:bg-slate-200 focus-visible:ring-slate-300',
        'edit' => 'bg-amber-500 text-white hover:bg-amber-600 focus-visible:ring-amber-300 shadow-sm shadow-amber-200',
        'archive' => 'bg-rose-600 text-white hover:bg-rose-700 focus-visible:ring-rose-300 shadow-sm shadow-rose-200',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 focus-visible:ring-slate-200',
        default => 'bg-blue-600 text-white hover:bg-blue-700 focus-visible:ring-blue-300 shadow-sm shadow-blue-200',
    };
    $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <i class="{{ $icon }} text-[0.9em]"></i>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <i class="{{ $icon }} text-[0.9em]"></i>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
