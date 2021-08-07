<ul type="none" class="ml-4">
    @foreach ($module->materials as $material)
        @if ($material->isChecked())
            <li class="material text-overflow-ellipsis text-muted" data-id="{{$material->id}}"><span class="iconify h6 my-2 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">{{$material->title}}</span></li>
        @else
            <li class="material text-overflow-ellipsis" data-id="{{$material->id}}"><span class="iconify h6 my-2 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">{{$material->title}}</span></li>
        @endif
    @endforeach

    @php $i = 1; @endphp
    @foreach ($module->tests as $test)
        @if ($i > 1)
            @if ($test->isAnswered())
                @if ($test->isCompleted())
                    <li class="test text-overflow-ellipsis text-success" data-id="{{$test->id}}"><span class="iconify h5 my-2 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Additional test</span></li>
                    @break
                @else
                    <li class="test text-overflow-ellipsis text-danger" data-id="{{$test->id}}"><span class="iconify h5 my-2 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Additional test</span></li>
                @endif
            @else
                <li class="test text-overflow-ellipsis" data-id="{{$test->id}}"><span class="iconify h5 my-2 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Additional test</span></li>
                @break
            @endif
        @else
            @if ($test->isAnswered())
                @if ($test->isCompleted())
                    <li class="test text-overflow-ellipsis text-success" data-id="{{$test->id}}"><span class="iconify h5 my-2 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Test</span></li>
                    @break
                @else
                    <li class="test text-overflow-ellipsis text-danger" data-id="{{$test->id}}"><span class="iconify h5 my-2 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Test</span></li>
                @endif
            @else
                <li class="test text-overflow-ellipsis" data-id="{{$test->id}}"><span class="iconify h5 my-2 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Test</span></li>
                @break
            @endif
        @endif
        @php $i++; @endphp
    @endforeach
</ul>
