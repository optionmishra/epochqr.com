@extends('layouts.dashboard')

@section('styles')
  @parent
  <link href="{{asset('selectize/css/selectize.css')}}" rel="stylesheet">
  <link href="{{ asset('tracklead/css/manage-publisher.css') }}" rel="stylesheet">

  <style>
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
    .modal{
        top:55px;
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
                  <span class="table-title">Project: {{$project->name}}</span>

              <div class="row align-items-center m-0">
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

              </div>

            </div>

            <div class="topFilter mb-2">

              <div class="row align-items-center m-0">
                <div class="col-lg-12 p-0">
<button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#createQRModal"><i class="las la-plus font-size-18"></i> Create QR
</button>
                  {{-- <a href="{{route('admin.campaign.add')}}" class="btnaddPublisher btn-link mr-2">
                    <i class="las la-plus font-size-10"></i> Create QR
                  </a> --}}

                </div>

              </div>

            </div>

              <div class="fancyScroll">

                <div class="table-responsive">
                  <table class="table table-borderless table-centered table-nowrap">

                    <thead>
                      <tr>

                        <th style="width: 10px;">Id</th>
                        <th>QR</th>
                        <th>Campaign</th>
                        <th>link</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th class="text-right" style="width: 20px;"></th>
                      </tr>
                    </thead>

                    <tbody>

                      @forelse($campaigns as $key=>$offer)

                      <tr>
                        <td>
                          {{++$key}}
                        </td>

                        <td>
                          <img class="" src="{{$qrPath}}{{$offer->id}}/{{$offer->qrcode}}" width="80">
                        </td>

                        <td>
                          <p class="m-0"><a class="title" href="#">{{ucfirst($offer->title)}}</a></p>
                        </td>

                        <td>
                          <p class="m-0"><a class="title" href="#">http://uqr.test/{{$offer->link}}</a></p>
                        </td>

                        <td>
                          @if($offer->status == 1)
                            <span class="font-size-12">Active</span>
                          @elseif($offer->status == 2)
                            <span class="font-size-12">Pause</span>
                          @elseif($offer->status == 3)
                            <span class="font-size-12">Disabled</span>
                          @else
                          @endif

                        </td>
                        <td>
                            <a href="{{$qrPath}}{{$offer->id}}/{{$offer->qrcode}}" class="btn btn-sm btn-outline-primary" download>Download</a>
                        </td>

                        <td class="text-right">
                          <div class="dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#b9b9b9" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"></path>
                              </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                              <a href="#" class="dropdown-item">
                                <i class="ti-power-off mr-2"></i> Clicks
                              </a>
                            </div>
                          </div>

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
                      <p class="m-0">{{$campaigns->firstItem()}}-
                        {{($campaigns->perPage() * ($campaigns->currentPage() -1)) + $campaigns->count()}} of {{$campaigns->total()}} entries</p>
                    </div>
                    <div class="col-lg-6">
                        <nav aria-label="Page navigation example">
                            {{$campaigns->links()}}
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
      <form action="{{route('admin.campaign.formProcess', $project)}}" method="POST">
        @csrf
      <div class="modal-body">
          <div class="col-md-12 mb-3">
            <label class="fancy">Title<span class="redstar">*</span></label>
            <input type="text" class="form-control" name="title" required placeholder="Enter the campaign name">
        </div>

        <div class="col-md-12 mb-3">
            <label class="fancy">Target Url<span class="redstar">*</span></label>
            <input type="url" class="form-control" name="target_url" required placeholder="Enter the campaign url">
        </div>

        <div class="col-md-12">
            <label class="fancy">Status</label>
            <select name="status" class="form-control">
            <option value="1">Active</option>
            <option value="2">Pause</option>
            <option value="3">Disabled</option>
            </select>

            <ul class="form-help">
            <li>Active: active campaign can be run</li>
            <li>Pause: stop the campaign</li>
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
