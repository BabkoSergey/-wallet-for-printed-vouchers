@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Voucher List') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Voucher List') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-10">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                        @endif
                        
                        <div class="filter-actions">    
                            <label for="f_is_print">Is Print</label>
                            <select class="form-control" single="" name="f_is_print" id="f_is_print">
                                <option value="all" selected>All</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            
                            <label for="f_status">Status</label>
                            <select class="form-control" single="" name="f_status" id="f_status">
                                <option value="all" selected>All</option>
                                <option value="sale">Sale</option>
                                <option value="sold">Sold</option>
                                <option value="activate">Activate</option>
                                <option value="finish">Finish</option>
                                <option value="overdue">Overdue</option>
                                <option value="blocked">Blocked</option>
                                <option value="refund">Refund</option>
                            </select>
                            
                            <label for="f_price">Price >=</label>
                            <input class="form-control" type="number" name="f_price" id="f_price" min="0" value="0">                            
                            
                            <label for="f_date">Date</label>
                            <select class="form-control" single="" name="f_date" id="f_date">
                                <option value="expire" selected>Expire</option>
                                <option value="created_at">Created At</option>
                                <option value="updated_at">Updated At</option>                                
                            </select>
                            
                            <label for="f_expire"> from</label>
                            <input class="form-control" name="f_expire" id="f_expire">   
                            
                            <label for="f_expire_between"> to</label>
                            <input class="form-control" name="f_expire_between" id="f_expire_between">                                                                                    
                        </div>  
                        
                        <div class="filter-actions" style="margin-top: 10px;">    
                            <label for="f_reseller">Reseller</label>
                            <select class="form-control" single="" name="f_reseller" id="f_reseller">
                                <option value="all" selected>All</option>
                                @foreach($resellers as $id=>$reseller)
                                    <option value="{{$id}}">{{$reseller}}</option>
                                @endforeach                                
                            </select>
                            
                            <label for="f_privider">Provider</label>
                            <select class="form-control" single="" name="f_privider" id="f_privider">
                                <option value="all" selected>All</option>
                                @foreach($providers as $id=>$provider)
                                    <option value="{{$id}}">{{$provider}}</option>
                                @endforeach                                
                            </select>
                            
                        </div>  
                                                
                    </div>

                    <div class="col-md-2 -text-right">
                        @if(Auth::user()->hasPermissionTo('voucher-create'))
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('vouchers.create') }}"> {{ __('Create New Vouchers') }}</a>                        
                        @endif
                    </div>
                    
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <table id="voucher_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th>No</th>
                                    <th>Reference</th>                                    
                                    <th>Voucher</th>
                                    <th>Status</th>
                                    <th>Reseller</th>
                                    <th>Seller</th>
                                    <th>User</th>
                                    <th>Provider</th>
                                    <th>Price</th>
                                    <th>Expire Date</th>
                                    <th>Created at</th>                                    
                                    <th>Updated at</th>         
                                    <th>Is Printed</th>
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
    <form id="jq_vouchers-delete-form" method="POST" action="" data-url="{{ url('/adminpanel/vouchers/') }}" accept-charset="UTF-8">
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
        
        var ajax_url = "{{ url('adminpanel/vouchers_dt_ajax') }}";
    
        var f_is_print = $('#f_is_print').val();
        var f_status = $('#f_status').val();
        var f_price = $('#f_price').val();
        var f_date =  $('#f_date').val();
        var f_expire = $('#f_status').val();;
        var f_expire_between = $('#f_price').val();
        
        var f_reseller = $('#f_reseller').val();
        var f_privider = $('#f_privider').val();
         

        var filterTimer;

        function filtrateTable(){
            f_is_print = $('#f_is_print').val();
            f_status = $('#f_status').val();
            f_price = $('#f_price').val();
            f_date =  $('#f_date').val();
            f_reseller = $('#f_reseller').val();
            f_privider =  $('#f_privider').val();
            
            f_expire = $("#f_expire").val();
            f_expire_between = $("#f_expire_between").val();
            
            ajax_url_filtrate = ajax_url+'?f_is_print='+f_is_print+'&f_status='+f_status+'&f_price='+f_price+'&f_date='+f_date+'&f_reseller='+f_reseller+'&f_privider='+f_privider;
            if(f_expire){
                ajax_url_filtrate += '&f_expire=' + f_expire;
            }
            if(f_expire_between){
                ajax_url_filtrate += '&f_expire_between=' + f_expire_between;
            }            
            
            table.ajax.url(ajax_url_filtrate).load();        
        }
            
        $( "#f_expire" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yyyy-mm-dd',
            autoClose: true,
            clearButton: true,
            onSelect: function(formattedDate, date, inst) {
                clearTimeout(filterTimer);                
                filtrateTable();                
            }
        });	        
        
        $( "#f_expire_between" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yyyy-mm-dd',
            autoClose: true,
            clearButton: true,
            onSelect: function(formattedDate, date, inst) {
                clearTimeout(filterTimer);                
                filtrateTable();                
            }
        });	
        
        $(document).ready(function() {
            $('#f_reseller').select2();
        });
        
        $(document).ready(function() {
            $('#f_privider').select2();
        });
               

        $(document).on('change','#f_is_print, #f_status, #f_price, #f_date, #f_reseller, #f_privider',function(){
            clearTimeout(filterTimer);
            filtrateTable();
        });

        $(document).on('keyup','#f_price',function(){
            clearTimeout(filterTimer);
            filterTimer = setTimeout(filtrateTable(), 500); 
        });   
        
        var table = $("#voucher_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('adminpanel/vouchers_dt_ajax') }}",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
				order: [[ 0, "desc" ]],	
                columns: [
                {   data: 'id' },
                {   data: 'reference' },
                {   data: 'voucher',
                    render: function ( data, type, row ) {
                        return '<b>'+data+'</b>';
                    }
                },
                {   data: 'status',
                    render: function ( data, type, row ) {
                        var status = '';
                        if( data == 'sale'){                          
                            status += '<label class="badge badge-warning" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'sold'){
                            status += '<label class="badge badge-primary" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'activate'){
                            status += '<label class="badge badge-success" style="margin:0 5px;">'+data+'</label>';
			}else if(data == 'finish'){
                            status += '<label class="badge badge-info" style="margin:0 5px;">'+data+'</label>';
                        }else if(data == 'overdue'|| data == 'blocked'){
                            status += '<label class="badge badge-danger" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'refund' || data == 'blocked'){
                            status += '<label class="badge badge-secondary" style="margin:0 5px;">'+data+'</label>';                                
                        }
                        return status;
                    }
                },
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
                {   data: 'seller_id' },
                {   data: 'user_id' },
                {   data: 'seller_host' },
                {   data: 'price'},
                {   data: 'expire',
                    render: function ( data, type, row ) {
                        if(data){
                            return '<b>'+data+'</b>';
                        }else{
                            return '';
                        }                        
                    }
                },
                {   data: 'created_at' },
                {   data: 'updated_at' },
                {   data: 'is_printed',
                    render: function ( data, type, row ) {
                        if(data){
                            return '<b>Yes</b>';
                        }else{
                            return '';
                        }  
                    }
                }, 
                {   data: 'actions',
                    orderable: false,
                    render: function ( data, type, row ) {
                        var actions = '';
                                                
                        actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                        actions += '<a href="{{ url('/adminpanel/voucher_show') }}/'+row.id+'" class="btn btn-primary" target="_blank"><i class="icon-list icons"></i></a>';
                        actions += '</div>';                        
                        
                        @if(Auth::user()->hasPermissionTo('voucher-delete'))
                        if(row.status == 'sale'){                            
                            actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';                        
                            actions += '<a href="" class="btn btn-danger jq_vouchers-delete" data-vouchers_id="'+row.id+'"><i class="icon-trash icons"></i></a>';
                            actions += '</div>';
                        }
                        @endif
                        
                        return actions;
                    }
                }
            ]
            });
            
        $(document).on('click','.jq_vouchers-delete',function (e){
            e.preventDefault(); 
            $('#jq_vouchers-delete-form').attr('action',$('#jq_vouchers-delete-form').attr('data-url')+ '/' + $(this).attr('data-vouchers_id'));
            $('#jq_vouchers-delete-form').submit();
        });    
            
    });
    </script>
    
@endpush
