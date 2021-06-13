@extends('layouts.layout')

@section('title', 'Кабінет')

@section('content')
    <nav class="font-primary navbar navbar-expand-lg navbar-dark bg-dark p-4">
        <a class="navbar-brand font-weight-bold text-shadow" href="#"><span class="text-primary">Division</span> <span class="text-danger">55</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Курси</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Сертифікати</a>
                </li>

            </ul>
            <form action="{{route("logout")}}" method="POST">@csrf<button class="btn btn-danger my-2 my-sm-0" type="submit">Вихід <span class="iconify" data-icon="uil:exit" data-inline="false"></span></button></form>
        </div>
    </nav>
@endsection
