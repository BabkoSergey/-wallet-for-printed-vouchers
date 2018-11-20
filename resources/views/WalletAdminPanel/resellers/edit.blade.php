@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Edit Reseller') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Edit Reseller') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        @if ($reseller->status == 'deleted')
                            <label class="badge badge-danger" style="margin:0 5px;"> {{ __($reseller->status) }} </label>
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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('resellers.index') }}"> {{ __('Back to Reseller List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">    
                        {!! Form::model($reseller, ['method' => 'PATCH','route' => ['resellers.update', $reseller->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control')) !!}
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    {!! Form::select('status', ['pending'=>'pending','active'=>'active','hold'=>'hold'],[$reseller->status=>$reseller->status], array('class' => 'form-control','single')) !!}                                            
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
        
@endpush

@push('scripts')
    
    <script>
    $(function () {
        
    });
    </script>
    
@endpush
