@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Portal List') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Portal List') }} </h1>
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
                    </div>

                    <div class="col-md-6 -text-right">
                        @if(Auth::user()->hasPermissionTo('portal-create'))
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('portal.create') }}"> {{ __('Create New Portal') }}</a>     
                        @endif
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <table id="apikey_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Host</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th style="max-width: 160px;">Action</th>
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

@if(Auth::user()->hasPermissionTo('apikey-delete'))
<div style="display: none">
    <form id="jq_apikey-delete-form" method="POST" action="" data-url="{{ url('/adminpanel/portal/') }}" accept-charset="UTF-8">
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
            $("#apikey_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('adminpanel/portal_dt_ajax') }}",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
            columns: [
                {   data: 'id' },
                {   data: 'name' },
                {   data: 'host' },
                {   data: 'description' },
                {   data: 'status',
                    render: function ( data, type, row ) {
                        var status = '';
                        if( data == 'active'){                          
                            status += '<label class="badge badge-success" style="margin:0 5px;">'+data+'</label>';                                                        
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
                        actions += '<a href="{{ url('adminpanel/portal') }}/'+row.id+'" class="btn btn-success"><i class="icon-eye icons"></i></a>';
                        actions += '</div>';
                        
                        @if(Auth::user()->hasPermissionTo('portal-edit'))
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('adminpanel/portal') }}/'+row.id+'/edit" class="btn btn-primary"><i class="icon-pencil icons"></i></a>';
                        actions += '</div>';
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('portal-edit'))
                            if(row.status != 'disabled'){
                                actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                        
                                actions += '<a href="{{ url('adminpanel/portal') }}/'+row.id+'/disable" class="btn btn-danger"><i class="icon-fire icons"></i></a>';
                                actions += '</div>';
                            }
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('portal-delete'))                        
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                        
                        actions += '<a href="" class="btn btn-danger jq_apikey-delete" data-apikey_id="'+row.id+'"><i class="icon-trash icons"></i></a>';
                        actions += '</div>';
                        @endif
                        
                        return actions;
                    }
                }
            ]
            });
            
        $(document).on('click','.jq_apikey-delete',function (e){
            e.preventDefault(); 
            $('#jq_apikey-delete-form').attr('action',$('#jq_apikey-delete-form').attr('data-url')+ '/' + $(this).attr('data-apikey_id'));
            $('#jq_apikey-delete-form').submit();
        });    
            
    });
    </script>
    
@endpush