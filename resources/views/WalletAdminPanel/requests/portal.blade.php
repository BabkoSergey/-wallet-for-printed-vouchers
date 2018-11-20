@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Portal Requests List') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Portal Requests List') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                        @endif  
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 -text-right">
                        @if($is_confirmation)
                            {{ __('Administrator confirmation required!')}}
                        @else
                            {{ __('Automatically add a portal')}}
                        @endif
                    </div>
                    
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <table id="request_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th>No</th>
                                    <th>User</th>                                    
                                    <th>Portal</th>
                                    <th>Host</th>
                                    <th>Description</th>
                                    <th>Created at</th>                                    
                                    <th>Updated at</th>         
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody></tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@if(Auth::user()->hasPermissionTo('voucher-delete'))
<div style="display: none">
    <form id="jq_request-delete-form" method="POST" action="" data-url="{{ url('/adminpanel/requests/portal/') }}" accept-charset="UTF-8">
        @csrf
        <input name="_method" type="hidden" value="DELETE">    
        <input class="btn btn-danger" type="submit" value="Delete">
    </form>
</div>
@endif

@endsection

@push('styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}"/>
    
@endpush

@push('scripts')
    
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    
    <script>
    $(function () {
        
        var table = $("#request_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('adminpanel/requests/portal_dt_ajax') }}",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
                order: [[ 0, "desc" ]],	
                columns: [
                {   data: 'id' },
                {   data: 'user_id' },
                {   data: 'request',
                    render: function ( data, type, row ) {
                        return '<b>'+data.name+'</b>';
                    }
                },
                {   data: 'request',
                    orderable: false,
                    render: function ( data, type, row ) {
                          return '<a href="'+data.host+'" target="_blank">'+data.host+'</a>';
                      }
                },                
                {   data: 'request',
                    orderable: false,
                    render: function ( data, type, row ) {
                          return data.description;
                      }
                },                                
                {   data: 'created_at' },
                {   data: 'updated_at' },
                {   data: 'status',
                    render: function ( data, type, row ) {
                        var status = '';
                        if( data == 'pending'){                          
                            status += '<label class="badge badge-warning" style="margin:0 5px;">'+data+'</label>';                                                        
                        }else if(data == 'disabled'){
                            status += '<label class="badge badge-danger" style="margin:0 5px;">'+data+'</label>';                                
                        }
                        return status;
                    }
                },
                {   data: 'actions',
                    orderable: false,
                    render: function ( data, type, row ) {
                        var actions = '';
                                                
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('/adminpanel/requests/portal') }}/'+row.id+'" class="btn btn-primary"><i class="icon-list icons"></i></a>';
                        actions += '</div>';                        
                        
                        @if(Auth::user()->hasPermissionTo('portal-create'))                        
                            actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                             
                            actions += '<a href="{{ url('/adminpanel/requests/portal') }}/'+row.id+'/approve" class="btn btn-success"><i class="icon-pencil icons"></i></a>';
                            actions += '</div>';
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('portal-edit'))
                        if(row.status == 'pending'){                            
                            actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                             
                            actions += '<a href="{{ url('/adminpanel/requests/portal') }}/'+row.id+'/disable" class="btn btn-danger"><i class="icon-fire icons"></i></a>';
                            actions += '</div>';
                        }
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('portal-delete'))                        
                            actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                        
                            actions += '<a href="" class="btn btn-danger jq_request-delete" data-request_id="'+row.id+'"><i class="icon-trash icons"></i></a>';
                            actions += '</div>';
                        @endif
                        
                        return actions;
                    }
                }
            ]
            });
            
        $(document).on('click','.jq_request-delete',function (e){
            e.preventDefault(); 
            $('#jq_request-delete-form').attr('action',$('#jq_request-delete-form').attr('data-url')+ '/' + $(this).attr('data-request_id'));
            $('#jq_request-delete-form').submit();
        });    
            
    });
    </script>
    
@endpush
