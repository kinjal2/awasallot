@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Remarks</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Remarks</li>
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
                <h3 class="card-title">Remarks</h3>
             
            </div>
            <!-- /.card-header -->
            <!-- form start -->
          
                @include(Config::get('app.theme').'.template.severside_message')
                @include(Config::get('app.theme').'.template.validation_errors')
           
            <div class="card-body">
                <form action="{{ route('quarter.list.addnewremark') }}" method="POST" id="save_new_remark"
                    name="save_new_remark">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="new_remark">Add New Remark</label>
                            
                            <input class="form-control" type="text" name="new_remark" id="new_remark"
                                value="{{ old('new_remark') }}">
                            <input type="submit" value="Add New Remark" class="button btn btn-success mt-4">
                        </div>
                        <div id="remark-message" class="mt-2"></div>

                    </div>
                </form>
              
                <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('saveremarks') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="r" id="r" value="{{ base64_encode($requestid) }}" />
                    <input type="hidden" name="rv" id="rv" value="{{ base64_encode($rv) }}" />
                    <input type="hidden" name="type" id="type" value="{{ base64_encode($type) }}" />
                    <input type="hidden" name="remarks_selected" id="remarks_selected" value="{{ base64_encode($remarks) }}" />
                    <input type="hidden" name="remarks" id="remarks" value="{{ ($remarks && $remarks != '{"remarks":null}') ? base64_encode($remarks) : '' }}" />
                    <div style="text-align:right;" class="col-md-12">

                        <input type="submit" class="button btn btn-success mb-3" value="Save Remarks"
                            onclick="return validate();" />
                    </div>

                    <div style="overflow-x:auto;">

                        <table class="table table-bordered table-hover custom_table dataTable" id="remarkslist">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Sr No</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <!-- /.card-body -->
                    </div>

                </form>

            </div>

        </div>
    </div>
    @endsection
    @push('page-ready-script')

    @endpush
    @push('footer-script')
    <script type="text/javascript">
    $('#remarkslist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {

            url: "{{ route('quarter.list.listremarks') }}",
            type: 'POST', // Ensure the POST method is used
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(d) {
            d.r = $('#r').val();
            d.rv = $('#rv').val();
            d.type = $('#type').val();
            d.remarks_selected = $('#remarks_selected').val(); // This should now work with .val()
        }
        },
        columns: [{
                data: 'checkbox',
                orderable: false,
                searchable: false
            }, //  Checkbox column
            {
                data: 'index',
                name: 'index',
                orderable: false,
                searchable: false
            },
            {
                data: 'description',
                name: 'description'
            },

        ]
    });
    $(document).ready(function() {


        // $('#remarkslist').DataTable();

        $('#save_new_remark').on('submit', function(e) {
            e.preventDefault(); // prevent default form submission

            var formData = {
               new_remark: btoa(unescape(encodeURIComponent($('#new_remark').val()))),
                _token: '{{ csrf_token() }}' // CSRF token for Laravel
            };

            $.ajax({
                type: 'POST',
                url: "{{ route('quarter.list.addnewremark') }}",
                data: formData,
                success: function(response) {
                   // console.log('Remark added successfully:', response);
                    if (response.status === 'success') {
                        // alert(response.message); // or use a toast/snackbar for better UI
                        $('#remark-message').html(`
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          ${response.message}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  `);
                        setTimeout(() => {
                            $('#remark-message .alert').alert('close');
                        }, 3000);

                        $('#remarkslist').DataTable().ajax.reload(null, true);
                        //location.reload(); // Reload the entire page
                        // You can reset the form or update the UI
                        //  Reload DataTable
                        //   if ($.fn.dataTable.isDataTable('#remarkslist')) {
                        //     $('#remarkslist').DataTable().clear().destroy();
                        //   }
                        // $('#remarkslist').DataTable(); // false = don't reset pagination
                        $('#save_new_remark')[0].reset();
                    }
                    $('#save_new_remark')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error('Error submitting remark:', error);

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        
                        $.each(errors, function(key, messages) {
                            errorHtml += `<div>${messages[0]}</div>`; // show the first error for each field
                        });

                        errorHtml += `
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;

                        $('#remark-message').html(errorHtml);

                        setTimeout(() => {
                            $('#remark-message .alert').alert('close');
                        }, 4000);
                    } else {
                        $('#remark-message').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                An unexpected error occurred. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                }
            });
        });
    });

    function SelectRemarks(obj) {
      //alert(obj.id);
        var remarks = "";
        $("input[name='remarksArr[]']:checked").each(function() {
          remarks += $(this).attr('id') + "," ;
      });
      remarks = remarks.replace(/,$/, ''); // Removes the last comma
    //alert(remarks);
        $('#remarks').val(remarks);
    }
    </script>
   <script>
function validate() {
    const selectedRemarks = $("input[name='remarksArr[]']:checked").length;

    if (selectedRemarks === 0) {
        $('#remark-message').html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Please select at least one remark before submitting.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);

        setTimeout(() => {
            $('#remark-message .alert').alert('close');
        }, 3000);

        return false; // Prevent form submission
    }

    return true; // Allow submission
}
</script>
    @endpush