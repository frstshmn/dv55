@if (Auth::user()->is_admin == 1)
    @extends('layouts.layout')

    @section('title', 'Users')

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
                        <a class="nav-link color-grey" href="/tests">Tests</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link color-dark-grey">Users</a>
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
                    <div class="col-12 text-center mt-4">
                        <button data-toggle="modal" data-target="#addUserModal" class="card-link button py-2 shadow mx-auto text-white align-middle">Create new user <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>
                    </div>
                    <div class="col-md-6 col-xs-12 my-5 px-4">
                        <div class="neuro-card text-center p-5 row">
                            <p class="font-weight-bold text-center">Regular users</span></p>
                            @foreach ($users as $user)
                                @if ($user->is_admin == 0)
                                <div class="neuro-card py-3 my-3 px-4 d-flex flex-row w-100 justify-content-between align-items-center">
                                    <div class="text-left">
                                        {{$user->name}}
                                        <div class="small color-grey font-weight-bold">{{$user->email}}</div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="button dropdown-toggle py-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu border-0 text-center mt-1 rounded-corner">
                                            <button data-toggle="modal" data-target="#editUserModal" data-id="{{$user->id}}" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Edit</button><br>
                                            <form method="POST" action="/users">
                                                @csrf @method('DELETE')
                                                <input name="id" value="{{$user->id}}" required hidden>
                                                <button type="submit" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Delete</button><br>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 my-5 px-4">
                        <div class="neuro-card text-center p-5 row">
                            <p class="font-weight-bold text-center">Administrators</p>
                            @foreach ($users as $user)
                                @if ($user->is_admin == 1)
                                <div class="neuro-card py-3 my-3 px-4 d-flex flex-row w-100 justify-content-between align-items-center">
                                    <div class="text-left">
                                        {{$user->name}}
                                        <div class="small color-grey font-weight-bold">{{$user->email}}</div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="button dropdown-toggle py-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu border-0 text-center mt-1 rounded-corner">
                                            <button data-toggle="modal" data-target="#editUserModal" data-id="{{$user->id}}" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Edit</button><br>
                                            <form method="POST" action="/users">
                                                @csrf @method('DELETE')
                                                <input name="id" value="{{$user->id}}" required hidden>
                                                <button type="submit" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Delete</button><br>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel">Add new user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/users">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Name</label>
                                            <input type="text" placeholder="First and last name" name="name" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Email</label>
                                            <input type="email" placeholder="An email which will be used for login" name="email" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Password</label>
                                            <input type="text" placeholder="More than 8 characters" name="password" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Confirm password</label>
                                            <input type="text" placeholder="Confirm it here" name="password_confirmation" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">User type</label>
                                            <select name="is_admin">
                                                <option value="0" selected>Regular user</option>
                                                <option value="1">Administartor</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade px-5" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Edit user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>


                                    <div class="modal-body row">
                                        <div class="col-md-6 col-xs-12 mt-md-0 mt-5">
                                            <form method="POST" action="/users" autocomplete="off">
                                                @csrf @method('PUT')

                                                <input type="text" id="identifier" name="id" class="glassmorphism-input-dark small w-100" required hidden>

                                                <div class="mb-3">
                                                    <label class="font-weight-bold">Name</label>
                                                    <input type="text" placeholder="First and last name" id="name" name="name" class="glassmorphism-input-dark small w-100" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="font-weight-bold">Email</label>
                                                    <input type="email" placeholder="An email which will be used for login" id="email" name="email" class="glassmorphism-input-dark small w-100" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="font-weight-bold">Password</label>
                                                    <input type="text" placeholder="More than 8 characters" name="password" class="glassmorphism-input-dark small w-100">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="font-weight-bold">Confirm password</label>
                                                    <input type="text" placeholder="Confirm it here" name="password_confirmation" class="glassmorphism-input-dark small w-100">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="font-weight-bold">User type</label>
                                                    <select id="is_admin" name="is_admin">
                                                        <option value="0" selected>Regular user</option>
                                                        <option value="1">Administartor</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6 col-xs-12 mt-md-0 mt-5">
                                            <div class="dropdown">
                                                <button class="button dropdown-toggle py-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Choose course to add</button>
                                                <div class="dropdown-menu border-0 text-center mt-1 rounded-corner">
                                                    @foreach ($courses as $course)
                                                        <form method="POST" action="/usercourses">
                                                            @csrf
                                                            <input name="user_id" id="user_id" value="" required hidden>
                                                            <input name="course_id" value="{{$course->id}}" required hidden>
                                                            <button type="submit" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">{{$course->title}}</button><br>
                                                        </form>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <ul class="list-group" id="user_courses">

                                            </ul>

                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>


    @endsection
    @section('additional_scripts')
        <script src="{{ URL::asset('public/js/admin.js') }}"></script>
    @endsection
@else
    @php
        header("Location: " . URL::to('/cabinet'), true, 302);
        exit();
    @endphp
@endif
