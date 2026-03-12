<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
        </div>
        <div class="p-3 rounded-full {{ $iconBgClass ?? 'bg-blue-100' }}">
            @if(isset($icon))
                {!! $icon !!}
            @else
                <svg class="w-6 h-6 {{ $iconClass ?? 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            @endif
        </div>
    </div>
    @if(isset($subtitle))
        <p class="text-sm text-gray-500 mt-2">{{ $subtitle }}</p>
    @endif
</div>

