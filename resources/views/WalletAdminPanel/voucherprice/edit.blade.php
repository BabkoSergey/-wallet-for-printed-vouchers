@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Edit Voucher Price') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Edit Voucher Price') }} </h1>
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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('voucherprice.index') }}"> {{ __('Back to Voucher Prices List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">    
                        {!! Form::model($vouchertype, ['method' => 'PATCH','route' => ['voucherprice.update', $vouchertype->id]]) !!}
                        <div class="row">
<!--                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>-->
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {!! Form::text('price', null, array('placeholder' => 'Price','class' => 'form-control')) !!}
                                </div>
                            </div>                                                        
<!--                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Validity:</strong>
                                    {!! Form::text('validity', null, array('placeholder' => 'Price','class' => 'form-control')) !!}                                            
                                </div>
                            </div>-->
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
        
@endpush

@push('scripts')
    
    <script>
    $(function () {
        
    });
    </script>
    
@endpush
