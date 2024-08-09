@extends('layouts.dashboard')

@section('styles')
  @parent
  <link href="{{asset('selectize/css/selectize.css')}}" rel="stylesheet">
  <link href="{{ asset('tracklead/css/manage-publisher.css') }}" rel="stylesheet">

  <style>
      .modal{
          top: 55px;
      }
    .topFilter {
      display: block;
      flex-wrap: nowrap;
      padding: 6px 8px;
      background: #fff;
    }

    .topFilter .form-control.selectConrol{
      padding: 4px 0;
      cursor: pointer;
      font-size: 13px;
      color: #6e707e;
      height: 28px;
      border-radius: 2px;
      width: 110px;
      margin-right: 8px;
    }
    .content .selectize-input{
      border: 1px solid #ededed;
      color: #6e707e;
      font-size: 12px;
      padding: 4px 8px;
    }

    .content .selectize-control.plugin-remove_button .remove-single{
      right: 7px;
      top: -4px;
      font-size: 20px;
      text-decoration: none;
    }

    .content .topFilter form.SearchForm .selectize-control, .content .topFilter .selectize-input{
      height: auto;
      top: auto;
    }
    .table-title{
        font-size: 1.1rem !important;
        font-weight: 400;
    }
  </style>
@endsection

@section('breadcumb')

@section('pageTitle')
  <a href="#" class="nav-link">Offer</a>
@endsection

@endsection

@section('content')


<div class="row m-0">

    <div class="col-lg-12 p-0">
      <div class="card equalHeight-1 bg-shadow mb-4 list">
          <div class="card-body p-0">

            <div class="topFilter pt-3">
                  <span class="table-title">List of projects</span>


              {{-- <div class="row align-items-center m-0">
                <div class="col-lg-9 col-sm-12">

                  <div class="row align-items-center">

                    <select name="pub_status" class="form-control selectConrol">
                      <option value="1">Active</option>
                      <option value="0">Pending</option>
                      <option value="2">Denied</option>
                    </select>

                  </div>

                </div>

                <div class="col-lg-3 col-sm-12 text-right p-0">
                  <form method="get" class="ClickForm" action="#">
                    <input type="search" name="OfferStr" placeholder="Search Company Email or Id" value="" required="">
                    <button type="submit"><i class="ti-search"></i></button>
                  </form>
                </div>

              </div> --}}

            </div>

            <div class="topFilter mb-2">

              <div class="row align-items-center m-0">
                <div class="col-lg-12 p-0">

                  {{-- <button data-bs-toggle="modal" data-bs-target="#createProjectModal" class="btnaddPublisher btn-link mr-2">
                     Create Project
                  </button> --}}
                  <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#createProjectModal"><i class="las la-plus font-size-18"></i> Create Project
</button>

                </div>

              </div>

            </div>

              <div class="fancyScroll">

                <div class="table-responsive">
                  <table class="table table-borderless table-centered table-nowrap">

                    <thead>
                      <tr>
                        <th style="width: 10px;">Id</th>
                        <th>Name</th>
                        <th class="text-right" style="width: 20px;"></th>
                      </tr>
                    </thead>

                    <tbody>

                      @forelse($projects as $key=>$project)

                      <tr>
                        <td>
                          {{++$key}}
                        </td>
                        <td>
                          <p class="m-0"><a class="title" href="{{route('admin.campaigns.index',$project)}}">{{ucfirst($project->name)}}</a></p>
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
              <div class="paginate row m-0">
                <div class="totalResult col-lg-6 align-self-center">
                  <p class="m-0">{{$projects->firstItem()}}-
                        {{($projects->perPage() * ($projects->currentPage() -1)) + $projects->count()}} of {{$projects->total()}} entries</p>
                </div>
                <div class="col-lg-6">
                  <nav aria-label="Page navigation example">
                      {{$projects->links()}}
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
      <form action="{{route('admin.projects.add')}}" method="POST">
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


@endsection

@section('scripts')
  @parent
  <script src="{{asset('selectize/js/selectize.min.js')}}"></script>
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
