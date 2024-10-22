@props([
    'route' => 'home.index',
    'active' => false,
    'icon' => null,
])

<a href="{{route($route)}}" class="text-white hover:underline py-2 {{$active ? 'text-yellow-500 font-bold' : ''}}">
    @if($icon)
        <i class="fa fa-{{$icon}} mr-1"></i>
    @endif
    {{$slot}}
</a>
