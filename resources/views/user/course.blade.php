@extends('layouts.layout')

@section('title', $course->title)

@section('content')
<div class="row background-light-grey w-100 m-0">
    <div class="col-2 pr-0 position-fixed background-light-grey vh-100" id="sidebar">
        <div id="total" class="px-4 pt-4">
            <div class="pie mx-auto shadow" style="background-image: linear-gradient(230deg, transparent 50%, #041E42 50%), linear-gradient(90deg, #e0e0e0 50%, transparent 50%);">
                <h5 class="text-center pie-inner justify-content-center d-flex flex-column 9align-items-center">
                    <div>{{$course->title}}</div>
                    <div class="small">75%</div>
                </h5>
            </div>

        </div>

        <div id="accordion" role="tablist" class="p-3">
            {{-- {{dd($course->modules)}} --}}
            @foreach ($course->modules as $module)
                <div class="my-3 ml-3">
                    <div class="p-3" role="tab" id="headingOne">
                        <h5 class="mb-0"><a class="color-dark-grey collapsed" data-toggle="collapse" href="#module_{{$module->id}}" aria-expanded="true" aria-controls="module_{{$module->id}}"><span class="iconify" data-icon="codicon:file-submodule" data-inline="false"></span> <span class="small">{{$module->title}}</span></a></h5>
                    </div>
                    <div id="module_{{$module->id}}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <ul type="none" class="ml-4 mt-3">
                            @foreach ($module->materials as $material)
                                <li class="material" data-id="{{$material->id}}"><span class="iconify h5 my-3 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">{{$material->title}}</span></li>
                            @endforeach

                            @php $i = 1; @endphp
                            @foreach ($module->tests as $test)
                                @if ($i > 1)
                                    <li class="test" data-id="{{$test->id}}"><span class="iconify h5 my-3 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Additional test</span></li>
                                @else
                                    <li class="test" data-id="{{$test->id}}"><span class="iconify h5 my-3 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Test</span></li>
                                @endif
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-2 pr-0 position-fixed background-light-grey vh-100 d-flex justify-content-center align-items-center text-center d-none" id="sidebar_thumb">
        <span class="iconify color-dark-grey h1" data-icon="ic:baseline-lock" data-inline="false"></span>
    </div>
    <div class="offset-2 col-10" id="material_content">
    </div>
</div>

@endsection