@if (Auth::user()->is_admin == 1)
    @extends('layouts.layout')

    @section('title', 'Course list')

    @section('content')
        <nav class="font-primary navbar navbar-expand-lg background-light-grey py-3 px-5">
            <a class="navbar-brand font-weight-bold text-shadow" href="#"><img src="../images/logo_small.svg" class="text-center d-flex justify-content-center mx-auto" width="100em"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a class="nav-link">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color-grey" href="#">Users</a>
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
                <div class="row w-100">
                    @foreach ($courses as $course)
                        <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                            <div class="neuro-card text-center p-5">
                                <img src="../images/logo_big.svg" class="w-75 text-center d-flex justify-content-center mx-auto">
                                <h5 class="card-title font-weight-bold mt-4 mb-2">{{$course->title}}</h5>
                                <h6 class="card-subtitle font-weight-bold mb-4 text-muted small">Пройдено на 53%</h6>
                                <p class="card-text text-justify mb-4 small">
                                    {{$course->description}}
                                </p>
                                <div class="d-flex flex-row justify-content-around">
                                    <button data-toggle="modal" data-target="#editCourseModal" class="card-link button py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:edit" data-inline="false"></span></button>
                                    <form method="POST" action="/courses">
                                        @csrf @method('DELETE')
                                        <input name="id" value="{{$course->id}}" required hidden>
                                        <button type="submit" class="card-link button py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:trash-alt" data-inline="false"></span></button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                        <div class="neuro-card text-center d-flex justify-content-center flex-column p-5 h-100">
                            <button data-toggle="modal" data-target="#addCourseModal" class="card-link button py-2 shadow mx-auto text-white align-middle">Create new course <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>
                        </div>
                    </div>

                    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCourseModalLabel">Add new course</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/courses" autocomplete="off">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="text" placeholder="Course Title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" placeholder="Course Description" name="description" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCourseModalLabel">Edit course </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/courses" autocomplete="off">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="text" placeholder="Course Title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <input type="text" placeholder="Course Description" name="description" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @php
        header("Location: " . URL::to('/cabinet'), true, 302);
        exit();
    @endphp
@endif
