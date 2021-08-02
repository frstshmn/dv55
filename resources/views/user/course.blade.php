@extends('layouts.layout')

@section('title', $course->title)

@section('content')
<div class="row background-light-grey w-100 m-0 color-dark-grey">
    <div class="col-2 neuro-card p-0" id="sidebar">
        <div id="total" class="px-4 pb-4 pt-2 text-center">
            <a href="/cabinet" class="small font-weight-bold color-dark-grey"><span class="iconify" data-icon="eva:arrow-left-fill" data-inline="false"></span> Back to courses</a>
            <div class="pie mx-auto shadow mt-4" style="background-image: linear-gradient(230deg, transparent 50%, #041E42 50%), linear-gradient(90deg, #e0e0e0 50%, transparent 50%);">
                <h5 class="text-center pie-inner justify-content-center d-flex flex-column 9align-items-center">
                    <div class="font-weight-bold">{{$course->title}}</div>
                    <div class="small">75%</div>
                </h5>
            </div>
        </div>

        <div id="accordion" role="tablist" class="px-3">
            @foreach ($course->modules as $module)
                <div class="my-3">
                    <div class="px-1" role="tab">
                        <h6 class="mb-0 py-3 text-overflow-ellipsis"><a class="collapsed" data-toggle="collapse" href="#module_{{$module->id}}" aria-expanded="true" aria-controls="module_{{$module->id}}"><span class="iconify" data-icon="codicon:file-submodule" data-inline="false"></span> <span class="small">{{$module->title}}</span></a></h6>
                    </div>
                    <div id="module_{{$module->id}}" class="collapse" role="tabpanel">
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-2 neuro-card p-0 justify-content-center align-items-center text-center d-none" id="sidebar_thumb">
        <span class="iconify color-dark-grey h1" data-icon="ic:baseline-lock" data-inline="false"></span>
    </div>
    <div class="offset-2 col-10 py-2 px-4 d-block" id="material_content">
    </div>
    <div class="offset-2 col-10 py-2 px-4 d-none justify-content-center vh-100 align-items-center" id="material_content_loader">
        <span class="iconify display-1" data-icon="eos-icons:three-dots-loading" data-inline="false"></span>
    </div>
</div>

@endsection
