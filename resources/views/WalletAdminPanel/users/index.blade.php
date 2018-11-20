@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('User List') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('User List') }} </h1>
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
                        @if(Auth::user()->hasPermissionTo('user-create'))
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('users.create') }}"> {{ __('Create New User') }}</a>                        
                        @endif
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <table id="users_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Reseller</th>
                                    <th>Portal</th>
                                    <th>Roles</th>
                                    <th style="width:120px">Action</th>
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

@if(Auth::user()->hasPermissionTo('user-delete'))
<div style="display: none">
    <form id="jq_user-delete-form" method="POST" action="" data-url="{{ url('/adminpanel/users/') }}" accept-charset="UTF-8">
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
            $("#users_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('adminpanel/user_dt_ajax') }}",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
            columns: [
                {   data: 'id' },
                {   data: 'name' },
                {   data: 'email' },
                {   data: 'reseller',
                    orderable: false,
                    render: function ( data, type, row ) {
                          var reseller = '';                                                
                          if( data instanceof Object){                          
                              reseller = data.name;                            
                          }                    
                          return reseller;
                      }
                },
                {   data: 'portal',
                    orderable: false,
                    render: function ( data, type, row ) {
                          var portal = '';                                                
                          if( data instanceof Object){                          
                              portal = data.name;                            
                          }                    
                          return portal;
                      }
                },
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
                },
                {   data: 'actions',
                    orderable: false,
                    render: function ( data, type, row ) {
                        var actions = '';
                        
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('adminpanel/users') }}/'+row.id+'" class="btn btn-success"><i class="icon-eye icons"></i></a>';
                        actions += '</div>';
                        
                        @if(Auth::user()->hasPermissionTo('user-edit'))
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('adminpanel/users') }}/'+row.id+'/edit" class="btn btn-primary"><i class="icon-pencil icons"></i></a>';
                        actions += '</div>';
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('user-delete'))
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                        
                        actions += '<a href="" class="btn btn-danger jq_user-delete" data-user_id="'+row.id+'"><i class="icon-trash icons"></i></a>';
                        actions += '</div>';
                        @endif
                        
                        return actions;
                    }
                }
            ]
            });
            
        $(document).on('click','.jq_user-delete',function (e){
            e.preventDefault(); 
            $('#jq_user-delete-form').attr('action',$('#jq_user-delete-form').attr('data-url')+ '/' + $(this).attr('data-user_id'));
            $('#jq_user-delete-form').submit();
        });    
            
    });
    </script>
    
@endpush