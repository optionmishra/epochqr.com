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

        .title {
            font-weight: bold;
            font-size: 1.1rem;
            text-decoration: none;
        }

        tbody tr {
            border-top: 1px solid #eee;
        }

        .nav-link {
            font-weight: 400;
            font-size: 1.1rem;
        }

        .qr-checkbox {
            margin-top: .2rem;
            height: 1.2rem;
            width: 1.2rem;
        }

        th {
            font-size: 1.1rem;
        }

        .modal {
            top: 65px;
        }

        .sub-main-menu {
            display: none;
            background-color: #D3F6F6;
            padding: 1rem;
        }

        .pagination {
            margin: 0;
        }

    </style>
@endsection
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-center container">
            <div class="col-md-10 m-3">
                <h3 class="my-2">Project: {{ Str::ucfirst($project->name) }}</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
                    </ol>
                </nav>
                <button class="btn btn-danger my-3" data-toggle="modal" data-target="#createQRModal">Create QR</button>
                <button class="btn btn-primary my-3" data-toggle="modal" data-target="#createMultipleQRModal">Create
                    Multiple
                    QRs</button>
                <div class="col-lg-12 col-sm-12 col-xs-12 sub-main-menu rounded">
                    <span>Batch actions: </span>
                    <button class="btn btn-outline-dark btn-sm mx-2" id="btn_batch_archive"
                        data-token="{{ csrf_token() }}">Archive/Unarchive</button>
                    <button class="btn btn-outline-dark btn-sm mx-1" id="btn_batch_download"
                        data-token="{{ csrf_token() }}">Download</button>
                </div>
                <div class="tabs-container my-3">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <span type="button" class="nav-link active" id="nav-qr-codes-tab" data-toggle="tab"
                                data-target="#qr-codes" role="tab" aria-controls="qr-codes" aria-selected="true">QR
                                codes</span>
                        </li>
                        <li class="nav-item">
                            <span type="button" class="nav-link" id="nav-archived-tab" data-toggle="tab"
                                data-target="#archived" role="tab" aria-controls="archived" aria-selected="false">
                                Archived</span>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="qr-codes" role="tabpanel" aria-labelledby="qr-codes-tab">
                            <div class="tab-pane-body">
                                <table class="table-borderless table-responsive table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%" scope="col">#</th>
                                            <th style="width: 10%" scope="col"><input class="qr-checkbox" type="checkbox"
                                                    name="" id="unarchivedQRCheckAll"></th>
                                            <th style="width: 25%" scope="col">QR Name</th>
                                            <th style="width: 10%" scope="col">QR</th>
                                            <th style="width: 20%" scope="col">Short URL</th>
                                            <th style="width: 30%" scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campaigns as $key => $qr)
                                            <th scope="row">{{ ++$key }}</th>
                                            <td><input class="qr-checkbox unarchived-row-checkbox" type="checkbox"
                                                    name="batch_action[]" value="{{ $qr->id }}"></td>
                                            <td>
                                                <a class="title"
                                                    href="/panel/496776/project/project-settings/898435">
                                                    {{ ucfirst($qr->title) }}
                                                </a>
                                            </td>
                                            <td><img class=""
                                                    src="{{ $qrPath }}{{ str_replace(' ', '_', $project->name) }}/{{ str_replace(' ', '_', $qr->qrcode) }}"
                                                    width="60">
                                            </td>
                                            <td><a
                                                    href="{{ $domainUrl }}{{ $qr->link }}">{{ $domainUrl }}{{ $qr->link }}</a>
                                            </td>
                                            <td>
                                                <a title="Download"
                                                    href="{{ $qrPath }}{{ str_replace(' ', '_', $project->name) }}/{{ str_replace(' ', '_', $qr->qrcode) }}"
                                                    class="btn btn-success" type="button" download="""><i class="
                                                    las la-download"></i></a>
                                                <button title="Edit" class="btn btn-dark" type="button"
                                                    data-route="{{ route('qr-code.update', $qr) }}" data-toggle="modal"
                                                    data-target="#editQRModal" data-title="{{ $qr->title }}"
                                                    data-qrType="{{ $qr->type }}" data-qrtarget="{{ $qr->target }}"
                                                    data-status="{{ $qr->status }}"><i
                                                        class="las la-edit"></i></button>
                                                {{-- <a href="{{ route('qr-code.delete', $qr) }}"><button
                                                            class="btn btn-danger" type="button">Delete</button></a> --}}

                                                <a title="Archive" href="{{ route('qr-code.archive', $qr) }}"
                                                    class="btn btn-primary"><i class="las la-archive"></i></a>
                                                <button title="Delete" type="button" class="btn btn-danger"
                                                    data-toggle="modal" data-target="#deleteProjectModal"
                                                    data-route="{{ route('qr-code.delete', $qr) }}"><i
                                                        class="las la-trash"></i></button>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if (count($campaigns))
                                    <div class="paginate row align-items-center m-0">
                                        <div class="totalResult col-lg-6">
                                            <p class="m-0">
                                                {{ $campaigns->firstItem() }}-{{ $campaigns->lastItem() }} of
                                                {{ $campaigns->total() }} entries
                                                <!-- {{ $campaigns->perPage() * ($campaigns->currentPage() - 1) + $campaigns->count() }} of {{ $campaigns->total() }} entries -->
                                            </p>
                                        </div>
                                        <div class="col-lg-6 d-flex justify-content-end">
                                            {{ $campaigns->links() }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="archived" role="tabpanel" aria-labelledby="archived-tab">

                            <div class="tab-pane-body">
                                <table class="table-borderless table-responsive table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%" scope="col">#</th>
                                            <th style="width: 10%" scope="col"><input class="qr-checkbox" type="checkbox"
                                                    name="" id="archivedQRCheckAll"></th>
                                            <th style="width: 25%" scope="col">QR Name</th>
                                            <th style="width: 10%" scope="col">QR</th>
                                            <th style="width: 20%" scope="col">Short URL</th>
                                            <th style="width: 30%" scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($archived_campaigns))
                                            @foreach ($archived_campaigns as $key => $qr)
                                                <th scope="row">{{ ++$key }}</th>
                                                <td><input class="qr-checkbox archived-row-checkbox" type="checkbox"
                                                        name="batch_action[]" value="{{ $qr->id }}"></td>
                                                <td>
                                                    <a class="title"
                                                        href="/panel/496776/project/project-settings/898435">
                                                        {{ ucfirst($qr->title) }}
                                                    </a>
                                                </td>
                                                <td><img class=""
                                                        src="{{ $qrPath }}{{ str_replace(' ', '_', $project->name) }}/{{ str_replace(' ', '_', $qr->qrcode) }}"
                                                        width="60">
                                                </td>
                                                <td><a
                                                        href="{{ $domainUrl }}{{ $qr->link }}">{{ $domainUrl }}{{ $qr->link }}</a>
                                                </td>
                                                <td>
                                                    <a title="Download"
                                                        href="{{ $qrPath }}{{ str_replace(' ', '_', $project->name) }}/{{ str_replace(' ', '_', $qr->qrcode) }}"
                                                        class="btn btn-success" type="button" download="""><i class="
                                                        las la-download"></i></a>
                                                    {{-- <button title="Edit" class="btn btn-dark" type="button"
                                                    data-route="{{ route('qr-code.update', $qr) }}" data-toggle="modal"
                                                    data-target="#editQRModal" data-title="{{ $qr->title }}"
                                                    data-qrType="{{ $qr->type }}" data-qrtarget="{{ $qr->target }}"
                                                    data-status="{{ $qr->status }}"><i
                                                        class="las la-edit"></i></button> --}}
                                                    {{-- <a href="{{ route('qr-code.delete', $qr) }}"><button
                                                            class="btn btn-danger" type="button">Delete</button></a> --}}

                                                    {{-- <button title="Archive" class="btn btn-primary"><i
                                                        class="las la-archive"></i></button> --}}
                                                    {{-- <button title="Delete" type="button" class="btn btn-danger"
                                                    data-toggle="modal" data-target="#deleteProjectModal"
                                                    data-route="{{ route('qr-code.delete', $qr) }}"><i
                                                        class="las la-trash"></i></button> --}}
                                                    <a title="Unarchive" href="{{ route('qr-code.unarchive', $qr) }}"
                                                        class="btn btn-dark"><i class="las la-box-open"></i></a>
                                                </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td class="text-center" colspan="6">No archived qrs in current project</td>
                                        @endif
                                    </tbody>
                                </table>
                                @if (count($archived_campaigns))
                                    <div class="paginate row align-items-center m-0">
                                        <div class="totalResult col-lg-6">
                                            <p class="m-0">
                                                {{ $archived_campaigns->firstItem() }}-{{ $archived_campaigns->lastItem() }}
                                                of
                                                {{ $archived_campaigns->total() }} entries
                                                <!-- {{ $archived_campaigns->perPage() * ($archived_campaigns->currentPage() - 1) + $archived_campaigns->count() }} of {{ $archived_campaigns->total() }} entries -->
                                            </p>
                                        </div>
                                        <div class="col-lg-6 d-flex justify-content-end">
                                            {{ $archived_campaigns->links() }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- Create QR Modal --}}
        <div class="modal fade" id="createQRModal" tabindex="-1" aria-labelledby="createQRModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createQRModal">Create QR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('qr-code.formProcess', $project) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label class="fancy">Title<span class="redstar">*</span></label>
                                <input type="text" class="form-control" name="title" required
                                    placeholder="Enter the QR name">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fancy">Select QR Type<span class="redstar">*</span></label>
                                <select name="qr_type" class="form-control" id="addQrType">
                                    <option value="url">URL</option>
                                    <option value="code">Code</option>
                                </select>
                            </div>

                            <div class="col-md-12 addTargetUrl mb-3">
                                <label class="fancy">Target Url<span class="redstar">*</span></label>
                                <input type="url" class="form-control" name="target_url" placeholder="Enter the QR url">
                            </div>
                            <div class="col-md-12 addTargetCode mb-3">
                                <label class="fancy">Target Code<span class="redstar">*</span></label>
                                <input type="text" class="form-control" name="target_code" placeholder="Enter the Code">
                            </div>

                            <div class="col-md-12">
                                <label class="fancy">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="2">Pause</option>
                                    <option value="3">Disabled</option>
                                </select>

                                <ul class="form-help">
                                    <li>Active: active QR can be run</li>
                                    <li>Pause: stop the QR</li>
                                    <li>Disabled: disabled not visible to publisher</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Create Multiple QR Modal --}}
        <div class="modal fade" id="createMultipleQRModal" tabindex="-1" aria-labelledby="createMultipleQRModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createMultipleQRModal">Create Multiple QRs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('create-multiple-qr', $project) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <h5>Follow these steps to create multiple QR codes</h5>

                            <ol>
                                <li>
                                    Download the sample CSV file to your computer <a class="btn btn-sm btn-success"
                                        href="{{ asset('/files/template/batch_qr.csv') }}" download>Download CSV</a>

                                    <ul>
                                        <li>
                                            <small>First column: QR code name</small>
                                        </li>
                                        <li>
                                            <small>Second column: Target(URL/Code)</small>
                                        </li>
                                    </ul>

                                </li>
                                <li class="mt-1">
                                    Open the file with your preferred text editor, complete it and save it as CSV
                                </li>
                                <li class="mt-1">
                                    Upload the file
                                    <div class="form-group">
                                        <label class="fancy">Select QR Type<span
                                                class="redstar">*</span></label>
                                        <select name="qr_type" id="qrType" class="form-control col-md-6">
                                            <option value="url">URL</option>
                                            <option value="code">Code</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="file" id="file" class="form-control-file">
                                    </div>

                                </li>
                            </ol>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit QR Modal --}}
        <div class="modal fade" id="editQRModal" tabindex="-1" aria-labelledby="editQRModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editQRModal">Edit QR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label class="fancy">Title<span class="redstar">*</span></label>
                                <input type="text" class="form-control" name="title" required
                                    placeholder="Enter the QR name" id="editTitle">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fancy">Select QR Type<span class="redstar">*</span></label>
                                <select name="qr_type" class="form-control" id="editQrType">
                                    <option value="url">URL</option>
                                    <option value="code">Code</option>
                                </select>
                            </div>

                            <div class="col-md-12 editTargetUrl mb-3">
                                <label class="fancy">Target Url<span class="redstar">*</span></label>
                                <input type="url" class="form-control" name="target_url" placeholder="Enter the QR url"
                                    id="editTargetUrl">
                            </div>
                            <div class="col-md-12 editTargetCode mb-3">
                                <label class="fancy">Target Code<span class="redstar">*</span></label>
                                <input type="text" class="form-control" name="target_code" placeholder="Enter the Code"
                                    id="editTargetCode">
                            </div>

                            <div class="col-md-12">
                                <label class="fancy">Status</label>
                                <select name="status" class="form-control" id="editStatus">
                                    <option value="1">Active</option>
                                    <option value="2">Pause</option>
                                    <option value="3">Disabled</option>
                                </select>

                                <ul class="form-help">
                                    <li>Active: active QR can be run</li>
                                    <li>Pause: stop the QR</li>
                                    <li>Disabled: disabled not visible to publisher</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('partial.deleteModal')
    @endsection
    @section('scripts')
        @parent
        {{-- <script type="text/javascript" src="{{ asset('front/js/welcome.js') }}"></script> --}}
        <script>
            // Toggle all checkboxes
            $('#unarchivedQRCheckAll').change(function(e) {
                $('.unarchived-row-checkbox').prop('checked', ($('#unarchivedQRCheckAll').is(':checked')))
            });
            $('#archivedQRCheckAll').change(function(e) {
                $('.archived-row-checkbox').prop('checked', ($('#archivedQRCheckAll').is(':checked')))
            });
            // Show/hide sub menu
            $('.qr-checkbox').change(function(e) {
                // console.log('check');
                if ($('.qr-checkbox').is(':checked')) {
                    $('.sub-main-menu').show('600')
                } else {
                    $('.sub-main-menu').hide('600')
                }
            });

            $(document).ready(function() {
                $('.addTargetCode').hide();
                // Batch QR Archive
                $("#btn_batch_archive").on('click', function(event) {
                    var qrIDs = $("table input[name='batch_action[]']:checked").map(function() {
                        return $(this).val();
                    }).get();
                    // console.log(qrIDs);
                    let token = $(this).attr('data-token');
                    let project = `{{ str_replace(' ', '_', $project->name) }}`;

                    // data to be sent to the POST request
                    let data = {
                        project: project,
                        qrIDs: qrIDs
                    }

                    fetch(`${window.location.origin}/multiple-qr-archive`, {
                            method: "POST",
                            body: JSON.stringify(data),
                            headers: {
                                "Content-type": "application/json; charset=UTF-8",
                                'X-CSRF-TOKEN': token
                            }
                        })
                        .then(res => {
                            window.location.reload();
                        })
                    // .then(data => {
                    //     var a = document.createElement('a');
                    //     a.href = window.URL.createObjectURL(data);
                    //     a.download = project;
                    //     a.click();
                    // });
                });

                // Batch QR Download
                $("#btn_batch_download").on('click', function(event) {
                    var qrIDs = $("table input[name='batch_action[]']:checked").map(function() {
                        return $(this).val();
                    }).get();
                    // console.log(qrIDs);
                    let token = $(this).attr('data-token');
                    let project = `{{ str_replace(' ', '_', $project->name) }}`;

                    // data to be sent to the POST request
                    let data = {
                        project: project,
                        qrIDs: qrIDs
                    }

                    fetch(`${window.location.origin}/multiple-qr-download`, {
                            method: "POST",
                            body: JSON.stringify(data),
                            headers: {
                                "Content-type": "application/json; charset=UTF-8",
                                'X-CSRF-TOKEN': token
                            }
                        })
                        .then(res => {
                            return res.blob();
                        })
                        .then(data => {
                            var a = document.createElement('a');
                            a.href = window.URL.createObjectURL(data);
                            a.download = project;
                            a.click();
                        });
                });
            });

            // Toggle between qrType
            $('#addQrType').on('change', function(e) {
                const qrType = $('#addQrType').find(':selected').val();
                if (qrType == 'url') {
                    $('.addTargetUrl').show();
                    $('.addTargetCode').hide();
                } else {
                    $('.addTargetUrl').hide();
                    $('.addTargetCode').show();
                }
            });
            $('#editQrType').on('change', function(e) {
                const qrType = $('#editQrType').find(':selected').val();
                if (qrType == 'url') {
                    $('.editTargetUrl').show();
                    $('.editTargetCode').hide();
                } else {
                    $('.editTargetUrl').hide();
                    $('.editTargetCode').show();
                }
            });

            // Edit QR Modal
            $('#editQRModal').on('show.bs.modal', function(e) {
                let button = $(e.relatedTarget); // Button that triggered the modal
                let route = button.data('route');
                let title = button.data('title');
                let type = button.data('qrtype');
                let target = button.data('qrtarget');
                let status = button.data('status');
                let modal = $(this);
                modal.find('form').prop('action', route);
                modal.find('#editTitle').val(title);
                if (type) {
                    modal.find(`#editQrType option[value='${type}']`).prop('selected', true);
                    // } else {
                    //     modal.find(`#editQrType`).prepend(`<option value="" disabled selected>Select QR Type</option>`);
                }
                if (type == 'url') {
                    $('.editTargetCode').hide();
                    $('.editTargetUrl').show();
                    modal.find('#editTargetUrl').val(target);
                } else {
                    $('.editTargetUrl').hide();
                    $('.editTargetCode').show();
                    modal.find('#editTargetCode').val(target);
                }
                modal.find(`#editStatus option[value='${status}']`).prop('selected', true);
            });
        </script>
    @endsection
