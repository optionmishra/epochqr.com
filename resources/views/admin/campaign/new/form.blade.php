@extends('layouts.dashboard')

@section('styles')
  @parent   
  <link href="{{ asset('tracklead/css/tab-form.css') }}" rel="stylesheet">

  <style>
    .table td, .table th{
      padding: 5px 5px;
      font-size: 12px;
    }
    .stick {
      position: sticky;
      top: 0px;
    }

    .abs {
      position: absolute;
      bottom: 0px;
      width: 92.5%;
    }
  </style>
  
@endsection

@section('breadcumb') 

@section('pageTitle')  
  <a href="#" class="nav-link">Offer</a>
@endsection

@endsection

@section('content') 

<div class="form-wrapper">  
    
    <div class="header bg-white py-2 rounded">
      <div class="container-fluid px-1">
          
          <div class="row">
            <div class="col-md-3 left-conatainer">
                <div id="sticky-anchor"></div>
                <!-- Tabs nav -->
                <div  class="nav flex-column nav-pills nav-pills-custom sideNavTab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    
                <a class="nav-link mb-3 p-3 active" data-toggle="pill" href="#v-offer-detail" role="tab" aria-selected="true">
                  <span class="font-weight-bold small text-uppercase d-block">Basic Detail</span>
                  <span class="font-weight-bold small d-block mt-2">Basic information for campaign</span>
                </a>                

              </div>
            </div>

            <div class="col-md-9 right-container">
                
              <!-- Tabs content -->
                
              <div class="tab-content rounded" id="v-pills-tabContent">
                  
                <div class="tab-pane fade rounded show active px-4" id="v-offer-detail" role="tabpanel">
                  <h4 class="mb-4">Basic Information</h4>

                  <form role="form" id="addOfferForm" method="post" autocomplete="off" enctype="multipart/form-data">

                  @csrf
                  
                  <div class="row">
                    
                    <div class="col-md-12 mb-2">
                      <label class="fancy">Title<span class="redstar">*</span></label>
                      <input type="text" class="form-control" name="title" required>
                      <p class="m-0 help">Here you have to enter the campaign name</p>
                    </div>  

                    <div class="col-md-12 mb-2">
                      <label class="fancy">Target Url<span class="redstar">*</span></label>
                      <input type="url" class="form-control" name="target_url" required>
                      <p class="m-0 help">Here you have to enter the campaign url</p>
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
                 
                    <div class="row mt-4">
                      <div class="col-md-12 text-right">
                        <button type="submit" class="btn-info btn-save mr-2">Create</button></div>
                    </div>
                </form>

                </div>

                <!-- Declined Tools -->
                
              </div>

            </div>
          </div>
          
      </div>
    </div>  

</div>  

@endsection

@section('scripts')
  @parent   
  
  <script src="{{asset('tracklead/js/offer-form.js')}}"></script>        
@endsection
