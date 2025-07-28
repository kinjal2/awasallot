@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')
    <div class="content">
        @include('user.documentupload_tabview')
    </div>
    <!-- /.content -->
@endsection
@push('page-ready-script')
@endpush
@push('footer-script')
    
@endpush
