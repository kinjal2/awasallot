@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<style type="text/css">
    .success{
        background: {{ URL::asset('images/success.png') }} no-repeat scroll 0 2px #DEF9D1 !important;
        color: #409300;
        font-weight: bold;
    }
    .notification{
        background: {{ URL::asset('/images/notify.png') }} no-repeat scroll 0 2px #F9F3D9;
        font-weight: bold;
        color: #9B7203;
    }
    .notify-list li{margin-top:5px;}
    .notification-success {
    background: URL("/images/success.png") no-repeat scroll 0 2px #DEF9D1 !important ;
    border: 1px solid;
    color: green;
    font-weight: bold;
    padding: 5px 0 5px 45px;
    }
    .notification-fail {
    background: URL("/images/notify.png") no-repeat scroll 14px 8px #f9f9b3;
    border: 1px solid;
    color: brown;
    font-weight: bold;
    padding: 5px 0 5px 45px;
}


    
</style>
    <!-- Main content -->
    <div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  	@if(session()->has('message'))
    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session()->get('message') }}
    </div>
@endif
      <div class="container-fluid px-3">
      <div class="row">
          <div class="col-md-6">
            <div class="card card-head">
              <div class="card-header">
                <h3 class="card-title">Basic Pay Wise Quarter Category</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered  table-hover custom_table">
                  <thead>                  
                    <tr>
                        <th rowspan="2" width="3%">Quarter Category</th>
                        <th colspan="2" width="2%">Basic Pay Range</th>
                        <th colspan="4">Monthly Rent Payable</th>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Normal</th>
                        <th>Standard</th>
                        <th>Economic</th>
                        <th>Market</th>
                    </tr>
                   </thead>
                  <tbody>
                   @foreach($quarterlist ?? '' as $q)  
                 <tr style="{{ $quarterselect->quartertype==$q->quartertype ? 'background-color:#DEF9D1;font-weight:bold;' :'' }}"> 
                    <td> {{ $q->quartertype }}</td>
                    <td> {{ $q->bpay_from }}</td>
                    <td> {{ $q->bpay_to }}</td>
                    <td> {{ $q->rent_normal }}</td>
                    <td> {{ $q->rent_standard }}</td>
                    <td> {{ $q->rent_economical }}</td>
                    <td> {{ $q->rent_market }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>  </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="card card-head">
              <div class="card-header">
                <h3 class="card-title">Notification</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <ul class="notify-list">
               @foreach($notification as $q1)
              
               <li class="{{ $q1->type=='S' ? 'notification-success' :'notification-fail' }}">{{ $q1->message }}</li>
                @endforeach
                    </ul>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script type="text/javascript">
  
</script>
@endpush