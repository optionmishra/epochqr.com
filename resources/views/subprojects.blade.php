@extends('layouts.default')
@section('meta-title')
    EQR | Dashboard
@stop
@section('meta-description') @stop

@section('styles')
    @parent
    {{-- <link href="{{ asset('front/css/welcome.css') }}" rel="stylesheet"> --}}
    <style>
        .wrapper {
            background-color: #F5FDFD;
            min-height: calc(100vh - 65px)
        }

        .tab-pane-body {
            background-color: #fff;
            border: 1px solid #eee;
            border-top: none;
            padding: 2rem;
        }

        table {
            background-color: transparent;
        }

        .tab-content {
            background-color: #fff;
        }

        .title a {
            font-weight: bold;
            font-size: 1.2rem;
            text-decoration: none;
        }

        tr {
            border-top: 1px solid #eee;
            /* display: flex; */
            /* justify-content: space-between; */
            padding: .4rem .8rem;
        }

        .nav-link {
            font-weight: 400;
            font-size: 1.1rem;
        }

        .modal {
            top: 65px;
        }

    </style>
@endsection
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-center container">
            <div class="col-md-10 m-3">
                <h3 class="my-2">List of Sub Projects</h3>
                <button class="btn btn-danger my-3" data-toggle="modal" data-target="#createProjectModal"><i
                        class="las la-plus font-size-18"></i> Create Sub Project</button>
                <div class="tabs-container my-3">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="">Sub Projects</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Archived</a></li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="tab-pane-body">
                                <table class="table-borderless table">
                                    <tbody>
                                        @foreach ($subprojects as $subproject)
                                            <tr>
                                                <td>
                                                    <span class="title">
                                                        <a href="{{ route('qr-codes.index', $subproject) }}">
                                                            {{ ucfirst($subproject->name) }}
                                                        </a>
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    {{-- <a href="{{ route('qr-codes.index', $subproject) }}#project-stats"
                                                        class="btn btn-secondary" type="button"> Statistics </a> --}}
                                                    <a href="{{ route('qr-codes.index', $subproject) }}"
                                                        class="btn btn-secondary" type="button">Manage project </a>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#deleteProjectModal"
                                                        data-route="{{ route('subProjects.delete', $subproject) }}">Delete
                                                        Project</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Create Project Modal --}}
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProjectModal">Create Sub Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subProjects.add', $project) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control" type="text" name="name" placeholder="Enter Sub Project Name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Delete Project Modal --}}
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProjectModal">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center">
                    <i style="font-size: 6rem" class="las la-trash"></i>
                    <p class="text-center">You won't be able to revert this!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a id="confirmDelete" href="" class="btn btn-danger">Confirm Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('front/js/welcome.js') }}"></script>
    <script>
        $('#deleteProjectModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var route = button.data('route') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#confirmDelete').prop('href', route);
        })
    </script>
@endsection
