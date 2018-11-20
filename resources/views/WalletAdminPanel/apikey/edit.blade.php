@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Edit Api Key') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Edit Api Key') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        @if ($api_key->status == 'deleted')
                            <label class="badge badge-danger" style="margin:0 5px;"> {{ __($api_key->status) }} </label>
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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('apikey.index') }}"> {{ __('Back to Api Key List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">    
                        {!! Form::model($api_key, ['method' => 'PATCH','route' => ['apikey.update', $api_key->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Api Key:</strong>
                                    {!! Form::text('api_key', null, array('placeholder' => 'Api Key','class' => 'form-control', 'disabled')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>
                                    {!! Form::text('api_host', null, array('placeholder' => 'http://your.host','class' => 'form-control')) !!}
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    {!! Form::select('status', ['active'=>'active','deleted'=>'deleted'],[$api_key->status=>$api_key->status], array('class' => 'form-control','single')) !!}                                            
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
