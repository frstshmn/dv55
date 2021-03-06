@extends('layouts.layout')

@section('title', 'Список курсів')

@section('content')
    <nav class="font-primary navbar navbar-expand-lg background-light-grey py-3 px-5">
        <a class="navbar-brand font-weight-bold text-shadow" href="{{ route('landing') }}"><img src="{{ URL::asset('public/images/logo_small.svg') }}" class="text-center d-flex justify-content-center mx-auto" width="100em"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item active">
                    <a class="nav-link">Курси</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link color-grey" href="#">Сертифікати</a>
                </li>

            </ul>
            <form action="{{route("logout")}}" method="POST">@csrf<button class="background-red py-1 button shadow my-2 my-sm-0" type="submit">Вийти <span class="iconify" data-icon="uil:exit" data-inline="false"></span></button></form>
        </div>
    </nav>
    <div class="background-light-grey">
        <div class="container">
            <div class="row w-100">
                @foreach ($courses as $course)
                    <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                        <div class="neuro-card text-center p-5">
                            <img src="{{ URL::asset('public/images/logo_big.svg') }}" class="w-75 text-center d-flex justify-content-center mx-auto">
                            <h5 class="card-title font-weight-bold mt-4 mb-2">{{$course->course->title}}</h5>
                            <h6 class="card-subtitle font-weight-bold my-4 text-muted small">{{ $course->course->totalScore(Auth::user()->id) }}% пройдено</h6>
                            <a href="/courses/{{$course->course->id}}" class="card-link button py-2 shadow mx-auto text-white">Перейти до курсу</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
