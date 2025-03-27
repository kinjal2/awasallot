@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-6">
            <h1 class="m-0 text-dark">Higher Quarter Request</h1>
          </div><!-- /.col -->
          <div class="col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Higher Quarter Request</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


	<div class="col-md-md-12 px-3">
            <!-- general form elements -->
            <div class="card  card-head">
              <div class="card-header">
                <h3 class="card-title">User Details</h3>
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div><br />
    			@endif
              </div>
              <!-- /.card-header -->
              <!-- form start -->
			  <form method="POST" name="annexurea" id="annexurea" action="{{ url('saveHigherCategoryReq') }}" enctype="multipart/form-data">
@csrf 

	<div class="card-body">
		<div class="row">
        <div class="col-md-6">
				<div class="form-group">
				<label for="quartertype">{{  __('request.Quarter_category') }}</label> <span class="error">*</span> 
        {{ Form::select('quartertype',[null=>__('common.select')] + getBasicPay(),'',['id'=>'quartertype','class'=>'form-control select2']) }}                                       
				</div>
			</div>
		
		
		</div>
		<div class="mt-3">
			<div class="card-header">
				<h3 class="card-title"> ગાંધીનગરમાં અત્યારે જે કક્ષાના વસવાટમાં રહેતા હો તેની માહિતી</h3> <span class="error">*</span> 
			</div>
			<div class="card-body border_light">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
							<label for="prv_quarter_type">{{  __('request.quarter_type') }}</label>  <span class="error">*</span> 
							{{ Form::select('prv_quarter_type',[null=>__('common.select')] + getlowerquatercategory(),'',['id'=>'prv_quarter_type','class'=>'form-control select2']) }}                                       
						</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label for="prv_area">{{  __('request.area') }} </label>  <span class="error">*</span> 
							{{ Form::select('prv_area',[null=>__('common.select')] + getAreaDetails(),'',['id'=>'prv_area','class'=>'form-control select2']) }}                                       
					
							
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label for="prv_blockno">{{  __('request.blockno') }} </label>  <span class="error">*</span> 
							<input type="text" value=""  class="form-control" id="prv_blockno" name="prv_blockno" placeholder="Enter Block No ">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label for="prv_unitno">{{  __('request.unitno') }} </label>  <span class="error">*</span> 
							<input type="text" value=""  class="form-control" id="prv_unitno" name="prv_unitno" placeholder="Enter Unit No">
							</div>
						</div>
						</div>
				
					<div class="row">
					
						<div class="col-md-6"> 
							<div class="form-group">
							<label for="prv_allotment_details">{{  __('request.allotment_details') }}</label>  <span class="error">*</span> 
							<input type="text" value=""  class="form-control"  name="prv_allotment_details" id="prv_allotment_details" placeholder="Alloatment Details">
							</div>
						</div> 
							<div class="col-md-6"> 
							<div class="form-group">
							<label for="prv_possession_date">{{  __('request.possession_date') }}</label>  <span class="error">*</span> 
								<div class="input-group date dateformat" id="prv_possession_date" data-target-input="nearest">
									<input type="text" value="" name="prv_possession_date"  class="form-control datetimepicker-input" data-target="#prv_possession_date"/>
									<div class="input-group-append" data-target="#prv_possession_date" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i>
										</div>
									</div>
									
								</div>	<label id="prv_possession_date-error" class="error" for="prv_possession_date"></label>
									</div>
						</div> 
						
					</div>
					<div class="row form-group">
						<label class="card-title mb-3"> અગાઉ ઉચ્ચલ કક્ષાનું વસવાટ ફાળવવામાં આવેલ હતું કે કેમ ?  <span class="error">*</span> &nbsp;</label>
							<div class="form-group clearfix">
								<div class="icheck-primary d-inline">
									<input type="radio" id="have_hc_quarter_y" name="have_hc_quarter_yn" 	value="Y">
									<label for="have_hc_quarter_y">{{  __('common.yes') }}</label>
								</div> &nbsp;&nbsp;
								<div class="icheck-primary d-inline">
									<input type="radio" id="have_hc_quarter_n" name="have_hc_quarter_yn" value="N">
									<label for="have_hc_quarter_n">{{  __('common.no') }}</label>
								</div>
								<label id="have_hc_quarter_yn-error" class="error" for="have_hc_quarter_yn"></label>
							</div>
					</div>
					<div class="row have_hc_quarter transfer sm-block" >
					<div class="col-md-3">
						<div class="form-group">
							<label for="hc_quarter_type">{{  __('request.quarter_type') }}</label>  <span class="error">*</span> 
							{{ Form::select('hc_quarter_type',[null=>__('common.select')] + getlowerquatercategory(),'',['id'=>'hc_quarter_type','class'=>'form-control select2']) }}                                       
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="hc_area">{{  __('request.area') }} </label>  <span class="error">*</span> 
							{{ Form::select('hc_area',[null=>__('common.select')] + getAreaDetails(),'',['id'=>'hc_area','class'=>'form-control select2']) }}                                       
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="hc_blockno">{{  __('request.blockno') }} </label>  <span class="error">*</span> 
							<input type="text" value=""  class="form-control" id="hc_blockno" name="hc_blockno" placeholder="Enter Block No">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="hc_unitno">{{  __('request.unitno') }} </label>  <span class="error">*</span> 
							<input type="text" value=""  class="form-control" id="hc_unitno" name="hc_unitno" placeholder="Enter Unit No">
						</div>
					</div>
					<div class="have_hc_quarter">
						<div class="form-group">
							<label for="Address">કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.</label>  <span class="error">*</span> 
							<textarea class="form-control" id="hc_allotment_details" name="hc_allotment_details" placeholder="Enter Allotment Detail"></textarea>				
						</div>
					</div>
				</div>
				<div class="row">
						<div class="">
							<div class="mt-3">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="agree_rules" name="agree_rules" >
									<label for="agree_rules"></label>                  
								</div>
								<label for="office_address">આ સાથે સામેલ રાખેલ ઉચ્ચગ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.</label> <span class="error">*</span> 						
							</div>
						</div>			
					</div> 				
			</div>
		</div>

	       
		
	

		
</div>		
		<!-- /.card-body -->
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	
</form>
            </div>
            <!-- /.card -->

          </div>
          
    <!-- /.content -->
  </div>
		   
	
@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script type="text/javascript">
      $(function() {              
           // Bootstrap DateTimePicker v4
           $('.dateformat').datetimepicker({
                 format: 'DD-MM-YYYY'
           });
        });  
 $(document).ready(function() {	
	$('.have_hc_quarter').hide();	
$('input[name=have_hc_quarter_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
        $('.have_hc_quarter').show();
    }
    else if (this.value == 'N') {
         $('.have_hc_quarter').hide();
    }
}); 
jQuery.validator.addMethod("cdate",
				   function (value, element)
				    { 
					return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
				    },
				    "Please specify the date in DD-MM-YYYY format"
				    );
	
$("#annexurea").validate({
		    rules : {
			
			quartertype		:	"required",
			prv_quarter_type	:	"required",
			prv_area		:	"required",
			prv_blockno		:	{required:true,number:true},
			prv_unitno		:	{required:true,number:true},
			prv_allotment_details	:	"required",
			prv_possession_date	:	{required:true,cdate:true},
			have_hc_quarter_yn	:	"required",
			hc_quarter_type		:	"required",
			hc_area			:	"required",
			hc_blockno		:	{required:true,number:true},
			hc_unitno		:	{required:true,number:true},
			hc_allotment_details	:	"required",
			agree_rules:	"required",
		    }
		});
})		;  
</script>
@endpush