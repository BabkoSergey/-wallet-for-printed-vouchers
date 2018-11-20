@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Portal Settings') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Portal Settings') }} </h1>
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
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>                            
                            Do you need confirmation of the administrator to register a new portal? Or is the new portal automatically registered?
                        </p>
                    </div>
                    <div class="col-md-12">                          
                        {!! Form::model($settings, ['method' => 'PATCH','route' => ['settings.update', $settings->id]]) !!}
                        <div class="row">                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>New Portal Request:</strong>
                                    {!! Form::select('value', ['yes'=>'Administrator confirmation required!','no'=>'Automatically add a portal'],[$settings->value], array('class' => 'form-control','single')) !!}                                            
                                </div>
                            </div>
                            <input type="hidden" name="route" value="portal">
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
        
    </script>
    
@endpush
