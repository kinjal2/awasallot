@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<style>
  .bg-light-pink {
    background-color: #FFC0CB; /* Light pink */
}


table.dataTable th,
table.dataTable td,
table.dataTable tfoot th {
    white-space: nowrap;
    text-align: left;
    vertical-align: middle;
    padding: 8px;
}


td.details-control {
    background: url('{{ asset('images/details_open.png') }}') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('{{ asset('images/details_close.png') }}') no-repeat center center;
}
table.dataTable tfoot input {
    width: 100%;
    box-sizing: border-box;
    font-size: 12px;
    padding: 4px;
}
 

</style>

<div class="content">
 <div class="content-header">
  <div class="container-fluid">
   <div class="row mb-2">
    <div class="col-sm-6"><h1 class="m-0 text-dark">Waiting List</h1></div>
    <div class="col-sm-6">
     <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Waiting List</li>
     </ol>
    </div>
   </div>
  </div>
 </div>

 <div class="col-md-12">
  <div class="card card-head">
   <div class="card-header">
    <h3 class="card-title">Waiting List</h3>
   </div>
   <div class="card-body">

    <div class="row">
     <div class="col-4">
      <div class="form-group">
       <label for="quartertype">Quarter Type</label>
       <x-select 
         name="quartertype" 
         :options="$quartertype" 
         :selected="[]" 
         id="quartertype" 
         class="form-control select2" 
         multiple="true" 
       />
      </div>
     </div>
     <div class="col-4" style="padding-top: 30px;">
      <div class="form-group">
       <input type="button" id="btnReset" class="btn btn-primary" value="Reset" />
      </div>
     </div>
    </div>
<div class="row mb-3">
  <div class="col-12 text-right">
    <form id="exportForm" method="GET" action="{{ route('waitinglist.export') }}">
      <input type="hidden" name="quartertype" id="export_quartertype" />
      <button type="submit" class="btn btn-success">Export to Excel</button>
    </form>
  </div>
</div>
    <div class="table-responsive p-4">
     <table id="waitinglist" class="table table-bordered table-hover  dataTable" style="width:100%">
      <thead>
       <tr>
        <th></th> <!-- details-control column -->
        <th>R-WNo</th>
        <th>WNO</th>
        <th>QType</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Office</th>
        <th>Inward Date</th>
        <th>Retirement Date</th>
        <th> Remarks</th>
        
        
       </tr>
      </thead>
      <tfoot>
       <tr>
        <th></th>
        <th>R-WNo</th>
        <th>WNO</th>
        <th>QType</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Office</th>
        <th>Inward Date</th>
        <th>Retirement Date</th>
        <th> Remarks</th>
       </tr>
      </tfoot>
      <tbody></tbody>
     </table>
    </div>

   </div>
  </div>
 </div>
</div>
<!-- Delete Product Modal -->
<!-- View Document Modal -->
<div class="modal fade" id="DocumentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content pop_up_design">
            <div class="modal-header">
                <h5 class="modal-title">View Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div id='viewdata'></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close Modal</button>
            </div>
        </div>
    </div>
</div>

<!--add Remarks -->
<div class="modal" id="remarks_modal" >
    <div class="modal-dialog">
        <div class="modal-content  pop_up_design">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Remarks </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="POST" action="{{ url('/upadteremarks') }}" >
    @csrf
    <input type="hidden" name="uid" value="" />
		<input type="hidden" name="wno" value="" />
		<input type="hidden" name="quartertype" value="" />
    <div class="modal-body">
    <div class="row">
<div class="col-sm-12">

<div class="form-group">
<label>Textarea</label>
<textarea class="form-control" rows="3"  id="office_remarks" name="office_remarks" placeholder="Enter Remarks..."></textarea>
</div>
</div>

</div>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <input type="submit" value="Submit" class="btn btn-success" />
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close Modal</button>
    </div>
</form>

        </div>
    </div>
</div>
@endsection

