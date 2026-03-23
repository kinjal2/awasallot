@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" id="successAlert">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
@endif

@if(session()->has('failed'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        {{ session()->get('failed') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
    </div>
@endif