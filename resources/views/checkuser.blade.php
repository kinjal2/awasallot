@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-8 mx-auto">
            <div class="card box-design">
                <!-- <div class="card-header login-head">Login</div> -->
                <div class=" login-head text-center  ">
                
                  <p class="login-icon py-2">{{ __('Select Designation') }}</p>
                  <h4 class="m-0"><b>E-state Managment System</b></h4>
                  <p class="sub-title-form">Goverment of Gujarat</p>
                </div>

                <div class="card-body bg-lightwhite p-4">
				<form method='POST' action='designationselection'>
				<input type='hidden' name='_token' value="{{ csrf_token() }}" />
                    <div class="form-group row">
					<label class="col-sm-2 col-form-label">Office</label>
					<div class="col-sm-10">
					<select name="officedesignation" id="officedesignation" class="form-control"  required>
					<option value="">Select Office:Designation</option>
					@foreach ($office_designations as $item) 
						@php
							$detsession = strtoupper($item->empname) . ":" . 
							$item->officecode . ":" . 
							$item->designationcode . ":" . 
							$item->districtcode . ":" . 
							strtoupper($item->officename) . ":" . 
							strtoupper($item->designation) . ":" . 
							strtoupper($item->districteng) . ":" . 
							$item->deptid;
						@endphp
							<option value="{{ $detsession }}">
							{{ $item->officename }}:{{ $item->designation }}
							</option>
					@endforeach

					</select>
					</div>
					@error('officedesignation')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
					</div>
			
			
					<div class="row m-t-30">
					<div class="col-md-12"></div>
					<div class="col-md-12">
					<button type="submit" class="btn btn-primary">
						{{ __('Submit') }}
					</button>
					</div>
					</div>
				</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection