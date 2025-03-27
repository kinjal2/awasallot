@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">{{$page_title}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button id="sample_editable_1_new" class="btn sbold green"> Add New
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> ID # </th>
                            <th> Title </th>
                            <th> Cust. Name </th>
                            <th> Cust. Email </th>
                            <th> Date/Time </th>
                            <th> Assigned To </th>
                            <th> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE BASE CONTENT -->
@endsection
@push('page-ready-script')
console.log('page is ready');
@endpush
@push('footer-script')
<script type="text/javascript">
    alert('1');
</script>
@endpush