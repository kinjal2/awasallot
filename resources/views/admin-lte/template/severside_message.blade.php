@if(session()->has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					{{ session()->get('success') }}
				</div>
@endif
@if(session()->has('failed'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">×</button>
					{{ session()->get('failed') }}
				</div>
@endif