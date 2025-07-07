@extends(\Config::get('app.theme').'.master') @section('title', $page_title) @section('content') 
<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('request.new_request') }}</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('common.home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('request.new_request') }} </li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row">
        <div class=" col-md-12">
            <div class="card  card-head">
                <div class="card-header">
                    <h3 class="card-title"> {{ __('request.request_details') }}</h3>
                </div>
                <div class="card-body">

  @if($isEdit)
    <!-- Show Tabs -->
    <ul class="nav nav-tabs" id="quarterTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') != 'tab2' ? 'active' : '' }}" id="request-tab" data-bs-toggle="tab" data-bs-target="#request" type="button" role="tab">
               User Details
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') == 'tab2' ? 'active' : '' }}" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                Request Form
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content mt-3" id="quarterTabContent">
        <div class="tab-pane fade {{ session('active_tab') != 'tab2' ? 'show active' : '' }}" id="request" role="tabpanel">
            @include('user.userprofile_tabview')
        </div>

        <div class="tab-pane fade {{ session('active_tab') == 'tab2' ? 'show active' : '' }}" id="history" role="tabpanel">
             @include('user.newqueter_tabview')
        </div>
    </div>
@else
   @include('user.newqueter_tabview') 
@endif
                    <!-- </div> -->
                  </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</div> 

@endsection 
@push('page-ready-script') 
@endpush

