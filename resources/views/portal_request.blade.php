@extends('layouts.app')

@section('Spatie')
     @if (isset($Spatie))
        <h2> {{$Spatie}} </h2> 
     @endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">                        
                            {{ __('Portal Request') }}
                        </div>
                        
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
                            
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                            @endif
                        </div>

                        <div class="col-md-3 text-right">
                            @if($user_request)
                            <strong>Status: </strong>
                            {{$user_request->status}}
                            @endif
                        </div>                        
                    </div>                    
                    
                </div>
                                
                <div class="card-body">
                    
                    <form method="POST" action="{{url('new_portal')}}" accept-charset="UTF-8" autocomplete="off">
                        @csrf
                        <div class="row">                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input placeholder="Portal name" class="form-control" name="name" type="text" value="@if($user_request){{$user_request->request->name}}@endif">
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>
                                    <input placeholder="http://your.host" class="form-control" name="host" type="text" value="@if($user_request){{$user_request->request->host}}@endif">
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <textarea class="form-control" rows="2" name="description" cols="50">@if($user_request){{$user_request->request->description}}@endif</textarea>                                    
                                </div>
                            </div>                            
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
