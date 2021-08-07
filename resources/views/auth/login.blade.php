@extends('layouts.layout')

@section('title', 'Вхід')

@section('content')
<div class="background-light-grey vh-100 d-flex align-items-center ">
    <div class="row"></div>
    <div class="row justify-content-center m-auto w-100">
        <div class="col-md-3">
            <div class="neuro-card  p-5 color-navy">
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    <img src="{{ URL::asset('public/images/logo_small.svg') }}" class="text-center d-flex justify-content-center mx-auto">
                    <h4 class="font-weight-bold color-navy text-center pt-3">Вхід</h4>
                    @csrf
                    <div class="mb-3">
                        <input type="text" placeholder="Ел. пошта" name="email" class="glassmorphism-input-dark small w-100" required>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <input type="password" placeholder="Пароль" name="password" class="glassmorphism-input-dark small w-100" required>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="mx-auto">
                        <button type="submit" class="shadow button background-red btn-block font-weight-bold">Увійти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row"></div>
</div>
@endsection
