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
            <h3 class="my-2">List of Projects</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Projects</li>
                </ol>
            </nav>
            <button class="btn btn-danger my-3" data-toggle="modal" data-target="#createProjectModal"><i class="las la-plus font-size-18"></i> Create Project</button>
            <div class="tabs-container my-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><span class="nav-link active cursor-pointer" data-toggle="tab" data-target="#projects" role="tab" id="projectsTab">Projects</span></li>
                    <li class="nav-item"><span class="nav-link" data-toggle="tab" data-target="#archived_projects" role="tab" id="archivedProjectsTab">Archived</span></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="projects" role="tabpanel" aria-labelledby="home-tab">
                        <div class="tab-pane-body">
                            <table class="table-borderless table">
                                <tbody>
                                    @foreach ($projects as $project)
                                    <tr>
                                        <td>
                                            <span class="title">
                                                <a href="{{ route('qr-codes.index', $project) }}">
                                                    {{ ucfirst($project->name) }}
                                                </a>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            {{-- <a href="{{ route('qr-codes.index', $project) }}#project-stats"
                                            class="btn btn-secondary" type="button"> Statistics </a> --}}
                                            <a href="{{ route('qr-codes.index', $project) }}" class="btn btn-secondary" type="button">Manage project</a>
                                            <a class="btn btn-primary" href="{{ route('projects.archive', $project) }}">Archive</a>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteProjectModal" data-route="{{ route('projects.delete', $project) }}">Delete
                                                Project</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$projects->links()}}
                    </div>
                    <div class="tab-pane fade" id="archived_projects" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="tab-pane-body">
                            @if (count($archived_projects))
                            <table class="table-borderless table">
                                <tbody>
                                    @foreach ($archived_projects as $project)
                                    <tr>
                                        <td>
                                            <span class="title">
                                                <a href="{{ route('qr-codes.index', $project) }}">
                                                    {{ ucfirst($project->name) }}
                                                </a>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            {{-- <a href="{{ route('qr-codes.index', $project) }}#project-stats"
                                            class="btn btn-secondary" type="button"> Statistics </a> --}}
                                            {{-- <a href="{{ route('qr-codes.index', $project) }}"
                                            class="btn btn-secondary" type="button">Manage project</a> --}}
                                            {{-- <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#deleteProjectModal"
                                                        data-route="{{ route('projects.delete', $project) }}">Delete
                                            Project</button> --}}
                                            <a class="btn btn-dark" href="{{ route('projects.unarchive', $project) }}">Unarchive</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center">
                                <span>Archive Empty</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Create Project Modal --}}
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectModal">Create Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('projects.add') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input class="form-control" type="text" name="name" placeholder="Enter Project Name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partial.deleteModal')

@endsection
@section('scripts')
@parent
<script type="text/javascript" src="{{ asset('front/js/welcome.js') }}"></script>
@endsection