@extends('layouts.layout')

@section('content')
<div class="background-image d-flex align-items-center">
    <div class="row"></div>
    <div class="row justify-content-center m-auto w-100">
        <div class="col-md-3">
            <div class="card glassmorphism-card font-primary">
                <div class="card-body">
                    <h3 class="mb-4 text-center text-white font-weight-bold">Вхід</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" placeholder="Login" id="email" class="glassmorphism-input" name="email" required autofocus>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <input type="password" placeholder="Password" id="password" class="glassmorphism-input" name="password" required>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="d-grid mx-auto">
                            <button type="submit" class="button background-red btn-block">Увійти</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row"></div>
</div>
{{-- <main>
    <div id="container">
      <form action="">
        <img src="https://bit.ly/2tlJLoz"><br>
        <input type="text" value="@AmJustSam"><br>
        <input type="password"><br>
        <input type="submit" value="SIGN IN"><br>
        <span><a href="#">Forgot Password?</a></span>
      </form>
    </div>
</main> --}}
@endsection
