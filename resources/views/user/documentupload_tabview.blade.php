  <div class="content">
        <!-- Content Header (Page header) -->
       
        <!-- /.content-header -->
        <div class="col-md-12">
            <!-- general form elements -->
             @if($document_list != "")
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
                                            <input type="file" class="custom-file-input" id="image" name="image" onchange="updateFileName()">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
                            <input type="hidden" class="form-control" id="request_rev" name="request_rev"
                                value="{{ base64_encode($rev) }}">
                        </div>
                    </div>
                </form>
                
            </div>
            @endif
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
                                        @if($document_list != "")
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
                                              @if($document_list != "")
                                            <td>
                                                <a href="javascript:;" class="btn btn btn-danger delete_doc"
                                                    delete-id="{{ $a->rev_id }}" data-id="{{ $a->doc_id }}"><i
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
                                <input type="hidden" name="dgr" value="{{ isset($dgr) ? $dgr : '' }}" />
                                <input type="hidden" value="{{ count($document_list) }}" id="document_list" name="document_list">
                                <input type="hidden" value="{{ $isEdit ?? 0 }}" id="isEdit" name="isEdit">

                               
                           
                        </div>

                    </div>
 
                </div>

            </div>
            @if($document_list != "")
                                <table width="100%">
                                    <tr>
                                        <td> <button type="submit" class="btn btn-primary" id="submitFinalAnnex" name="submitFinalAnnex">Submit Document and Save Application</button></td>
                                    </tr>
                                </table>
                                @endif
            <!-- /.card -->
 </form>
        </div>
    </div>