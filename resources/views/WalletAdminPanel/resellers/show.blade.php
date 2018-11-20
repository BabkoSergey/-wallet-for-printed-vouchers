@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Reseller') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Reseller') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{$reseller->name}}
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('resellers.index') }}"> {{ __('Back to Reseller List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {{$reseller->name}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {{$reseller->address}}
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    {{$reseller->status}}
                                </div>
                            </div>                            
                        </div>                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <h5>Users {{$reseller->name}}</h5>
                    </div>
                    <div class="col-md-12">                                                                        
                        <table id="users_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
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

@endsection

@push('styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}"/>
        
@endpush

@push('scripts')

    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    
    <script>
    $(function () {
            $("#users_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('adminpanel/resellers_dt_ajax') }}/"+"{{ $reseller->id }}"+"/",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
            columns: [
                {   data: 'id' },
                {   data: 'name' },
                {   data: 'email' },                
                {   data: 'roles',
                    orderable: false,
                    render: function ( data, type, row ) {
                        var roles = '';
                        if( data instanceof Array){                          
                            data.map(key => {
                                roles += '<label class="badge badge-success" style="margin:0 5px;">'+key.name+'</label>';                                
                              });
                        }                    
                        return roles;
                    }
                }                
            ]
        });
                        
    });
    </script>
    
@endpush