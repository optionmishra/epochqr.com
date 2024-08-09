@extends('layouts.dashboard')

@section('styles')
    @parent
    <link href="{{ asset('selectize/css/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('tracklead/css/manage-publisher.css') }}" rel="stylesheet">

    <style>
        .modal {
            top: 55px;
        }

        .topFilter {
            display: block;
            flex-wrap: nowrap;
            padding: 6px 8px;
            background: #fff;
        }

        .topFilter .form-control.selectConrol {
            padding: 4px 0;
            cursor: pointer;
            font-size: 13px;
            color: #6e707e;
            height: 28px;
            border-radius: 2px;
            width: 110px;
            margin-right: 8px;
        }

        .content .selectize-input {
            border: 1px solid #ededed;
            color: #6e707e;
            font-size: 12px;
            padding: 4px 8px;
        }

        .content .selectize-control.plugin-remove_button .remove-single {
            right: 7px;
            top: -4px;
            font-size: 20px;
            text-decoration: none;
        }

        .content .topFilter form.SearchForm .selectize-control,
        .content .topFilter .selectize-input {
            height: auto;
            top: auto;
        }

        .table-title {
            font-size: 1.1rem !important;
            font-weight: 400;
        }

    </style>
@endsection

@section('breadcumb')
@section('pageTitle')
    <a href="#" class="nav-link">Users</a>
@endsection
@endsection

@section('content')
<div class="row m-0">
    <div class="col-lg-12 p-0">
        <div class="card equalHeight-1 bg-shadow list mb-4">
            <div class="card-header d-flex justify-content-between">
                <span class="table-title">Users</span>

                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal"
                    data-target="#createuserModal"><i class="las la-plus font-size-18"></i> Create user
                </button>
            </div>
            <div class="card-body p-0">

                <div class="fancyScroll">
                    <div class="table-responsive">
                        <table class="table-borderless table-centered table-nowrap table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Projects</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $key=>$user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <p class="m-0"><a class="title"
                                                    href="{{-- route('admin.campaigns.index',$user) --}}">{{ ucfirst($user->name) }}</a></p>
                                        </td>
                                        <td>{{ count($user->projects) }}</td>
                                        <td>
                                            @if ($user->status)
                                                <a href="{{ route('admin.user.block', $user) }}"><button
                                                        class="btn btn-sm btn-danger">Block</button></a>
                                            @else
                                                <a href="{{ route('admin.user.unblock', $user) }}"><button
                                                        class="btn btn-sm btn-success">Unblock</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-left" colspan="13">
                                            Data not found!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="paginate row m-0 p-2">
                    <div class="totalResult col-lg-6 align-self-center">
                        <p class="m-0">{{ $users->firstItem() }}-
                            {{ $users->perPage() * ($users->currentPage() - 1) + $users->count() }} of
                            {{ $users->total() }} entries
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <nav aria-label="Page navigation example">
                            {{ $users->links() }}
                            {{-- <ul class="pagination">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul> --}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- Create user Modal --}}
<div class="modal fade" id="createuserModal" tabindex="-1" aria-labelledby="createuserModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createuserModal">Create user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{-- route('admin.users.add') --}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input class="form-control" type="text" name="name" placeholder="Enter user Name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="{{ asset('selectize/js/selectize.min.js') }}"></script>
<script>
    $(document).ready(function() {
        //
        $('.selectize-multiple').selectize({
            delimiter: ',',
            persist: true,
            create: false
        });
        //
        $('tr').click(function() {
            var inp = $(this).find('.check');
            var tr = $(this).closest('tr');
            inp.prop('checked', !inp.is(':checked'))

            tr.toggleClass('isChecked', inp.is(':checked'));
        });

        // do nothing when clicking on checkbox, but bubble up to tr
        $('.check').click(function(e) {
            e.preventDefault();
        });

        //
    });
</script>
@endsection
