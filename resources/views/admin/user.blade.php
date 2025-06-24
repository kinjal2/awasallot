@extends(\Config::get('app.theme') . '.master')

@section('title', $page_title)

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User List</h1>
      </div>
      @include(Config::get('app.theme') . '.template.severside_message')
      @include(Config::get('app.theme') . '.template.validation_errors')
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">User List</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="table-responsive p-4">
            <table class="table table-bordered table-hover custom_table dataTable" id="userlist">
              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Name</th>
                  <th>Birth Date</th>
                  <th>Designation</th>
                  <th>Office</th>
                  <th>Cardex/Ddo</th>
                  <th>Email</th>
                   <th>Change Ddo Details</th>
                </tr>
              </thead>
              <tbody>
                {{-- Data to be dynamically inserted via backend or JS --}}
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Birth Date</th>
                  <th>Designation</th>
                  <th>Office</th>
                  <th>Cardex/Ddo</th>
                  <th>Email</th>
                  <th>Change Ddo Details</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal" id="reset_modal" data-url="{{ url('/reset') }}">
    <div class="modal-dialog">
        <div class="modal-content pop_up_design">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reset</h4>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <!-- Modal body -->
            <form method="POST" id="resetForm">
                @csrf
                <input type="hidden" name="field_type" id="field_type" value="" />
                <input type="hidden" name="uid" id="uid" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="field_value">New Value <span class="error">*</span></label>
                                <input type="text" name="field_value" id="field_value" class="form-control required" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" value="Submit" class="btn btn-success" />
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close Modal</button>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="oldProfileUpdateModal" tabindex="-1" aria-labelledby="oldProfileUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('admin.updateUserDetails') }}" id="oldProfileUpdateForm" name="oldProfileUpdateForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="oldProfileUpdateModalLabel">Change User Details of District and DDO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                        <select name="district" id="district" class="form-control select2">
                            <option value="">{{ __('common.select') }}</option>
                            @foreach (getDistricts() as $key => $district)
                                <option value="{{ $key }}">{{ $district }}</option>
                            @endforeach
                        </select>
                        @error('district')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="taluka" class="form-label">Taluka <span class="text-danger">*</span></label>
                        <select name="taluka" id="taluka" class="form-control select2">
                            <option value="">{{ __('common.select') }}</option>
                            @foreach (getTaluka() as $key => $taluka)
                                <option value="{{ $key }}">{{ $taluka }}</option>
                            @endforeach
                        </select>
                        @error('taluka')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cardex_no" class="form-label">Cardex No</label>
                        <x-select 
                            name="cardex_no"
                            :options="['' => __('common.select')]"
                            :selected="old('cardex_no', '')"
                            class="form-control select2"
                            id="cardex_no"
                        />
                    </div>

                    <div class="mb-3">
                        <label for="ddo_code" class="form-label">DDO Code</label>
                        <select name="ddo_code" id="ddo_code" class="form-control select2">
                            <option value="">{{ __('common.select') }}</option>
                        </select>
                        @error('ddo_code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <span class="text-danger">Fields marked with * are mandatory.</span>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <input type="hidden" name="user_id" id="user_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('footer-script')
<script type="text/javascript">
var table = $('#userlist').DataTable({
    lengthMenu: [
        [10, 20, 50, -1],
        [10, 20, 50, "All"]
    ],
    processing: true,
    serverSide: true,
    ajax: {
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        url: "{{ route('user.list') }}",
        type: "POST",
    },
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'name_link', name: 'name'},
        {data: 'date_of_birth_link', name: 'date_of_birth'},
        {data: 'designation_link', name: 'designation'},
        {data: 'office_link', name: 'office'},
        {data: 'ddocardex', name: 'ddocardex'},
         {data: 'email', name: 'email'},
        {data: 'changedetails', name: 'changedetails'},
    ]
});

// -- Filter footer input
$('#userlist tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
});
table.columns().every(function () {
    var that = this;
    $('input', this.footer()).on('keyup change', function () {
        if (that.search() !== this.value) {
            that.search(this.value).draw();
        }
    });
});


// -- Handle modal open and set values
$('body').on('click', '.changedetails-btn', function () {
    const id = atob($(this).data('id'));
    const id1 = $(this).data('id');
    const dcode = atob($(this).data('dcode'));
    const tcode = atob($(this).data('tcode'));
    const ddo_code = atob($(this).data('ddo_code'));
    const cardex_no = atob($(this).data('cardex_no'));

    $('#user_id').val(id1);
    $('#district').val(dcode).trigger('change');

    // Wait for cardex_no to load before setting value
    $(document).one('cardex:loaded', function () {
        $('#cardex_no').val(cardex_no).trigger('change');

        // Wait for DDO to load before setting value
        $(document).one('ddo:loaded', function () {
            $('#ddo_code').val(ddo_code).trigger('change');
        });
    });

    // Slight delay for taluka if needed
    setTimeout(() => {
        $('#taluka').val(tcode).trigger('change');
    }, 500);

    const modal = new bootstrap.Modal(document.getElementById('oldProfileUpdateModal'));
    modal.show();
});

