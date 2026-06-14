@props([
'href' => '#',
])

<a href="{{ $href }}"
    {{ $attributes->merge([
       'class' => "px-4 py-2 rounded-lg transition items-center gap-2 text-sm font-medium " . $getStyle()
   ]) }}>

    @if($icon)
    <i class="{{ $icon }}"></i>
    @endif

    {{ $slot }}
</a>