@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">New Request</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Request</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


	   <div class="col-md-12">
			 <!-- general form elements -->
			 <div class="card card-default">
			   <div class="card-header">
				 <h3 class="card-title">Request Details</h3>
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
         <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Tabs</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Tab 1</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Tab 2</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Tab 3</a></li>
                 
                </ul>
              </div><!-- /.card-header -->
			   <!-- /.card-header -->
			   <!-- form start -->
			   <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('savenewrequest') }}" enctype="multipart/form-data">
@csrf 

          <div class="col-12 col-sm-12 col-md-12">
            <div class="info-box">
			
              <div class="col-6 col-sm-6 col-md-6 border-right">
				<p class="text-muted"><b>ક્વાર્ટર કેટેગરી</b></p>
				<hr>
				<p class="text-muted"><b>જો નવી નિમણૂંક હોય / બદલી થયેલ હોય તો કઇ તારીખ</b></p>
			  </div>
			  
			  <div class="col-6 col-sm-6 col-md-6">
              {{ Form::select('quartertype',[null=>__('common.select')] + getBasicPay(),'',['id'=>'quartertype','class'=>'form-control ','style' => 'width:50%;']) }}                                       
	
			   
			  <br><hr>
              <div class="input-group date dateformat" id="deputation_date" data-target-input="nearest">
                        <input type="text" value="" name="deputation_date"  class="form-control datetimepicker-input" data-target="#deputation_date"/>
                        <div class="input-group-append" data-target="#deputation_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i>
							</div>
						</div>
					   
                    </div> <label id="deputation_date-error" class="error" for="deputation_date"></label> </div>
			  
            </div>
          </div>
		  
		  <!-- Row 2 -->
		  
		  <div class="col-12 col-sm-12 col-md-12">
            <div class="info-box">
			
              <div class="col-6 col-sm-6 col-md-6 border-right">
				
				<p class="text-muted"><b>બદલી થઈ ને આવ્યા છે /પ્રતિનિયુક્તિ ઉપર આવ્યા છે?</b></p>
				<hr>
				
				<div class="row transfer">
                  <div class="col-3">
                    <p class="text-muted" style="text-align:center;"><b>હોદ્દો</b></p>
                  </div>
                  <div class="col-9">
                    <input class="form-control" name="old_desg" id="old_desg" type="text" style="width:100%">
                  </div>                  
                </div>
				
				
			  </div>
			  
			  <div class="col-6 col-sm-6 col-md-6"> 
				  	<div class="form-group">
				<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="deputation_y" name="deputation_yn" 	value="Y">
                        <label for="deputation_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="deputation_n" name="deputation_yn" value="N">
                        <label for="deputation_n">{{  __('common.no') }}
                        </label>
                      </div>
					
                    </div><label id="deputation_yn-error" class="error" for="deputation_yn"></label>
				</div>
				<hr>
				
				<div class="row transfer">
                  <div class="col-3">
                    <p class="text-muted"><b>કાચેરી નુ નામ</b></p>
                  </div>
                  <div class="col-9">
                    <input class="form-control" type="text"  name="old_office" id="old_office"   style="width:100%">
                  </div>                  
                </div>
								
			  </div>
			  		  
            </div>
          </div>
		  
		  <!-- Row 3 -->
		  
		  <div class="col-12 col-sm-12 col-md-12">
            <div class="info-box">
			
              <div class="col-6 col-sm-6 col-md-6 border-right">
				
				<p class="text-muted"><b>આ પહેલા ના સ્થ્ળે સરકારશ્રીએ વસવાટ ની સવલત આપી છે?</b></p>
				<hr>
				
				<div class="place">    				   
					<p class="text-muted" style="line-height:35px;"><b>માસીક ભાડું</b>
						<input class="form-control"  name="prv_rent"  id="prv_rent" type="text" style="float:right;width: 80%;">
					</p>									  
				  <hr>
				    <p class="text-muted" style="line-height:35px;"><b>વસવાટ નો ક્વાર્ટર નંબર</b>
						<input class="form-control" name="prv_building_no" id="prv_building_no" type="text" style="float:right;width: 70%;">
					</p>	  
				  <hr>				 
                    <p class="text-muted" style="line-height:35px;text-align:end;"><b>કોલોની નું નામ/રીક્વીઝીશન કરેલ મકાન ની વિગત</b></p>                  
                                    
                </div>
				
						
			  </div>
			  
			  <div class="col-6 col-sm-6 col-md-6">
					<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="old_allocation_y" name="old_allocation_yn" 	value="Y">
                        <label for="old_allocation_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="old_allocation_n" name="old_allocation_yn" value="N">
                        <label for="old_allocation_n">{{  __('common.no') }}
                        </label>
                      </div>
					  <label id="old_allocation_yn-error" class="error" for="old_allocation_yn"></label>
                    </div>
				<hr>		
				
				<div class="place">
                    
					<p class="text-muted" style="line-height:35px;"><b>વસવાટ ની કેટેગરી</b> 
						   {{ Form::select('prv_quarter_type',[null=>__('common.select')] + getBasicPay(),'',['id'=>'prv_quarter_type','class'=>'','style' => 'width:50%;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #495057;height: 32px;']) }}                                       
	
					</p>
					<hr>
					 <p class="text-muted" style="line-height:35px;">
					 <b>મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે કેમ?</b>&nbsp;&nbsp;
					 	{{ Form::select('prv_handover',getYesNo(),'',['id'=>'prv_handover','class'=>'','style'=>'width:21%;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #495057;height: 32px;']) }}                                       
		
					</p>
					<hr>
					
					<input class="form-control" type="text" name="prv_area_name" id="prv_area_name" style="width:100%">	
                                   
                </div>
								
			  </div>
			  		  
            </div>
          </div>
		  
		  <!-- Row 4 -->
		  <div class="col-12 col-sm-12 col-md-12">
            <div class="info-box">
			
              <div class="col-6 col-sm-6 col-md-6 border-right">
				
				<p class="text-muted"><b>અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે? </b>
				
						<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="have_old_quarter_y" name="have_old_quarter_yn" 	value="Y">
                        <label for="have_old_quarter_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="have_old_quarter_n" name="have_old_quarter_yn" value="N">
                        <label for="have_old_quarter_n">{{  __('common.no') }}
                        </label>
                      </div>
					  <label id="have_old_quarter_yn-error" class="error" for="have_old_quarter_yn"></label>
                    </div>
				
				</p>
				<hr>
				
				<div class="row house">
                  <div class="col-3">
                    <center><p class="text-muted" style="line-height: 50px"><b>વિગત</b></p></center>
                  </div>
                  <div class="col-9">
                    <textarea class="form-control" style="width:100%" name="old_quarter_details" id="old_quarter_details"></textarea>
                  </div>                  
                </div>
				
				
			  </div>
			  
			  <div class="col-6 col-sm-6 col-md-6">
				<p class="text-muted"><b>ગાંધીનગર ખાતે રહો છો? </b>
				
				<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="is_relative_y" name="is_relative_yn" 	value="Y">
                        <label for="is_relative_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="is_relative_n" name="is_relative_yn" value="N">
                        <label for="is_relative_n">{{  __('common.no') }}
                        </label>
                      </div>
					  <label id="is_relative_yn-error" class="error" for="is_relative_yn"></label>
                    </div>
				
				</p>
				<hr>
				
				<div class="row at_gandhinager">
                  <div class="col-4">
                    <p class="text-muted"><b>જેની સાતે રહો ચો તેણી સાતે કોઈ સંબધ આને મકાન ની વિગત</b></p>
                  </div>
                  <div class="col-8">
                    <textarea class="form-control" style="width:100%" name="relative_details" id="relative_details"></textarea>
                  </div>                  
                </div>							
			  </div>
			  		  
            </div>
          </div>
		  
		  <!-- Row 5 -->
		  <div class="col-12 col-sm-12 col-md-12">
            <div class="info-box">
			
              <div class="col-6 col-sm-6 col-md-6 border-right">
				
				<p class="text-muted"><b>શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી છે? જો હોય તો તેમણે વિગત આપવી તથા કચેરીનાં વડાનું પ્રમાણપત્ર સામેલ કરવું </b>
				
						<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="is_stsc_y" name="is_stsc_yn" 	value="Y">
                        <label for="is_stsc_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="is_stsc_n" name="is_stsc_yn" value="N">
                        <label for="is_stsc_n">{{  __('common.no') }}
                        </label>
                      </div>
					  <label id="is_stsc_yn-error" class="error" for="is_stsc_yn"></label>
                    </div>
				
				</p>
				<hr>
				
				<div class="row schedule">
                  <div class="col-3">
                    <center><p class="text-muted" style="line-height: 50px"><b>વિગત</b></p></center>
                  </div>
                  <div class="col-9">
				     <textarea class="form-control" style="width:100%" name="scst_details" id="scst_details"></textarea>
                
                   
                  </div>                  
                </div>
				
				
			  </div>
			  
			  <div class="col-6 col-sm-6 col-md-6">
				<p class="text-muted"><b>ગાંધીનગર ખાતે માતા/પિતા. પતિ/પત્ની વિગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે? </b>
				
						<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="is_relative_house_y" name="is_relative_house_yn" 	value="Y">
                        <label for="is_relative_house_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="is_relative_house_n" name="is_relative_house_yn" value="N">
                        <label for="is_relative_house_n">{{  __('common.no') }}
                        </label>
                      </div>
					  <label id="is_relative_house_yn-error" class="error" for="is_relative_house_yn"></label>
                    </div>
				
				</p>
				<hr>
				
				<div class="row with_parents">
                  <div class="col-3">
                    <center><p class="text-muted" style="line-height: 50px"><b>વિગત</b></p></center>
                  </div>
                  <div class="col-9">
                    <textarea class="form-control" style="width:100%" id="relative_house_details" name="relative_house_details"></textarea>
                  </div>                  
                </div>							
			  </div>
			  		  
            </div>
          </div>
		  
		  <!-- Row 6 -->
		  <div class="col-12 col-sm-12 col-md-12">
            <div class="info-box">
			
              <div class="col-6 col-sm-6 col-md-6 border-right">
				
				<p class="text-muted"><b>ગાંધીનગર શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા ગાંધીનગર ની હદ માં આવતા ગામડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું મકાન છે?</b>
						<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="have_house_nearby_y" name="have_house_nearby_yn" 	value="Y">
                        <label for="have_house_nearby_y">{{  __('common.yes') }}
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="have_house_nearby_n" name="have_house_nearby_yn" value="N">
                        <label for="have_house_nearby_n">{{  __('common.no') }}
                        </label>
                      </div>
					  <label id="have_house_nearby_yn-error" class="error" for="have_house_nearby_yn"></label>
                    </div>
				
				</p><br>
				<hr>
				
				<div class="row limit">
                  <div class="col-3">
                    <center><p class="text-muted" style="line-height: 50px"><b>વિગત</b></p></center>
                  </div>
                  <div class="col-9">
                    <textarea class="form-control" style="width:100%;height: 100px;" id="nearby_house_details" name="nearby_house_details"></textarea>
                  </div>                  
                </div>
				
				
			  </div>
			  
			  <div class="col-6 col-sm-6 col-md-6">
				<p class="text-muted"><b>જો બદલી થઈ ને ગાંધીનગર આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચી કક્ષાનું વસવાટ ફાળવી આપવા વિનંતી છે? </b><br><br>
				 	{{ Form::select('downgrade_allotment',getYesNo(),'',['id'=>'downgrade_allotment','class'=>'form-control','style'=>'width:30%;']) }}                                       
					
				</p>
				<hr>
				
				<div class="row">
					<div class="col-10">
						<p style="height: 20px;" class="text-muted"><b>સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા હું સંમત છુ.</b></p>
					</div>
					<div class="col-2">
							<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="agree_rules" name="agree_rules" >
                        <label for="agree_rules">
                        </label>
                      </div>
                   
                    </div>
					</div>
				</div>
				
				<hr>
				
				<div class="row">
					<div class="col-10">
						<p style="height: 20px;" class="text-muted"><b>મારી બદલી થાય તો તે અંગે ની જાણ તુરત કરીશ.</b></p>
					</div>
					<div class="col-2">
						<div class="form-group clearfix">
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="agree_transfer" name="agree_transfer" >
                        <label for="agree_transfer">
                        </label>
                      </div>
                   
					</div>
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
		$(document).ready(function() {	
	$('.transfer').hide();	
	$('.place').hide();	
	$('.house').hide();
	$('.at_gandhinager').hide();
	$('.schedule').hide();
	  $('.with_parents').hide();
	   $('.limit').hide();
$('input[name=deputation_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
        $('.transfer').show();
    }
    else if (this.value == 'N') {
         $('.transfer').hide();
    }
}); 
$('input[name=old_allocation_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
        $('.place').show();
    }
    else if (this.value == 'N') {
         $('.place').hide();
    }
}); 
$('input[name=have_old_quarter_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
        $('.house').show();
    }
    else if (this.value == 'N') {
         $('.house').hide();
    }
});
$('input[name=is_relative_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
        $('.at_gandhinager').show();
    }
    else if (this.value == 'N') {
         $('.at_gandhinager').hide();
    }
}); 
$('input[name=is_stsc_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
      $('.schedule').show();
    }
    else if (this.value == 'N') {
        $('.schedule').hide();
    }
});
$('input[name=is_relative_house_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
      $('.with_parents').show();
    }
    else if (this.value == 'N') {
        $('.with_parents').hide();
    }
});
$('input[name=have_house_nearby_yn][type=radio]').change(function() { 
    if (this.value == 'Y') {
      $('.limit').show();
    }
    else if (this.value == 'N') {
        $('.limit').hide();
    }
});
 
jQuery.validator.addMethod("cdate",
				   function (value, element)
				    { 
					return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
				    },
				    "Please specify the date in DD-MM-YYYY format"
				    );
	
 $("#front_annexurea").validate({
		    rules : {
			deputation_date : {cdate : true},
			quartertype		:	"required",
			deputation_yn	:	"required",
			old_allocation_yn		:	"required",
			have_old_quarter_yn		:	"required",
			is_relative_yn		:	"required",
			is_stsc_yn		:	"required",
			is_relative_house_yn		:	"required",
			have_house_nearby_yn		:	"required",
			agree_rules		:	"required",
			agree_transfer		:	"required",
		    }
		});
});
</script>
@endpush