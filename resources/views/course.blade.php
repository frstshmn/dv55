@extends('layouts.layout')

@section('title', $course)

@section('content')
<div class="row background-light-grey w-100">
    <div class="col-2 shadow" id="sidebar">
        <div id="accordion" role="tablist">
            <div class="my-3 ml-3">
                <div class="neuro-card p-3" role="tab" id="headingOne">
                    <h5 class="mb-0"><a class="color-dark-grey collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><span class="iconify" data-icon="codicon:file-submodule" data-inline="false"></span> <span class="small">Module 1</span></a></h5>
                </div>
                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <ul type="none" class="ml-4 mt-3">
                        <li><span class="iconify h5 my-3 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">Chapter 1</span></li>
                        <li><span class="iconify h5 my-3 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">Chapter 2</span></li>
                        <li><span class="iconify h5 my-3 align-middle" data-icon="ps:book-tag" data-inline="false"></span> <span class="small">Chapter 3</span></li>
                        <li><span class="iconify h5 my-3 align-middle" data-icon="heroicons-outline:clipboard-check" data-inline="false"></span> <span class="small">Test</span></li>
                    </ul>
                </div>
            </div>

            <div class="my-3 ml-3">
                <div class="neuro-card p-3" role="tab" id="headingTwo">
                    <h5 class="mb-0"><a class="color-dark-grey collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><span class="iconify" data-icon="codicon:file-submodule" data-inline="false"></span> <span class="small">Module 2</span></a></h5>
                </div>
                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-10" id="content">
        <div class="container">
            <div class="row w-100">
                <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                    <div class="neuro-card text-center p-5">
                        <img src="../images/logo_old_big.png" class="w-75 text-center d-flex justify-content-center mx-auto">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                    <div class="neuro-card text-center p-5">
                        <img src="../images/logo_old_big.png" class="w-75 text-center d-flex justify-content-center mx-auto">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                    <div class="neuro-card text-center p-5">
                        <img src="../images/logo_old_big.png" class="w-75 text-center d-flex justify-content-center mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
