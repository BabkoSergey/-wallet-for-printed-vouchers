@extends('Wallet.layouts.app')

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
                    </div>
                    
                    <div class="col-md-2 -text-right">    
                        <div class="hidden-actions">
                            @if(Auth::user()->hasPermissionTo('voucher-print'))                            
                            <div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">
                                <a href="{{ url('/wallet/vouchers/print') }}" data-url="{{ url('/wallet/vouchers/print') }}" data-target="{{ url('/wallet/voucher') }}" class="btn btn-primary btn-hidden-actions" target="_blank"><i class="icon-list icons"></i></a>                                
                            </div>
                            @endif

                            <div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">
                                <a href="{{ url('/wallet/vouchers/sold') }}" class="btn btn-success btn-hidden-actions"><i class="icon-basket icons"></i></a>
                            </div>

                            @if(Auth::user()->hasPermissionTo('reseller-voucher-edit'))                            
                            <div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">
                                <a href="{{ url('/wallet/vouchers/refund') }}" class="btn btn-danger btn-hidden-actions"><i class="icon-fire icons"></i></a>
                            </div>
                            @endif 
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <table id="voucher_table" class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                <tr class="success">
                                    <th style="text-align: center;"><label for="select-all">All</label><br><input type="checkbox" name="select_all" value="1" id="select-all"></th>
                                    <th>No</th>
                                    <th>Reference</th>                                    
                                    <th>Voucher</th>
                                    <th>Status</th>
                                    <th>Reseller</th>
                                    <th>Seller</th>
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

