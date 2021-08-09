@extends('layouts.layout')

@section('title', $course->title)

@section('content')


<div class="row background-light-grey w-100 m-0 color-dark-grey">
    <div class="show-menu neuro-card d-md-none d-flex justify-content-center align-items-center shadow z-index-99" onclick="$('#sidebar').toggleClass('active');">
        <span class="iconify h5 m-0" data-icon="icon-park-outline:hamburger-button"></span>
    </div>
    <div class="col-lg-2 neuro-card p-0" id="sidebar">
        <div id="total" class="px-4 pb-4 pt-2 text-center background-gradient shadow" data-course="{{$course->id}}">
            <a href="/cabinet" class="small font-weight-bold color-light-grey d-md-block d-none pt-3"><span class="iconify" data-icon="eva:arrow-left-fill" data-inline="false"></span>Back to courses</a>
            <div class="d-flex flex-row justify-content-between d-md-none pt-3">
                <a href="/cabinet" class="small font-weight-bold color-light-grey "><span class="iconify" data-icon="eva:arrow-left-fill" data-inline="false"></span>Back</a>
                <a class="small font-weight-bold color-light-grey" onclick="$('#sidebar').toggleClass('active');">Hide<span class="iconify ml-1" data-icon="ci:hide" data-inline="false"></span></a>
            </div>
            <div class=" mx-auto mt-4 text-white text-left">
                <div class="font-weight-bold text-center">{{$course->title}}</div>
                <div class="small mt-4">{{ $course->totalScore(Auth::user()->id) }}%</div>
                <div class="progress-wrapper rounded-corner">
                    <div class="progress-bar" style="width: {{ $course->totalScore(Auth::user()->id) }}%"></div>
                </div>
            </div>
        </div>

        <div id="accordion" role="tablist" class="px-3">
            @foreach ($course->modules as $module)
                <div class="my-3">
                    <div class="px-1" role="tab">
                        <h6 class="mb-0 py-3 text-overflow-ellipsis"><a class="collapsed" data-toggle="collapse" href="#module_{{$module->id}}" aria-expanded="true" aria-controls="module_{{$module->id}}"><span class="iconify" data-icon="codicon:file-submodule" data-inline="false"></span> <span class="small">{{$module->title}}</span></a></h6>
                    </div>
                    <div id="module_{{$module->id}}" class="collapse" role="tabpanel" data-module="{{$module->id}}">
                        <ul type="none" class="ml-4">
                            @foreach ($module->materials as $material)
                                @if ($material->isChecked())
                                    <li class="material text-overflow-ellipsis text-muted" data-id="{{$material->id}}"><span class="iconify h6 my-2 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">{{$material->title}}</span></li>
                                @else
                                    <li class="material text-overflow-ellipsis" data-id="{{$material->id}}"><span class="iconify h6 my-2 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">{{$material->title}}</span></li>
                                @endif
                            @endforeach

                            @if ($module->allMaterialsChecked())
                                @php $i = 1; @endphp
                                @foreach ($module->tests as $test)
                                    @if ($i > 1)
                                        @if ($test->isAnswered(Auth::user()->id))
                                            @if ($test->isCompleted(Auth::user()->id))
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
                                        @if ($test->isAnswered(Auth::user()->id))
                                            @if ($test->isCompleted(Auth::user()->id))
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
                            @endif

                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-2 neuro-card p-0 justify-content-center align-items-center text-center d-none" id="sidebar_thumb">
        <span class="iconify color-dark-grey h1" data-icon="ic:baseline-lock" data-inline="false"></span>
    </div>

    <div class="offset-lg-2 col-lg-10 py-2 px-4 d-block" id="material_content">
    </div>

    <div class="offset-lg-2 col-lg-10 py-2 px-4 d-none justify-content-center vh-100 align-items-center" id="material_content_loader">
        <span class="iconify display-1" data-icon="eos-icons:three-dots-loading" data-inline="false"></span>
    </div>
</div>

@endsection
