<div class="container mt-5">
    @php echo($material->code) @endphp
</div>

@if ($test != NULL || !empty($next_material))
    <div class="container p-5 d-flex justify-content-center">
        @if(!empty($next_material))
            <button class="button px-5 next-material" data-next="{{$next_material->id}}" data-current="{{$material->id}}" data-module="{{$material->module->id}}" data-user="{{Auth::user()->id}}">Перейти до наступної теми: <em>{{$next_material->title}}</em> <span class="m-0 h4 iconify" data-icon="ic:round-navigate-next" data-inline="false"></span></button>
        @else
            <button class="button px-5 next-test" data-next="{{$test->id}}" data-current="{{$material->id}}" data-module="{{$material->module->id}}" data-user="{{Auth::user()->id}}">Перейти до тесту <span class="m-0 h4 iconify" data-icon="ic:round-navigate-next" data-inline="false"></span></button>
        @endif
    </div>
@else
    <div class="container p-5 d-flex justify-content-center font-italic color-grey">
        Кінець модулю
    </div>
@endif


