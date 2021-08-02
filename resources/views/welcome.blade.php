@extends('layouts.layout')

@section('title', 'Main')

@section('content')

            <div class="background-light-grey vh-100 d-flex align-items-center">
                <div class="row"></div>
                <div class="row justify-content-center m-auto w-100">
                    <div class="col-md-12">
                        <div class="p-5 color-navy">
                            <img src="{{ URL::asset('public/images/logo_small.svg') }}" class="text-center d-flex justify-content-center mx-auto w-25">
                            <p class="mt-4 text-center font-weight-bold">Sorry, we are reviewing our database. Page is under reconstruction. Thank you for your understanding.</p>
                        </div>
                        <div class="row w-100">
                            @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="color-light-grey">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="color-light-grey">Log in</a>
                                    @endauth
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row"></div>
            </div>
@endsection
