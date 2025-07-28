@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Request History</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Request History</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">Quarter History</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
               <div id="flash-message" class="alert alert-success d-none" role="alert"></div>
                
                @if(session('message'))
                <?php
                $message = base64_decode(session('message')); // Decode the message
                ?>
                <div class="alert alert-info">
                    {{ $message }}
                </div>
                <!-- <script>
                    setTimeout(function() {
                        let flash = document.getElementById('flash-message');
                        if (flash) {
                            flash.style.display = 'none';
                        }
                    }, 3000); // 3 seconds
                </script> -->
                @endif

                <table class="table table-bordered table-hover custom_table dataTable" id="request_history">
                    <thead>
                        <tr>
                            <th>Request Type</th>
                            <th>Quarter Type</th>
                            <th>Revised Waiting List No</th>
                            <th>Waiting List No</th>
                            <th>Request Date</th>
                            <th>Application Accepted</th>
                            <th>Inward No</th>
                            <th>Inward Date</th>
                            <th>Preview Application/Attach Documents</th>
                            <th>Status</th>
                            <th>DDO Remarks</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic data will be loaded here by DataTables -->
                    </tbody>
                </table>

                <div class="modal" id="DocumentModal">
                    <div class="modal-dialog">
                        <div class="modal-content  pop_up_design">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Remarks</h4>
                                <button type="button" class="btn btn-danger close" data-dismiss="modal">&times;</button>

                                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div id='viewdata'></div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="withdrawForm" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="withdrawModalLabel">Withdraw Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="withdraw_remarks" class="form-label">Withdraw Application Remarks</label>
                                        <textarea id="withdraw_remarks" name="withdraw_remarks" class="form-control required" rows="4" required></textarea>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input required" id="agree_rules" name="agree_rules" required>
                                        <label class="form-check-label" for="agree_rules">
                                            <strong>આથી હુ સરકારી આવાસ અંગેની અરજી પરત લઉ છુ, અને ઉકત અરજી અન્વયે ભવિષ્યમાં કોઇ હકદાવો કરીશ નહિ. જેની હુ સંમતિ આપુ છુ</strong>
                                        </label>
                                    </div>

                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="requestid" id="modal_requestid">
                                    <input type="hidden" name="performa" id="modal_performa">
                                    <input type="hidden" name="wait_no" id="modal_wait_no">
                                    <input type="hidden" name="quartertype" id="modal_quartertype">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col-md-12 -->
</div>

@endsection

@push('page-ready-script')

@endpush

@push('footer-script')
<script type="text/javascript">
    var table = $('#request_history').DataTable({
        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ url('request-history') }}",
            'type': 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        },
        columns: [{
                data: 'requesttype',
                name: 'requesttype'
            },
            {
                data: 'quartertype',
                name: 'quartertype'
            },
            {
                data: 'r_wno',
                name: 'r_wno'
            },
            {
                data: 'wno',
                name: 'wno'
            },
            {
                data: 'request_date',
                name: 'request_date'
            },
            {
                data: 'is_accepted',
                name: 'is_accepted'
            },
            {
                data: 'inward_no',
                name: 'inward_no'
            },
            {
                data: 'inward_date',
                name: 'inward_date'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
            {
                data: 'issues',
                name: 'remarks'
            },
            //  {data: 'ddo_remarks', name: 'remarks'},
            {
                data: 'ddo_remarks',
                defaultContent: '',
                name: 'ddo_remarks',
                render: function(data, type, row) {
                    // Only show the column if 'is_accepted' is 1
                    if (row.is_accepted == 'YES') {
                        if (row.is_ddo_varified == 2 || row.is_ddo_varified == 3) {
                            if (data == null || data == '') {
                                return 'Having Issue';
                            } else {
                                return data; // Show the ddo_remarks content if is_ddo_varified == 2
                            }
                        } else if (row.is_ddo_varified == 1) {
                            return 'Verified by DDO'; // Show "Verified by DDO" if is_ddo_varified == 1
                        } else if (row.is_ddo_varified == 0) {
                            return 'Not Verified by DDO'; // Show "Not Verified by DDO" if is_ddo_varified == 0
                        }
                    } else {
                        return ''; // If is_accepted is not 1, return empty string (hide the column)
                    }
                }
            },
            {
                data: 'user_remarks',
                name: 'user_remarks'
            },
        ]
    });

    $('body').on('click', '.btn', function() {
        $('#DocumentModal').hide();
    });


    $('body').on('click', '.getdocument', function() {
        var uid = $(this).attr('data-uid');
        var type = $(this).attr('data-type');
        var rivision_id = $(this).attr('data-rivision_id');
        var requestid = $(this).attr('data-requestid');
        var remarks = $(this).attr('data-remarks');
        $.ajax({
            url: "{{ route('quarter.list.getremarks') }}",
            method: 'POST',
            data: {
                uid: uid,
                type: type,
                rivision_id: rivision_id,
                requestid: requestid,
                remarks: remarks
            },
            success: function(result) {
                var html = '<ul>';

                if (result.success === false || !result.data || result.data.length === 0) {
                    html += '<li>' + result.message + '</li>';
                } else {
                    result.data.forEach(function(item) {
                        html += '<li>' + item.description + '</li>';
                    });
                }

                html += '</ul>';
                $("#viewdata").html(html);
                $('#DocumentModal').show();
            }
        });
    });
    $('body').on('click', '.office_popup', function(event) {
        event.preventDefault();

        // Extract data from button attributes
        var t = $(this).data('requestid');
        var p = $(this).data('requesttype');
        var w = $(this).data('wno');
        var q = $(this).data('quartertype');

        // Fill hidden fields in the modal form
        $('#modal_requestid').val(t);
        $('#modal_performa').val(p);
        $('#modal_wait_no').val(w);
        $('#modal_quartertype').val(q);

        // Show modal using Bootstrap 5
        let modal = new bootstrap.Modal(document.getElementById('withdrawModal'));
        modal.show();

        return false;
    });

    $('#withdrawForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: '{{ route("application.withdraw.details") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                //alert('Withdraw submitted successfully.');
                // Show the message in the alert box
                $('#flash-message').removeClass('d-none').hide().text(response.message).fadeIn('slow');
                let modal = bootstrap.Modal.getInstance(document.getElementById('withdrawModal'));
                modal.hide();
                // setTimeout(() => {
                //     window.location.href = response.redirect;
                // }, 1000);
                // Auto-hide the flash message after 4 seconds
                setTimeout(() => {
                    $('#flash-message').addClass('d-none').text('');
                }, 4000);

                // Reload the page after 5 seconds
                setTimeout(() => {
                    location.reload();
                }, 5000);

            },
            error: function(xhr) {
                alert('Submission failed!');
                console.error(xhr.responseText);
            }
        });
    });
</script>


</script>
@endpush