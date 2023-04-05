@section('navbar')
@php
 $route = Route::current()->getName();
 $name = substr($route, 0, strpos($route, '.'));
@endphp
<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
        <ul style="font-size:95%;">
                <li class="label" >Administration</li>
            @foreach(config('menu') as $section=>$field) 
                    <li @if($name === $field['prefix']) class="active open" @endif><a class="sidebar-sub-toggle" ><i class="large material-icons">{{$field['icon']}}</i> {{$field['title']}} <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            @foreach($field['sub_menus'] as $part)
                        <li @if($route === $part['route']) class="active" @endif><a href="@if($part['route']){{route($part['route'])}}@endif">{{$part['title']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@section('js-content')
<script>

</script>
@endsection
@endsection