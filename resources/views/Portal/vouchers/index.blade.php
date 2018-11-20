@extends('Portal.layouts.app')

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

                    <div class="col-md-12">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                        @endif
                        <div class="filter-actions">    
                                                        
                            <label for="f_status">Status</label>
                            <select class="form-control" single="" name="f_status" id="f_status">
                                <option value="all" selected>All</option>
                                <option value="activate">Activate</option>
                                <option value="finish">Finish</option>
                                <option value="overdue">Overdue</option>
                                <option value="blocked">Blocked</option>
                            </select>
                            
                            <label for="f_price">Price >=</label>
                            <input class="form-control" type="number" name="f_price" id="f_price" min="0" value="0">                            
                            
                            <label for="f_reseller">Reseller</label>
                            <select class="form-control" single="" name="f_reseller" id="f_reseller">
                                <option value="all" selected>All</option>
                                @foreach($resellers as $id=>$reseller)
                                    <option value="{{$id}}">{{$reseller}}</option>
                                @endforeach                                
                            </select>
                            
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
                                    <th>User</th>
                                    <th>Price</th>
                                    <th>Expire Date</th>                                                                        
                                    <th>Created at</th>                                    
                                    <th>Updated at</th>
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
        
        var ajax_url = "{{ url('portalpanel/vouchers_dt_ajax') }}";
            
        var f_status = $('#f_status').val();
        var f_price = $('#f_price').val();
        var f_date =  $('#f_date').val();
        var f_expire = $('#f_status').val();;
        var f_expire_between = $('#f_price').val();
        var f_reseller = $('#f_reseller').val();

        var filterTimer;

        function filtrateTable(){            
            f_status = $('#f_status').val();
            f_price = $('#f_price').val();
            f_date =  $('#f_date').val();
            f_reseller = $('#f_reseller').val();
            
            f_expire = $("#f_expire").val();
            f_expire_between = $("#f_expire_between").val();
            
            var ajax_url_filtrate = ajax_url+'?f_status='+f_status+'&f_price='+f_price+'&f_date='+f_date+'&f_reseller='+f_reseller;
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
        
                
    $(document).on('change','#f_status, #f_price, #f_date, #f_reseller',function(){
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
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }            
            ],            
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
                {   data: 'user_id' }, 
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
                {   data: 'updated_at' }                
            ]
            });
                   	            
    });
    </script>    
@endpush
