  <div class="content">
        <!-- Content Header (Page header) -->
         @if( ! isset($isEdit))
         <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Document Attachment</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Document Attachment</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        @endif
        <!-- /.content-header -->
        <div class="col-md-12">
            <!-- general form elements -->
             @if(count($document_list) > 0)
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">Upload Document</h3>
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
                @include(Config::get('app.theme').'.template.severside_message')
                @include(Config::get('app.theme').'.template.validation_errors')
                <!-- /.card-header -->
                <!-- form start -->
               
                <form method="POST" action="{{ url('saveuploaddocument') }}" enctype="multipart/form-data"
                    name="documentupload" id="documentupload">
                    @csrf
                  
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="maratial_status">Document Type&nbsp;<span class="text-danger">*</span></label>
                                 <select name="document_type" id="document_type" class="form-control select2">
                                    
                                    @foreach($document_list as $key => $value)
                                        <option value="{{ $key }}" {{ old('document_type', null) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                  
                                </select>


                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputFile">Upload Photo&nbsp;<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image" onchange="updateFileName(this)">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    <span id="image-error" class="error-message text-danger" style="display: none;"></span>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="submitBtn" id="submitBtn">Upload Document</button>&nbsp;
                            <span class="text-danger">Fields marked with *  are mandatory to fill. </span>
                            <input type="hidden" class="form-control" id="request_id" name="request_id"
                                value="{{ base64_encode($request_id) }}">
                            <input type="hidden" class="form-control" id="perfoma" name="perfoma"
                                value="{{ base64_encode($type) }}">
                                @php
                                    $rev = isset($isEdit) && $isEdit ? ($rev + 1) : $rev;
                                @endphp
                            <input type="hidden" class="form-control" id="request_rev" name="request_rev"
                                value="{{ base64_encode($rev) }}">
                        </div>
                    </div>
                </form>
                
            </div>
           
           
            <!-- /.card -->
            @if(isset($ddo_remarks_status))
                    @if($ddo_remarks_status['is_ddo_varified']==2)
                        
                        <div class="alert alert-warning">
                             <button type="button" class="close" data-dismiss="alert">×</button>
                              DDO Remarks : {{$ddo_remarks_status['ddo_remarks']}}
                    </div>
                    @endif
            @endif
            @if(isset($admin_remarks_status))
                    @if($admin_remarks_status['is_varified']==2)
                        
                        <div class="alert alert-warning">
                             <button type="button" class="close" data-dismiss="alert">×</button>
                              Department Remarks : <br/> {!! $admin_remarks_list !!}
                    </div>
                    @endif
            @endif
        </div>
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">Attached Documents</h3>

                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered" id="request_history">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>File</th>
                                       @if(isset($isEdit) && $isEdit==0)
                                        <th>Delete</th>
                                        @endif
                                          @if($rev==0)
                                        <th>Delete</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($attacheddocument as $a)
                                   
                                     
                                   
                                        <tr>
                                            <td>{{ $a->document_name }}</td>
                                         
                                            <td> <a href="javascript:;" target="_blank" class="btn btn open-document-btn"
                                                    data-id="{{ $a->doc_id }}">
                                                    <img src="{{ asset('/images/pdf.png') }}" width="30" height="30">
                                                </a> </td>
                                            @if(isset($isEdit) && $isEdit==0)
                                            <td>
                                                <a href="javascript:;" class="btn btn btn-danger delete_doc"
                                                    delete-id="{{ $a->rev_id }}" data-id="{{ $a->doc_id }}" data-rivision="{{ $a->rivision_id }}"  data-edit="{{  $isEdit ?? 0  }}"  ><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a>

                                            </td>
                                            @endif
                                            @if($rev==0)
                                             <td>
                                                <a href="javascript:;" class="btn btn btn-danger delete_doc"
                                                    delete-id="{{ $a->rev_id }}" data-id="{{ $a->doc_id }}" data-rivision="{{ $a->rivision_id }}"  data-edit="{{  $isEdit ?? 0  }}"  ><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a>

                                            </td>
                                            @endif

                                            
                                        </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                            <form id="final" method="post" action="{{ url('savefinalannexure') }}">
                                @csrf
                                <input type="hidden" name="requestid" value="{{ $request_id }}" />
                                <input type="hidden" name="type" value="{{ $type }} " />
                                <input type="hidden" name="rev" value="{{ $rev }}" />
                                <input type="text" name="edit_type" value="{{ $edit_type ?? '' }}" />
                                <input type="hidden" name="dgr" value="{{ isset($dgr) ? $dgr : '' }}" />
                                <input type="hidden" value="{{ count($document_list) }}" id="document_list" name="document_list">
                                <input type="hidden" value="{{ $isEdit ?? 0 }}" id="isEdit" name="isEdit">

                               
                           
                        </div>

                    </div>
 
                </div>

            </div>
            @isset($attacheddocument_old)
             <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">Old Attached Documents</h3>

                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered" id="request_history">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>File</th>
                                       @if(isset($isEdit) && $isEdit==0)
                                        <th>Delete</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($attacheddocument_old as $a)
                                   
                                     
                                   
                                        <tr>
                                            <td>{{ $a->document_name }}</td>
                                         
                                            <td> <a href="javascript:;" target="_blank" class="btn btn open-document-btn"
                                                    data-id="{{ $a->doc_id }}">
                                                    <img src="{{ asset('/images/pdf.png') }}" width="30" height="30">
                                                </a> </td>
                                            @if(isset($isEdit) && $isEdit==0)
                                            <td>
                                                <a href="javascript:;" class="btn btn btn-danger delete_doc"
                                                    delete-id="{{ $a->rev_id }}" data-id="{{ $a->doc_id }}" data-rivision="{{ $a->rivision_id }}"  data-edit="{{  $isEdit ?? 0  }}"  ><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a>

                                            </td>
                                            @endif

                                            
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                     
                        </div>

                    </div>
 
                </div>

            </div>
            @endisset
          
                                <table width="100%">
                                    <tr>
                                        <td> <button type="submit" class="btn btn-primary" id="submitFinalAnnex" name="submitFinalAnnex">Submit Document and Save Application</button></td>
                                    </tr>
                                </table>
                                
            <!-- /.card -->
 </form>
        </div>
    </div>

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

     $('body').on('click', '.delete_doc', function() {
            var pid = $(this).attr('delete-id');
            var id = $(this).attr('data-id');
            var rivision_id=$(this).attr('data-rivision');
             var isEdit=$(this).attr('data-edit');
            
            swal.fire({
                text: "Are you sure? Want to Remove This Details ",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => { //alert("ghgf");
                //$('#loader-wrapper').show();
                $.ajax({
                    url: "{{ url('deletedoc') }}",
                    data: {
                        rid: pid,
                        id: id,
                        rivision_id: rivision_id,
                        isEdit: isEdit
                    },
                    method: "POST",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred: ' + error,
                            icon: 'error',
                            timer: 3000,
                            showConfirmButton: true
                        });
                    }
                });
            });
        });
        $('.open-document-btn').on('click', function(e) {
            e.preventDefault();
            let docId = $(this).attr('data-id');
            // let url = '/get-document-url'; // URL of the Laravel route to get the document URL

            $.ajax({
                url: "{{ url('get-document-url') }}",
                type: 'POST',
                data: {
                    doc_id: docId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Open the document in a new tab
                        //window.open(response.document_url, '_blank');
                        const byteCharacters = atob(response.document_url);
                    const byteNumbers = new Uint8Array(byteCharacters.length);

                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }

                    const blob = new Blob([byteNumbers], { type: response.contentType });

                    // Create a URL for the Blob and open it in a new window
                    const blobUrl = URL.createObjectURL(blob);
                    window.open(blobUrl, '_blank');
                } else {
                    console.error('Failed to fetch PDF:', data.error);
                }


                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
        $(document).ready(function() {
        $('#documentupload').validate({
            errorClass: "error-message",
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
                $(element).closest('.form-control').addClass('error-field');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
                $(element).closest('.form-control').removeClass('error-field');
            },
            rules: {
                image: {
                    required: true,
                    extension: "pdf"
                },
                 document_type: {
                    required: true
                }
            },
            messages: {
                image: {
                    required: "Select File to Upload.",
                    extension: "Only PDF files are allowed."
                },
                document_type: {
                    required: "Select Document Type"
                   
                }
            },
            submitHandler: function(form) {
                form.submit(); // Submit the form when validation is successful
            }
        });

        // Optional: You can remove the submitBtn click handler if you want to let the form submit automatically when valid
        $('#submitBtn').click(function(e) {
           // e.preventDefault(); // Prevent the default form submission
            if ($('#documentupload').valid()) {
                $('#documentupload').submit();
            }
        });
    });

     </script>   
        <script>
function updateFileName(input) {
  if (input.files && input.files.length > 0) {
    var fileName = input.files[0].name;
    // Use Bootstrap's jQuery to update label text
    $(input).next('.custom-file-label').html(fileName);
  }
}

    </script>
@endpush