@if(Auth::user()->hasPermissionTo('reseller-voucher-edit'))
<div style="display: none">
    <form id="jq_vouchers-delete-form" method="POST" action="" data-url="{{ url('/wallet/vouchers/') }}" accept-charset="UTF-8">
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
        
        var ajax_url = "{{ url('wallet/vouchers_dt_ajax') }}";
    
        var f_is_print = $('#f_is_print').val();
        var f_status = $('#f_status').val();
        var f_price = $('#f_price').val();
        var f_date =  $('#f_date').val();
        var f_expire = $('#f_status').val();;
        var f_expire_between = $('#f_price').val();

        var filterTimer;

        function filtrateTable(){
            f_is_print = $('#f_is_print').val();
            f_status = $('#f_status').val();
            f_price = $('#f_price').val();
            f_date =  $('#f_date').val();
            
            f_expire = $("#f_expire").val();
            f_expire_between = $("#f_expire_between").val();
            
            ajax_url_filtrate = ajax_url+'?f_is_print='+f_is_print+'&f_status='+f_status+'&f_price='+f_price+'&f_date='+f_date;
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
        
                
    $(document).on('change','#f_is_print, #f_status, #f_price, #f_date',function(){
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
                ajax: ajax_url,
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ __('Search') }}"
                    },
            columnDefs: [
            {
                "targets": [ 1, 5, 6 ],
                "visible": false,
                "searchable": false
            },
            {
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',                
            }
            ],            
            order: [[ 0, "desc" ]],
            columns: [
                {   data: 'checkbox' ,
                    render: function (data, type, row){
                        return '<input type="checkbox" class="single_checkbox" name="id_'+row.id+'" value="' + row.id + '">';
                    }
                },
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
                            status += '<label class="voucher_status badge badge-warning" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'sold'){
                            status += '<label class="voucher_status badge badge-primary" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'activate'){
                            status += '<label class="voucher_status badge badge-success" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'finish'){
                            status += '<label class="voucher_status badge badge-info" style="margin:0 5px;">'+data+'</label>';
                        }else if(data == 'overdue' || data == 'blocked'){
                            status += '<label class="voucher_status badge badge-danger" style="margin:0 5px;">'+data+'</label>';                                
                        }else if(data == 'refund' || data == 'blocked'){
                            status += '<label class="voucher_status badge badge-secondary" style="margin:0 5px;">'+data+'</label>';                                
                        }else{
                            status += '<label class="voucher_status" style="margin:0 5px;"></label>';                                
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
                        
                        if(row.status == 'sale' || row.status == 'sold'){                            
                            @if(Auth::user()->hasPermissionTo('voucher-print'))                            
                                actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                                actions += '<a href="{{ url('/wallet/voucher') }}/'+row.id+'" class="btn btn-primary print_voucher" target="_blank"><i class="icon-list icons"></i></a>';
                                actions += '</div>';
                            @endif
                        }
                            
                        if(row.status == 'sale'){                            
                            actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                            actions += '<a href="{{ url('/wallet/voucher') }}/'+row.id+'/sold" class="btn btn-success sold_voucher"><i class="icon-basket icons"></i></a>';
                            actions += '</div>';                        
			}
                        
			if(row.status == 'sold'){
                            @if(Auth::user()->hasPermissionTo('reseller-voucher-edit'))                            
                            actions += '<div class="btn-group btn-group-sm" style="margin:0 5px;" role="group" aria-label="Basic example">';
                            actions += '<a href="{{ url('/wallet/voucher') }}/'+row.id+'/refund" class="btn btn-danger refund"><i class="icon-fire icons"></i></a>';
                            actions += '</div>';
                            @endif 
                        }
                        
                        return actions;
                    }
                }
            ]
            });
            
            function needShow(){
                var need_show = false;
                table.$('input[type="checkbox"]').each(function(){                                         
                    if(this.checked){
                        need_show = true;
                    }
                });                
                if(need_show){                        
                    $('.hidden-actions').show();
                }else{
                    $('.hidden-actions').hide();
                    $('#select-all').prop('checked', false);
                }                
            }
            
            function clearShow(){                
                table.$('input[type="checkbox"]').each(function(){                                         
                    if(this.checked){
                        $(this).prop('checked', false);
                    }
                });                                        
                $('.hidden-actions').hide();
                $('#select-all').prop('checked', false);                
            }
            
            $('#voucher_table').on( 'draw.dt', function () {
                needShow();
            } );
            
            $(document).on('click', '.single_checkbox', function(){                     
                needShow();
            });
                        
            $('#select-all').on('click', function(){
               var rows = table.rows({ 'search': 'applied' }).nodes();
               $('input[type="checkbox"]', rows).prop('checked', this.checked);
               needShow();
            });

            
            $('#voucher_table tbody').on('change', 'input[type="checkbox"]', function(){
               if(!this.checked){
                  var el = $('#select-all').get(0);                  
                  if(el && el.checked && ('indeterminate' in el)){                     
                     el.indeterminate = true;
                  }
               }
               needShow();
            });
      
        $(document).on('click', '.btn-hidden-actions', function(e){     
            var url = $(this).attr('href');
            var target = $(this).attr('target');                                    
            var ids = [];
            table.$('.single_checkbox').each(function(){                
                if(this.checked){
                    ids.push(this.value );                     
                }
            });
            if(target == '_blank'){
                url = $(this).attr('data-url');
                $(this).attr('href',$(this).attr('data-target')+'/'+ids.join(','));                                
            }else{
                e.preventDefault();
            }
            
            $.get(url+'/'+ids.join(','))
		.done(function (data) {	
                    clearShow();                    
                    data.data.map(function(item){
                        var edit_row = $('#voucher_table').DataTable().row( $('input[name="id_'+item.id+'"]').closest('tr')).index();
                        $('#voucher_table').DataTable().row(edit_row).data(item);
                    });
		})
		.fail(function (data) {
                    console.log(data);
                }); 
                                
        });
            
        
        $(document).on('click','.sold_voucher',function (e){
            e.preventDefault(); 
            var edit_row = $('#voucher_table').DataTable().row( $(this).closest('tr') ).index();
                        
            $.get($(this).attr('href'))
		.done(function (data) {						
                        $('#voucher_table').DataTable().row(edit_row).data(data);
		    })
		.fail(function (data) {
                    console.log(data);
                });                        
        }); 
        
        $(document).on('click','.print_voucher',function (e){            
            var edit_row = $('#voucher_table').DataTable().row( $(this).closest('tr') ).index();
            var row_id = $(this).attr('href');
            setTimeout(function () {			
                $.get(row_id+'/row')
                    .done(function (data) {						
                            $('#voucher_table').DataTable().row(edit_row).data(data);
                        })
                    .fail(function (data) {
                        console.log(data);
                    });     
            }, 500);
        });         
        
        $(document).on('click','.refund',function (e){  
            e.preventDefault(); 
            var edit_row = $('#voucher_table').DataTable().row( $(this).closest('tr') ).index();
            var row_id = $(this).attr('href');
            setTimeout(function () {			
                $.get(row_id)
                    .done(function (data) {						
                            $('#voucher_table').DataTable().row(edit_row).data(data);
                        })
                    .fail(function (data) {
                        console.log(data);
                    });     
            }, 500);
        }); 
           
       	            
    });
    </script>    
@endpush
