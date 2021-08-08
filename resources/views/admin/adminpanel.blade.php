@if (Auth::user()->is_admin == 1)
    @extends('layouts.layout')

    @section('title', 'Courses')

    @section('content')
        <nav class="font-primary navbar navbar-expand-lg background-light-grey py-3 px-5">
            <a class="navbar-brand font-weight-bold text-shadow" href="{{ route('landing') }}"><img src="{{ URL::asset('public/images/logo_small.svg') }}" class="text-center d-flex justify-content-center mx-auto" width="100em"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-3 active">
                        <a class="nav-link color-dark-grey">Courses</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link color-grey" href="/tests">Tests</a>
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
                    <div class="col-12 text-center mt-5">
                        <button data-toggle="modal" data-target="#addCourseModal" class="card-link button py-2 shadow mx-auto text-white align-middle">Create new course <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>
                    </div>
                    @foreach ($courses as $course)
                        <div class="col-12 my-5">
                            <div class="neuro-card text-center p-5 row">
                                <div class="col-md-4 col-xs-12 mt-md-0 mt-5">
                                    <img src="{{ URL::asset('public/images/logo_big.svg') }}" class="w-75 text-center d-flex justify-content-center mx-auto">
                                    <h5 class="card-title font-weight-bold mt-4 mb-2">{{$course->title}}</h5>
                                    <h6 class="card-subtitle font-weight-bold mb-4 text-muted small">10 members</h6>
                                    <p class="card-text text-justify mb-4 small">
                                        {{$course->description}}
                                    </p>
                                    <div class="d-flex flex-row justify-content-around">

                                        <button type="button" class="button py-2" data-toggle="modal" data-target="#course{{$course->id}}Progress">
                                            Progress
                                        </button>

                                        <button data-toggle="modal" data-target="#editCourseModal" data-id="{{$course->id}}" class="card-link button py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:edit" data-inline="false"></span></button>
                                        <form method="POST" action="/courses" onsubmit="return confirm('Do you really want to delete?');">
                                            @csrf @method('DELETE')
                                            <input name="id" value="{{$course->id}}" required hidden>
                                            <button type="submit" class="card-link button py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:trash-alt" data-inline="false"></span></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 mt-md-0 mt-5 px-5" id="modules">
                                    <p class="font-weight-bold text-center mb-5">Modules</p>
                                    @foreach ($course->modules as $module)
                                    <div class="neuro-card py-3 my-3 px-4 d-flex flex-row justify-content-between align-items-center">
                                        <div class="small text-overflow-ellipsis">{{$module->title}}</div>
                                        <div class="dropdown">
                                            <button class="button dropdown-toggle py-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu border-0 text-center mt-1 rounded-corner">
                                                <button data-id="{{$module->id}}" class="show-materials small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Show materials</button><br>
                                                <button data-toggle="modal" data-target="#editModuleModal" data-id="{{$module->id}}" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Edit</button><br>
                                                <form method="POST" action="/modules" onsubmit="return confirm('Do you really want to delete?');">
                                                    @csrf @method('DELETE')
                                                    <input name="id" value="{{$module->id}}" required hidden>
                                                    <button type="submit" class="small bg-white card-link border-0 text-center align-middle my-2 mx-auto">Delete</button><br>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <button data-toggle="modal" data-target="#addModuleModal" data-id="{{$course->id}}" class="card-link button py-2 shadow mx-auto text-white align-middle">Create new module <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>
                                </div>
                                <div class="col-md-4 col-xs-12 mt-md-0 mt-5 px-5" id="module_materials" data-module="0">
                                    <p class="font-weight-bold text-center" id="module_name">Materials</p>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade px-5" id="course{{$course->id}}Progress" tabindex="-1" role="dialog" aria-labelledby="course{{$course->id}}ProgressLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content border-0 neuro-card shadow p-5">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="course{{$course->id}}ProgressLabel">Progress of "{{$course->title}}"</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table>
                                            <tr class='table-filters'>
                                                <td class="p-1">
                                                    <input placeholder="Name" class="w-100 small glassmorphism-input-dark" type="text"/>
                                                </td>
                                                <td class="p-1">
                                                    <input placeholder="Result" class="w-100 small glassmorphism-input-dark" type="text"/>
                                                </td>
                                            </tr>
                                        @foreach($users as $user)
                                        <tr class="table-data color-dark-grey">
                                            <td><p class="h6 text-left">{{$user->name}}</p></td>
                                            <td class="text-center"><p class="font-weight-bold">{{$course->totalScore($user->id)}}%</p></td>
                                        </tr>
                                        @endforeach

                                    </table>
                                    </div>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

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
                                            <label class="font-weight-bold">Title</label>
                                            <input type="text" placeholder="Name your course" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Description</label>
                                            <input type="text" placeholder="Make short description of topics in this course" name="description" class="glassmorphism-input-dark small w-100" required>
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
                                    <h5 class="modal-title" id="editCourseModalLabel">Edit course</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/courses" autocomplete="off">
                                    <div class="modal-body">
                                        @csrf @method('PUT')
                                        <input type="text" id="identifier" name="identifier" required hidden>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Title</label>
                                            <input type="text" placeholder="Name your course" id="title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="font-weight-bold">Description</label>
                                            <input type="text" placeholder="Make short description of topics in this course" id="description" name="description" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addModuleModal" tabindex="-1" role="dialog" aria-labelledby="addModuleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModuleModalLabel">Add new module</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/modules" autocomplete="off">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="text" id="course_id" name="course_id" required hidden>
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Title</label>
                                            <input type="text" placeholder="Name your module" id="title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editModuleModal" tabindex="-1" role="dialog" aria-labelledby="editModuleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModuleModalLabel">Edit module</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/modules" autocomplete="off">
                                    <div class="modal-body">
                                        @csrf @method('PUT')
                                        <input type="text" id="identifier" name="identifier" required hidden>
                                        <input type="text" id="course_id" name="course_id" required hidden>
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Title</label>
                                            <input type="text" placeholder="Name your module" id="title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade px-5" id="addMaterialModal" tabindex="-1" role="dialog" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addMaterialModalLabel">Add new material</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/materials" autocomplete="off">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="text" id="module_id" name="module_id" value="" required hidden>
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Title</label>
                                            <input type="text" placeholder="Name your material" id="title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Material code</label>
                                            <textarea rows="15" id="code" name="code" placeholder="Insert your text or page code here" class="glassmorphism-input-dark small w-100 border-0 rounded-corner p-3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="button py-2 mx-auto px-5">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade px-5" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editMaterialModalLabel">Edit material</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="/materials" autocomplete="off" id="edit_material">
                                    <div class="modal-body">
                                        @csrf @method('PUT')
                                        <input type="text" id="identifier" name="id" required hidden>
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Title</label>
                                            <input type="text" placeholder="Name your material" id="title" name="title" class="glassmorphism-input-dark small w-100" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="font-weight-bold">Material code</label>
                                            <textarea rows="15" id="code" name="code" placeholder="Insert your text or page code here" class="glassmorphism-input-dark small w-100 border-0 rounded-corner p-3" required></textarea>
                                        </div>
                                    </div>
                                </form>
                                <form method="POST" action="/materials" id="delete_material" onsubmit="return confirm('Do you really want to delete?');">
                                    @csrf @method('DELETE')
                                    <input name="id" id="identifier"required hidden>
                                </form>
                                    <div class="modal-footer d-flex flex-row justify-content-center">
                                        <button onclick="$('#edit_material').submit()" class="button py-2 mx-2 px-5">Edit</button>
                                        <button onclick="$('#delete_material').submit()" class="card-link button mx-2 py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:trash-alt" data-inline="false"></span></button>
                                    </div>
                            </div>
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
