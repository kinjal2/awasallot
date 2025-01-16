@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

    <!-- Main content -->
    <div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

      <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-spinner fa-spin"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Waiting List
                </span>
                <span class="info-box-number">

                </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up  faa-pulse animated"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Quarter Allotment
            </span>

                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users faa-pulse animated"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Vacant Quarter List</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Quarters List</h3>
                <div class="card-tools">
                    <button   on type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
              <div class="card-body p-0">
                <form action="" method="post" id="listform" name="listform">
                    <div class="row col-md-12">
                        @csrf
                        <div class="col-md-3">
                            <label>Select District</label>
                            {{ Form::select('districts', ['' => 'Select District'] + getDistrictsWithOfficeCodes(), '', ['id' => 'districts', 'class' => 'form-control']) }}
                        </div>
                        <div class="col-md-3">
                            <label>Select Quarter Type</label>
                            <select id="quarter_type" class="form-control">
                                <option value="">Select Quarter Type</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Select Area</label>
                            <select id="area" class="form-control">
                                <option value="">Select Area</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label style="padding:7%"></label>
                            <button type="submit" class="btn btn-success" id="search">Search</button>
                        </div>
                    </div>
                </form>
                <br/>
                <div class="row  col-12">
                    <div class="col-12 col-sm-4 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-solid fa-bars"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Quarters</span>
                                <span class="info-box-number" class="info-box-number" id="total_quarters"></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-solid fa-clipboard"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Occupied Quarter</span>
                                <span class="info-box-number" class="info-box-number" id="occupied_quarters"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-regular fa-clipboard"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Vacant Quarter</span>
                                <span class="info-box-number" class="info-box-number" id="vacant_quarters"></span>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
        </div>
      </div>
    </div>

  </div>
@endsection
@push('page-ready-script')
console.log('page is ready');
@endpush
@push('footer-script')
<script>
    $(document).on('change', '#districts', function() {
            var district = $(this).val();  // Get the selected district (office code)
            // Get CSRF token from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');  // This assumes you have the CSRF token in the meta tag
            // Make an AJAX call to get the quarter type based on the selected district
            $.ajax({
                url: "{{ route('getQuarterType') }}",  // Replace with your route
                method: "POST",
                data: {
                    officecode: district,  // Pass the district as a parameter
                    _token: csrfToken    // Include CSRF token in the data
                },

                beforeSend: function() {
                    // Optionally show a loader or disable the select while fetching data
                    $('#quarter_type').html('<option>Loading...</option>');  // Replace with your ,quarter type dropdown
                },
                success: function(response) {
                    // Assuming the response contains the quarter types in the format { 1: 'A', 2: 'B', ... }
                    var options = '';
                    $.each(response, function(key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                    $('#quarter_type').html(options);  // Populate quarter-type dropdown with options
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Error fetching quarter types.');
                }
            });
    });

    $(document).on('change', '#quarter_type', function() {
        //var quarter_type = $(this).val();  // Get the selected district (office code)
        var quarter_type= $(this).find('option:selected').text();  // This returns the text of the selected option

        // Get CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');  // This assumes you have the CSRF token in the meta tag
        // Make an AJAX call to get the quarter type based on the selected district
        $.ajax({
            url: "{{ route('getArea') }}",  // Replace with your route
            method: "POST",
            data: {
                quarter_type: quarter_type,  // Pass the district as a parameter
                _token: csrfToken    // Include CSRF token in the data
            },

            beforeSend: function() {
                // Optionally show a loader or disable the select while fetching data
                $('#area').html('<option>Select Option</option>');  // Replace with your ,quarter type dropdown
            },
            success: function(response) {
                // Assuming the response contains the quarter types in the format { 1: 'A', 2: 'B', ... }
                var options = '';
                $.each(response, function(key, value) {
                    options += '<option value="' + key + '">' + value + '</option>';
                });
                $('#area').html(options);  // Populate quarter-type dropdown with options
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Error fetching area.');
            }
        });
    });

    $(document).on('submit', '#listform', function(e) {
        e.preventDefault();  // Prevent form from submitting normally
        var area = $('#area').find('option:selected').text();  // Fixed: match the correct id
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('getQuarterList') }}",
            method: "POST",
            data: {
                area: area,
                _token: csrfToken
            },

            success: function(response) {
                // Populate the total and vacant quarters divs with the response data
                $('#total_quarters').html(response.total_quarters);
                $('#vacant_quarters').html(response.vacant_quarters);
                $('#occupied_quarters').html(response.total_quarters - response.vacant_quarters);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Error fetching Quarter Details.');
            }
        });
    });
</script>
@endpush
