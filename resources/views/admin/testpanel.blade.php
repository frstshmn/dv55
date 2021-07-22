@if (Auth::user()->is_admin == 1)
    @extends('layouts.layout')

    @section('title', 'Tests')

    @section('content')
        <nav class="font-primary navbar navbar-expand-lg background-light-grey py-3 px-5">
            <a class="navbar-brand font-weight-bold text-shadow" href="#"><img src="{{ URL::asset('public/images/logo_small.svg') }}" class="text-center d-flex justify-content-center mx-auto" width="100em"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-3 active">
                        <a class="nav-link color-grey" href="/admin">Courses</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link color-dark-grey">Tests</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link color-grey" href="/users">Users</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link color-grey" href="#">Messages</a>
                    </li> --}}
                </ul>
                <form action="{{route("logout")}}" method="POST">@csrf<button class="background-red py-1 button shadow my-2 my-sm-0" type="submit">Exit <span class="iconify" data-icon="uil:exit" data-inline="false"></span></button></form>
            </div>
        </nav>
        <div class="background-light-grey">
            <div class="container">
                <div class="row w-100 m-0">
                    @foreach ($courses as $course)
                        <div class="col-12 my-5">
                            <div class="neuro-card text-center p-5 row">
                                <h5 class="col-12 card-title font-weight-bold">{{$course->title}}</h5>
                                @foreach ($course->modules as $module)
                                    <div class="neuro-card col-md-4 col-xs-12 p-5">
                                        <h6 class="mb-3 font-weight-bold">{{$module->title}}</h6>
                                        @php $i = 1; @endphp
                                        @foreach ($module->tests as $test)
                                            <div class="neuro-card py-3 my-3 px-4 d-flex flex-row justify-content-between align-items-center">
                                                <div>Test {{$i}}</div>
                                                <div class="dropdown">
                                                    <button class="button dropdown-toggle py-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                    <div class="dropdown-menu border-0 text-center mt-1 rounded-corner">
                                                        <button data-toggle="modal" data-target="#editTestModal" data-id="{{$module->id}}" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Edit</button><br>
                                                        <form method="POST" action="/modules">
                                                            @csrf @method('DELETE')
                                                            <input name="id" value="{{$module->id}}" required hidden>
                                                            <button type="submit" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Delete</button><br>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $i++; @endphp
                                        @endforeach
                                        <button data-toggle="modal" data-target="#addTestModal" class="card-link button py-2 shadow mx-auto text-white align-middle mt-5">Create new test <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal fade" id="addTestModal" tabindex="-1" role="dialog" aria-labelledby="addTestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 neuro-card shadow p-5">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTestModalLabel">Add new test</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="/tests" autocomplete="off">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label class="font-weight-bold">Time (in minutes)</label>
                                <input type="text" placeholder="Name your test" name="title" class="glassmorphism-input-dark small w-100" required>
                            </div>

                            <div id="question_list">
                                <div class="neuro-card mb-3 p-5">
                                    <label class="font-weight-bold">Question 1</label>
                                    <input type="text" placeholder="Type here your question" name="question" class="glassmorphism-input-dark small w-100" required>
                                    <div class="row">
                                        <div class="col-6 d-flex flex-row align-items-center">
                                            <input type="radio" name="correct_answer" class="mr-2" required>
                                            <label class="font-weight-bold">1. </label>
                                            <input type="text" name="variant_1" class="ml-2 glassmorphism-input-dark small w-100" required>
                                        </div>
                                        <div class="col-6 d-flex flex-row align-items-center">
                                            <input type="radio" name="correct_answer" class="mr-2" required>
                                            <label class="font-weight-bold">2. </label>
                                            <input type="text" name="variant_2" class="ml-2 glassmorphism-input-dark small w-100" required>
                                        </div>
                                        <div class="col-6 d-flex flex-row align-items-center">
                                            <input type="radio" name="correct_answer" class="mr-2" required>
                                            <label class="font-weight-bold">3. </label>
                                            <input type="text" name="variant_3" class="ml-2 glassmorphism-input-dark small w-100" required>
                                        </div>
                                        <div class="col-6 d-flex flex-row align-items-center">
                                            <input type="radio" name="correct_answer" class="mr-2" required>
                                            <label class="font-weight-bold">4. </label>
                                            <input type="text" name="variant_4" class="ml-2 glassmorphism-input-dark small w-100" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="button py-2 mx-auto">Add new question <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @section('additional_scripts')
        <script src="{{ URL::asset('js/admin.js') }}"></script>
    @endsection
@else
    @php
        header("Location: " . URL::to('/cabinet'), true, 302);
        exit();
    @endphp
@endif
