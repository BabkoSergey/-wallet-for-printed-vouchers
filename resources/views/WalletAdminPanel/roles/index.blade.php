@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Role List') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Role List') }} </h1>
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
                        @if(Auth::user()->hasPermissionTo('role-create'))
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('roles.create') }}"> {{ __('Create New Role') }}</a>                        
                        @endif
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <table id="roles_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th style="max-width: 40px;">No</th>
                                    <th>Name</th>                                    
                                    <th style="max-width: 110px;">Action</th>
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

@if(Auth::user()->hasPermissionTo('role-delete'))
<div style="display: none">
    <form id="jq_role-delete-form" method="POST" action="" data-url="{{ url('/adminpanel/roles/') }}" accept-charset="UTF-8">
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
            $("#roles_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('adminpanel/roles_dt_ajax') }}",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
            columns: [
                {   data: 'id' },
                {   data: 'name',
                    orderable: false,
                    render: function ( data, type, row ) {                        
                        return '<label class="badge badge-success" style="margin:0 5px;">'+data+'</label>';
                    }
                },
                {   data: 'actions',
                    orderable: false,
                    render: function ( data, type, row ) {
                        var actions = '';
                                                
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('adminpanel/roles') }}/'+row.id+'" class="btn btn-success"><i class="icon-eye icons"></i></a>';
                        actions += '</div>';
                        
                        @if(Auth::user()->hasPermissionTo('role-edit'))
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('adminpanel/roles') }}/'+row.id+'/edit" class="btn btn-primary"><i class="icon-pencil icons"></i></a>';
                        actions += '</div>';
                        @endif
                        
                        @if(Auth::user()->hasPermissionTo('role-delete'))
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                        
                        actions += '<a href="" class="btn btn-danger jq_user-delete" data-jq_role="'+row.id+'"><i class="icon-trash icons"></i></a>';
                        actions += '</div>';
                        @endif
                        
                        return actions;
                    }
                }
            ]
            });
            
        $(document).on('click','.jq_role-delete',function (e){
            e.preventDefault(); 
            $('#jq_role-delete-form').attr('action',$('#jq_role-delete-form').attr('data-url')+ '/' + $(this).attr('data-jq_role'));
            $('#jq_role-delete-form').submit();
        });    
            
    });
    </script>
    
@endpush
