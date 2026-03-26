@props([
    'variant' => 'primary',
    'size' => 'sm',
    'icon' => null,
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-[#050505]';
    $sizeClasses = match ($size) {
        'xs' => 'text-[11px] px-2.5 py-1.5',
        'sm' => 'text-xs px-3 py-2',
        'md' => 'text-sm px-4 py-2.5',
        'lg' => 'text-base px-5 py-3',
        default => 'text-xs px-3 py-2',
    };
    $variantClasses = match ($variant) {
        'create' => 'bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] text-[#050505] hover:from-[#00FFB2] hover:to-[#36D7FF] focus-visible:ring-[#00FFA3]/60 shadow-[0_0_18px_rgba(0,255,163,0.35)]',
        'view' => 'bg-[#111111] text-slate-200 border border-white/10 hover:border-[#00FFA3]/40 hover:text-white focus-visible:ring-[#00FFA3]/40',
        'edit' => 'bg-[#111111] text-[#00D1FF] border border-[#00D1FF]/40 hover:border-[#00D1FF]/70 focus-visible:ring-[#00D1FF]/50 shadow-[0_0_14px_rgba(0,209,255,0.25)]',
        'archive' => 'bg-[#111111] text-rose-300 border border-rose-400/40 hover:border-rose-300/70 focus-visible:ring-rose-400/40 shadow-[0_0_14px_rgba(248,113,113,0.25)]',
        'ghost' => 'bg-transparent text-slate-400 hover:text-white hover:bg-white/5 focus-visible:ring-white/10',
        default => 'bg-gradient-to-r from-[#00FFA3] to-[#7C5CFF] text-[#050505] hover:from-[#00FFB2] hover:to-[#8A6BFF] focus-visible:ring-[#00FFA3]/60 shadow-[0_0_18px_rgba(0,255,163,0.35)]',
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