// -- District change => load taluka + cardex
$('#district').on('change', function () {
    const dcode = $(this).val();
    const csrfToken = $('#oldProfileUpdateForm input[name="_token"]').val();

    if (!dcode) return;

    // 1. Load taluka
    $.ajax({
        url: "{{ route('getTalukasByDistrict') }}",
        type: 'POST',
        data: { dcode: dcode },
        success: function (data) {
            const talukaSelect = $('#taluka');
            talukaSelect.empty().append('<option value="">{{ __("common.select") }}</option>');
            data.forEach(item => {
                talukaSelect.append(`<option value="${item.tcode}">${item.name_e} [${item.name_g}]</option>`);
            });
        },
        error: function (xhr) {
         //   alert('Failed to fetch talukas.');
        }
    });

    // 2. Load cardex
    $.ajax({
        url: "{{ route('ddo.getCardexNo') }}",
        type: 'POST',
        data: { dcode: dcode, _token: csrfToken },
        success: function (data) {
            const cardexSelect = $('#cardex_no');
            cardexSelect.empty().append(`<option value="">-- Select Cardex --</option>`);
            if (Array.isArray(data)) {
                data.forEach(item => {
                    cardexSelect.append(`<option value="${item}">${item}</option>`);
                });
            }
           
            $(document).trigger('cardex:loaded');
        },
        error: function () {
            alert('Failed to load cardex numbers.');
        }
    });
});

// -- Cardex change => load DDO
$('#cardex_no').on('change', function () {
    const cardexNo = $(this).val();
    const dcode = $('#district').val();
    const csrfToken = $('#oldProfileUpdateForm input[name="_token"]').val();

    if (!cardexNo) return;

    $.ajax({
        url: "{{ route('ddo.getDDOCode') }}",
        type: 'POST',
        data: { dcode: dcode, cardex_no: cardexNo, _token: csrfToken },
        success: function (data) {
            const ddoSelect = $('#ddo_code');
            ddoSelect.empty().append(`<option value="">-- Select DDO --</option>`);
            if (Array.isArray(data)) {
                data.forEach(item => {
                    ddoSelect.append(
                        `<option value="${item.ddo_code}">${item.ddo_office} [ Code - ${item.ddo_code} ]</option>`
                    );
                });
            }
            
            $(document).trigger('ddo:loaded');
        },
        error: function () {
            alert('Failed to load DDO codes.');
        }
    });
});
$('#userlist tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			  });
    
        table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });  
	var baseUrl = "{{ url('/reset') }}";

$(document).on('click', '.reset_password, .change_name, .change_designation, .change_office, .change_birthdate', function() {
    var fieldType = '';
    var modalTitle = '';

    if ($(this).hasClass('reset_password')) {
        fieldType = 'password';
        modalTitle = 'Reset Password';
    } else if ($(this).hasClass('change_name')) {
        fieldType = 'name';
        modalTitle = 'Change Name';
    } else if ($(this).hasClass('change_designation')) {
        fieldType = 'designation';
        modalTitle = 'Change Designation';
    } else if ($(this).hasClass('change_office')) {
        fieldType = 'office';
        modalTitle = 'Change Office';
    } else if ($(this).hasClass('change_birthdate')) {
        fieldType = 'date_of_birth';
        modalTitle = 'Change Date Of Birth';
    }

    var actionUrl = baseUrl + "/" + fieldType;

    setModalContent(modalTitle, actionUrl, $(this).data('uid'), fieldType);
});

  
  function setModalContent(title, actionUrl, uid, fieldType) { 
        $('#reset_modal').modal('show');
        $('#field_value').val('');
        $('#reset_modal').find('.modal-title').text(title);
        $('#reset_modal').find('form').attr('action', actionUrl);
        $('#reset_modal').find('#field_type').val(fieldType);
        $('#reset_modal').find('#uid').val(uid);
          // Check if the fieldType is 'date_of_birth' and apply input mask accordingly
    if (fieldType === 'date_of_birth') {
        $('#field_value').inputmask('datetime', {
            inputFormat: "yyyy-mm-dd",
            placeholder: "YYYY-MM-DD",
            showMaskOnHover: false,
            min: "1900-01-01",
            max: "2200-12-31"
        });
    }  else {
        // Destroy input mask if not 'date_of_birth'
        $('#field_value').inputmask('remove');
    }
    
    } 
</script>
@endpush