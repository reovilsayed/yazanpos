<li class="">
    {{-- current-menu-item --}}
    <a href="{{ $href }}" class="{{$active ?? null}}">
        <i class="{{$active ?? null}}">
            <img src="{{ $icon[0] }}" alt="" />
            <img src="{{ $icon[1] }}" alt="" />
        </i>
        <span>{{ $name }}</span>
    </a>
</li>
