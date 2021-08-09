@if (Auth::user()->is_admin == 1)
    @extends('layouts.layout')

    @section('title', 'Tests')

    @section('content')
        <nav class="font-primary navbar navbar-expand-lg background-light-grey py-3 px-5">
            <a class="navbar-brand font-weight-bold text-shadow" href="{{ route('landing') }}"><img src="{{ URL::asset('public/images/logo_small.svg') }}" class="text-center d-flex justify-content-center mx-auto" width="100em"></a>
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
                    @if (Auth::user()->isRegistered($course->id))
                        <div class="neuro-card col-12 p-5 my-5">
                            <h5 class="card-title text-center mb-5 font-weight-bold">{{$course->title}}</h5>
                            <div class="row justify-content-around">

                                    @foreach ($course->modules as $module)
                                        <div class="neuro-card col-md-5 col-xs-12 p-5 mb-5 text-center">
                                            <h6 class="mb-3 font-weight-bold">{{$module->title}}</h6>
                                            @php $i = 1; @endphp
                                            @foreach ($module->tests as $test)
                                                <div class="neuro-card py-3 my-3 px-4 d-flex flex-row justify-content-between align-items-center">
                                                    <div>Test {{$i}}</div>
                                                    <div class="dropdown">
                                                        <button class="button dropdown-toggle py-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                        <div class="dropdown-menu border-0 text-center mt-1 rounded-corner">
                                                            <button type="button" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto" data-toggle="modal" data-target="#test{{$test->id}}Progress">Progress</button><br>
                                                            <button data-toggle="modal" data-target="#editTestModal" data-test="{{$test->id}}" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Edit</button><br>
                                                            <form method="POST" action="/tests" onsubmit="return confirm('Do you really want to delete?');">
                                                                @csrf @method('DELETE')
                                                                <input name="id" value="{{$test->id}}" required hidden>
                                                                <button type="submit" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Delete</button><br>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade px-5" id="test{{$test->id}}Progress" tabindex="-1" role="dialog" aria-labelledby="test{{$test->id}}ProgressLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content border-0 neuro-card shadow p-5">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="test{{$test->id}}ProgressLabel">Progress of Test {{$i}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="w-100">
                                                                    <tr class='table-filters'>
                                                                        <td class="p-1">
                                                                            <input placeholder="Name" class="w-100 small glassmorphism-input-dark" type="text"/>
                                                                        </td>
                                                                        <td class="p-1">
                                                                            <input placeholder="Result" class="w-100 small glassmorphism-input-dark" type="text"/>
                                                                        </td>
                                                                    </tr>
                                                                    @foreach($users as $user)
                                                                        @if ($user->isRegistered($course->id))
                                                                            <tr class="table-data color-dark-grey text-center border border-top-0 border-left-0 border-right-0">
                                                                                <td class="py-3"><p class="h6 my-auto">{{$user->name}}</p></td>
                                                                                @if ($test->isAnswered($user->id))
                                                                                    <td class="py-3"><p class="font-weight-bold my-auto">{{$test->userResult($user->id)}}%</p></td>
                                                                                    <td class="py-3"><a class="small color-red my-auto" href="/results?user_id={{$user->id}}&test_id={{$test->id}}">See answers</a></td>
                                                                                @else
                                                                                    <td class="py-3"><p class="font-weight-bold text-danger my-auto">Not answered</p></td>
                                                                                    <td class="py-3"><a class="text-muted small my-auto">See answers</a></td>
                                                                                @endif
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $i++; @endphp
                                            @endforeach
                                            <button data-toggle="modal" data-module="{{$module->id}}" data-target="#addTestModal" class="card-link button py-2 shadow mx-auto text-white align-middle mt-5">Create new test <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal fade" id="addTestModal" tabindex="-1" role="dialog" aria-labelledby="addTestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content border-0 neuro-card shadow p-5">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTestModalLabel">Add new test</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="/tests" autocomplete="off">
                        <input name="count" id="question_count" value="0" hidden required>
                        <input name="module_id" id="module_id" hidden required>

                        <div class="modal-body">
                            @csrf

                            <div class="mb-3">
                                <label class="font-weight-bold">Time (in minutes)</label>
                                <input type="text" placeholder="Test duration" name="time" class="glassmorphism-input-dark small w-100" required>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input background-red" id="customCheck1" name="duplicate">
                                <label class="custom-control-label" for="customCheck1">Duplicate test</label>
                              </div>

                            <div id="question_list"></div>

                            <button class="button py-2 mx-auto add-question">Add new question <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editTestModal" tabindex="-1" role="dialog" aria-labelledby="editTestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content border-0 neuro-card shadow p-5">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTestModalLabel">Add new test</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="/tests" autocomplete="off">
                        <input name="count" id="question_count" value="0" hidden required>
                        <input name="module_id" id="module_id" hidden required>
                        <input name="test_id" id="test_id" hidden required>
                        <div class="modal-body">
                            @csrf @method('PUT')

                            <div class="mb-3">
                                <label class="font-weight-bold">Time (in minutes)</label>
                                <input type="text" placeholder="Test duration" name="time" id="time" class="glassmorphism-input-dark small w-100" required>
                            </div>

                            <div id="question_list"></div>

                            <button class="button py-2 mx-auto add-question">Add new question <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>

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
