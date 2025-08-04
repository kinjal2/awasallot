@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0 text-dark">Higher Quarter Request</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Higher Quarter Request</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>






    @if( $isEdit == 1)
        <!-- Nav tabs -->
        <ul class="nav nav-tabs " id="quarterTabs" role="tablist" >
       
           @if( ($quarterequestb['app_ddo']==1) || ($quarterequestb['app_admin']==1) )
            <li class="nav-item" role="presentation">
                <button class="nav-link   {{ $active_tab == 'tab1' ? 'active' : '' }}"
                        id="request-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#request"
                        type="button"
                        role="tab"
                        aria-controls="request"
                        aria-selected="true" disabled>
                    User Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link  {{ $active_tab == 'tab2' ? 'active' : '' }}"
                        id="history-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#history"
                        type="button"
                        role="tab"
                        aria-controls="history"
                        aria-selected="false" disabled>
                 Higher Category Request Form
                </button>
            </li>
            @endif 
            @if($document_tab > 0)
            <li class="nav-item" role="presentation">
                <button class="nav-link  {{ $active_tab == 'tab3' ? 'active' : '' }}"
                        id="upload-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#upload"
                        type="button"
                        role="tab"
                        aria-controls="upload"
                        aria-selected="false" disabled>
               Document Attachment
                </button>
            </li>
            @endif
            
            
        </ul>

        <!-- Tab content -->
        <div class="tab-content mt-3" id="quarterTabContent">
             @if( ($quarterequestb['app_ddo']==1) || ( $quarterequestb['app_admin']==1))
            <div class="tab-pane fade {{ $active_tab == 'tab1'  ? 'show active' : ''  }}"
                 id="request"
                 role="tabpanel"
                 aria-labelledby="request-tab">
                @include('user.userprofile_tabview')
            </div>
            <div class="tab-pane fade {{ $active_tab == 'tab2' ? 'show active' : ''  }}"
                 id="history"
                 role="tabpanel"
                 aria-labelledby="history-tab">
                @include('user.higherqueter_tabview')
            </div>
            @endif
           
           
            <div class="tab-pane fade  show {{ $active_tab == 'tab3' ? 'show active' : ''  }}"
                 id="upload"
                 role="tabpanel"
                 aria-labelledby="upload-tab">
                @include('user.documentupload_tabview')
                
            </div>
           
        </div>
    @else
        {{-- If not edit mode, just show the Request Form directly --}}
        @include('user.higherqueter_tabview')
    @endif

</div>

@endsection

@push('page-ready-script')
@endpush

