@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Create New Vouchers') }} @endsection

@section('main-content')
<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Create New Vouchers') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('vouchers.index') }}"> {{ __('Back to Voucher List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        
                        {!! Form::open(array('route' => 'vouchers.store','method'=>'POST')) !!}
                        <div class="row">                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Count:</strong>
                                    {!! Form::number('count', 1, array('placeholder' => 'Count','class' => 'form-control')) !!}
                                </div>
                            </div>                                                     
<!--                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Reseller:</strong>
                                    {!! Form::select('reseller', $reseller,[], array('class' => 'form-control','single')) !!}                                            
                                </div>
                            </div>-->
							<div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Voucher Price:</strong>
                                    {!! Form::select('vouchertype', $vouchertype,[], array('class' => 'form-control','single')) !!}                                            
                                </div>
                            </div>	
							<div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Activation Expired On:</strong>
                                     {!! Form::text('activation_expired', '', array('id' => 'activation_expired', 'class' => 'form-control','single')) !!}
									 <span>If empty, activation never expired</span>
                                </div>
                            </div>	
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('styles')
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">     
@endpush

@push('scripts')
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>   
    <script>
    $(function() {
            $( "#activation_expired" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
            });
    });
    </script>    

@endpush
