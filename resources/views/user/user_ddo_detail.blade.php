@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<div class="content">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">{{ __('ddodetails.ddodetails') }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                  <li class="breadcrumb-item active">{{ __('ddodetails.ddodetails') }}</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-head">
         <div class="card-header">
            <h3 class="card-title">{{ __('ddodetails.ddodetails') }}</h3>
         </div>
         @include(Config::get('app.theme').'.template.severside_message')
         @include(Config::get('app.theme').'.template.validation_errors')
         <!-- /.card-header -->
         <!-- form start -->
         
         <form method="POST" id="cardexForm" name="cardexForm" action="{{ url('saveOfficeCode') }}"> 
            @csrf
            <input type="hidden" id="page" name="page" value="{{ (   !empty($page)) ? $page : '' }}" />
            <div class="card-body">
            <div class="row">
               
                 <div class="col-md-4">
                  <div class="form-group">
                     <label for="cardex_no">{{ __('Cardex No') }}</label>
                     <input type="hidden" value="{{ Session::get('dcode') }}" name="dcode" id="dcode">
                      @if(empty($cardex_no))
                        <x-select 
                           name="cardex_no"
                           :options="['null' => __('common.select')]"
                           :selected="old('cardex_no', '')"
                           class="custon-control form-control select2"
                           id="cardex_no"
                        />

                        @error('cardex_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                         @else
                        <input type="text" class="form-control" value="{{ $cardex_no }}" readonly>
                     @endif
                    
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="ddo_code">{{ __('DDO Code') }}</label>
                     @if(empty($ddo_code))
                        <x-select 
                           name="ddo_code"
                           :options="['null' => __('common.select')]"
                           :selected="old('ddo_code', '')"
                           class="custon-control form-control select2"
                           id="ddo_code"
                        />

                        @error('ddo_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     @else
                        <input type="text" class="form-control" value="{{ getDDO_OfficeByCode($cardex_no,$ddo_code) }}" readonly>
                     @endif
                  </div>
               </div>
               @if(empty($cardex_no) && empty($ddo_code))
               <div class="mt-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
               @endif
         </form>
       
      </div>
   </div>
   </div>
</div>
</div>
</div>
<!-- /.card -->
</div>
</div>
<!-- /.content -->
@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<script type="text/javascript">
   $(function() {
      // Bootstrap DateTimePicker v4
      $('.dateformat').datetimepicker({
         format: 'DD-MM-YYYY'
      });
   });
   $('.numeric').keypress(function(event) {
      return numF(event);
   });
   $('.alfanumaric').keypress(function(event) {
      return anFS(event);
   });
   $("#frm").submit(function(event) {
      //var str=$("#pancard").val();

      //	$('#pancard').val(window.btoa(str));
   });
   





   $.validator.addMethod("pan", function(value, element) {
      return this.optional(element) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test(value);
   }, "Invalid PAN No.");
   $.validator.addMethod("validExt", function(value, element) {
      if (this.optional(element))
         return true;
      else {
         var arr = value.split(".");
         var ret = true;
         if (arr.length > 2) {
            ret = false;
         }
         if (/^[a-z0-9.\s]+$/i.test(value) == false) {
            ret = false;
         }
         return ret;
      }
   }, "File name should not contain special characters or more than one dots.");
   $("#frm").validate({
      rules: {
         "is_police_staff": "required"

      }
   });

   $('#cardex_no').on('change', function() {
    var cardexNo = $(this).val();
    var dcode = $('#dcode').val(); // Get the fixed value
    var csrfToken = $('#cardexForm input[name="_token"]').val();
     // alert(cardexNo);
    if (cardexNo) {
        $.ajax({
            url: "{{ route('ddo.getDDOCode') }}", // Your route to fetch data
            type: 'POST', // Change to POST
            data: {
                cardex_no: cardexNo,
                dcode:dcode,
                _token: csrfToken // Include CSRF token here
            },
            success: function(data) { //alert(data);
                console.log(data);  // Check the actual response data from the server
                const ddo_code = $('#ddo_code');
                ddo_code.empty();

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function(item) {
                        ddo_code.append(`<option value="${item.ddo_code}">${item.ddo_office} [ Code - ${item.ddo_code} ]</option>`);
                    });
                } else {
                    alert('Invalid Cardex No.');
                }
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
                if (xhr.status === 401) {
                    // Handle unauthenticated
                    alert('You are not authenticated. Please log in.');
                    window.location.href = '/login'; // Adjust to your login route
                }
            }
        });
    } else {
        // $('#ddo_code').hide(); // Hide dropdown if input is empty
    }
});
</script>
<script>
$(document).ready(function () {
    // When the dropdown/input with ID #yourInputID changes
   
         var dcode = $('#dcode').val(); // Get the fixed value
        var csrfToken = $('#cardexForm input[name="_token"]').val();

     //   alert(dcode); // For debugging

        $.ajax({
            url: "{{ route('ddo.getCardexNo') }}",
            type: 'POST',
            data: {
                dcode: dcode,
                _token: csrfToken
            },
            success: function(data) {
                console.log(data);
                const cardex_no = $('#cardex_no');
                cardex_no.empty();

                if (Array.isArray(data) && data.length > 0) {
            cardex_no.append(`<option value="">-- Select Cardex --</option>`);
            data.forEach(function(item) {
                cardex_no.append(
                    `<option value="${item}">${item}</option>`
                );
            });
        } else {
            alert('Invalid Data.');
        }
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
                if (xhr.status === 401) {
                    alert('You are not authenticated. Please log in.');
                    window.location.href = '/login';
                }
            }
        });
   
});
</script>


@endpush