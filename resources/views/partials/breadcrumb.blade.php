@php
    $segments = collect(request()->segments());
    $items = $segments->map(function ($seg, $i) use ($segments) {
        return [
            'label' => ucfirst(str_replace('-', ' ', $seg)),
            'url'   => url(implode('/', $segments->slice(0, $i+1)->all())),
        ];
    });
@endphp
@if($items->isNotEmpty())
<nav class="flex items-center text-sm text-slate-500 dark:text-slate-400 mb-4" aria-label="Breadcrumb">
    <a href="{{ url('/') }}" class="hover:text-primary-600 flex items-center gap-1">
        <i class="fas fa-house text-xs"></i> Home
    </a>
    @foreach($items as $it)
        <i class="fas fa-chevron-right text-[10px] mx-2 text-slate-300"></i>
        @if($loop->last)
            <span class="text-slate-800 dark:text-slate-200 font-semibold">{{ $it['label'] }}</span>
        @else
            <a href="{{ $it['url'] }}" class="hover:text-primary-600">{{ $it['label'] }}</a>
        @endif
    @endforeach
</nav>
@endif
