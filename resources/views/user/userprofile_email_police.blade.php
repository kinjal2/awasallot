@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<div class="content">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">{{  __('profile.user_detail') }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">{{  __('common.home') }}</a></li>
                  <li class="breadcrumb-item active">{{  __('profile.user_detail') }}</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-head">
         <div class="card-header">
            <h3 class="card-title">{{  __('profile.user_detail') }}</h3>
		  </div>
         @include(Config::get('app.theme').'.template.severside_message')
         @include(Config::get('app.theme').'.template.validation_errors')
         <!-- /.card-header -->
         <!-- form start -->
         <form method="POST" action="{{ url('profiledetails_email') }}" enctype="multipart/form-data" name='frm' id="frm">
            @csrf
            <div class="card-body">
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="Name">{{  __('profile.name') }}</label>
                        <input type="text" value="{{isset($users->name)?$users->name:''}}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter name" readonly>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                <div class="col-md-3">
                     <div class="form-group">
                        <label for="maratial_status">{{  __('profile.office_email') }} </label>
                        <input type="text"  value="{{isset($users->office_email_id)?$users->office_email_id:''}}"  class="form-control" id="office_email_id" name="office_email_id" placeholder="Office Email Id">
                     </div>
                  </div>
                 
                 
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="is_police_staff"> {{  __('profile.is_police') }} <span class="error">*</span></label>
                        {{ Form::select('is_police_staff',['' => 'Select An Option'] + getYesNo(),($users->is_police_staff)?$users->is_police_staff:'',['id'=>'is_police_staff','class'=>'form-control select2']) }}                                       
                     </div>
                  </div>
                  <div class="col-md-3" id='police_staff'  >
                     <div class="form-group">
                        <label for="maratial_status">Download  Police Staff Cetificate</label><br>
                        <a class="btn btn-sm btn-success" href="{{ route('download_file', ['filename' => 'police_staff_certificate.pdf']) }}"> Police Staff Cetificate</a> </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="exampleInputFile"> Upload Police Staff Certificate</label>
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image" name="image">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                           <div class="input-group-append">
                              <span class=" custom-up" id="">Upload</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  
                
               </div>
               <!-- /.card-body -->
               <div class="mt-4">
                  <button type="submit" class="btn btn-primary"> {{  __('common.submit') }}</button>
               </div>
            </div>
         </form>
      </div>
      <!-- /.card -->
   </div>
</div>
<!-- /.content -->
@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<script type="text/javascript">
      $(function() {              
           // Bootstrap DateTimePicker v4
           $('.dateformat').datetimepicker({
                 format: 'DD-MM-YYYY'
           });
        }); 
		$('.numeric').keypress(function(event){
               return numF(event);
          });
		 $('.alfanumaric').keypress(function(event){
               return anFS(event);
          });  
		$( "#frm" ).submit(function( event ) {
			//var str=$("#pancard").val();

		//	$('#pancard').val(window.btoa(str));
			});
		  

          
                    
           
            
            $.validator.addMethod("pan", function(value, element) {
                return this.optional(element) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test(value);
            }, "Invalid PAN No.");
           $.validator.addMethod("validExt", function(value, element) {
                if(this.optional(element))
                    return true;
                else
                {
                    var arr = value.split(".");
                    var ret = true;
                    if(arr.length > 2)
                    {
                        ret = false;
                    }
                    if(/^[a-z0-9.\s]+$/i.test(value) == false)
                    {
                        ret = false;
                    }
                        return ret;
                }
            }, "File name should not contain special characters or more than one dots.");
          $("#frm").validate({
              rules:{
                  "is_police_staff" : "required"
                  
              }
          });
      	
        
</script>


@endpush