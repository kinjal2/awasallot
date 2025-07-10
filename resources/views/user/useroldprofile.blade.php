@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<div class="content">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6"> 
               <h1 class="m-0 text-dark">{{ __('profile.user_old_details') }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                  <li class="breadcrumb-item active">{{ __('profile.user_old_details') }}</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
</div>
   <!-- /.content-header -->

    
   <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-head">
         <div class="card-header">
            <h3 class="card-title">{{ __('profile.user_old_details') }}</h3>
         </div>
          @include('user.userprofile_tabview')
         <!-- </div> -->
                  </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</div>

@endsection