@push('footer-script')
<script>
function format(rowData) {
    // This function returns the nested table HTML for the given rowData object
    return `
    <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
        <tr>
            <td>Request Type:</td>
            <td>${rowData.tableof || ''}</td>
        </tr>
        
        <tr>
            <td>Inward No:</td>
            <td>${rowData.inward_no || ''}</td>
        </tr>
        <tr>
            <td>Contact No:</td>
            <td>${rowData.contact_no || ''}</td>
        </tr>
        <tr>
            <td>Email Id:</td>
            <td>${rowData.email || ''}</td>
        </tr>
        <tr>
            <td>GPF/CPF Number:</td>
            <td>${rowData.gpfnumber || ''}</td>
        </tr>
        <tr>
            <td>Retirement Date:</td>
            <td>${rowData.date_of_retirement || ''}</td>
        </tr>
        <tr>
            <td>Native Address:</td>
            <td>${rowData.address || ''}</td>
        </tr>
        <tr>
            <td>Action:</td>
            <td>${rowData.action || ''}</td>
        </tr>
        
        <tr>
            <td>Office Email ID:</td>
            <td>${rowData.office_email_id || ''}</td>
        </tr>
        <tr>
            <td>User Remarks:</td>
            <td>${rowData.withdraw_remarks || ''}</td>
        </tr>
    </table>
    `;
}

$(document).ready(function() {
  // Manual test for modal close
$('#DocumentModal .btn-danger').on('click', function () {
    // Blur the currently focused element
    if (document.activeElement) document.activeElement.blur();

    $('#DocumentModal').modal('hide');
});
$('#remarks_modal .btn-danger').on('click', function () {
    // Blur the currently focused element
    if (document.activeElement) document.activeElement.blur();

    $('#remarks_modal').modal('hide');
});
    var table = $('#waitinglist').DataTable({
        processing: true,
        serverSide: true,
       lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('waitinglist.data') }}",
            type: "POST",
            data: function(d) {
                d.quartertype = $('#quartertype').val();
            }
        },
        columns: [
            {
                className: 'details-control',
                orderable: false,
                searchable: false,
                data: null,
                defaultContent: ''
            },
           { data: 'r_wno', name: 'r_wno', width: '1%' },
            { data: 'wno', name: 'wno', width: '2%' },
            { data: 'quartertype', name: 'quartertype', width: '2%' },
            { data: 'name', name: 'name' },
            { data: 'designation', name: 'designation' },
            { data: 'office', name: 'office' },
            { data: 'inward_date', name: 'inward_date' },
            { data: 'date_of_retirement', name: 'date_of_retirement' },
            { data: 'office_remarks', name: 'office_remarks' }
        ],
        order: [[1, 'asc']],
    initComplete: function() {
    this.api().columns().every(function() {
        var column = this;
        if (column.index() === 0) return; // skip details-control column
        var input = $('<input type="text" placeholder="Search ' + $(column.header()).text() + '" style="width:100%;" />')
            .appendTo($(column.footer()).empty())
            .on('keyup change clear', function() {
               // console.log("Searching column " + $(column.header()).text() + " with value:", this.value);
                if (column.search() !== this.value) {
                    column.search(this.value).draw();
                }
            });
    });
}

    });

    // Add event listener for opening and closing details
    $('#waitinglist tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('body').on('click', '.getdocument', function()
      { 
           var uid = $(this).attr('data-uid');
          var type = $(this).attr('data-type');
          var rivision_id = $(this).attr('data-rivision_id');
          var requestid = $(this).attr('data-requestid');
          $.ajax({
            url: "{{ route('getdocumentdata') }}",
            method: 'POST',
            data: {uid:uid,type:type,rivision_id:rivision_id,requestid:requestid},
            success: function(result)
            {
              $("#viewdata").html(result);
             $('#DocumentModal').modal('show');

            }
          });
      });
    // Quarter type filter change reload
    $('#quartertype').on('change', function() {
        table.ajax.reload();
    });

    // Reset button clears quartertype and reloads table
    $('#btnReset').on('click', function() {
        $('#quartertype').val(null).trigger('change');
        table.ajax.reload();
    });
});
  function show_dialog_desig(u,w,q){ // alert("hi");alert(u);alert(w); alert(q);
      $('#remarks_modal').modal('show');
			$("#remarks_modal input[name=uid]").val(u);
			$("#remarks_modal input[name=wno]").val(w);
			$("#remarks_modal input[name=quartertype]").val(q);

		}
</script>
@endpush
