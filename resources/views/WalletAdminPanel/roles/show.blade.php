@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Role') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Role') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">
                    
                    <div class="col-md-6">    
                        <h2>{{ $role->name }}<h2>
                        
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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('roles.index') }}"> {{ __('Back to Role List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        
                       <div class="form-group">
                            <strong>Permissions:</strong>
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <label class="label label-success">{{ $v->name }},</label>
                                @endforeach
                            @endif
                        </div>
                        
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
