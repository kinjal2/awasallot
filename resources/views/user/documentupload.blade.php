@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')
    <div class="content">
        @include('user.documentupload_tabbiew.blade.php')
    </div>
    <!-- /.content -->
@endsection
@push('page-ready-script')
@endpush
@push('footer-script')
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
                        id: id
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

        
        function updateFileName() {
            var fileInput = document.getElementById('image');
            var fileName = fileInput.files[0].name;
            var fileLabel = fileInput.nextElementSibling;
            fileLabel.innerText = fileName;
        }
    </script>
@endpush
