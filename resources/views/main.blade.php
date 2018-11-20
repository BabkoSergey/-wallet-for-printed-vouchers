@extends('layouts.app')

@section('Spatie')
     @if (isset($Spatie))
        <h2> {{$Spatie}} </h2> 
     @endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Check Voucher</div>

                <div class="card-title">
                    <div class="row">
                        <div class="col-md-12">                        
                            @if (count($errors) > 0)                            
                                @if (count($errors->get('success')) > 0)
                                    <div class="alert alert-success">
                                        <strong>The Voucher is ready for activation!</strong><br>
                                        <ul>
                                            @foreach ($errors->get('success') as $mess)
                                                <li><strong>{{ $mess }} </strong></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems.<br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif                            
                            @endif                                                        
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">    
                            <form method="POST" action="{{ url('/check_voucher') }}" autocomplete="off">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Voucher KEY:</strong>
                                            <input type="text" class="form-control" name="voucher_key" value="{{old('voucher_key')}}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Voucher Date Price:</strong>
                                            <input class="form-control" id="voucher_date" name="voucher_date" value="{{old('voucher_date')}}" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>                                    
                                    @csrf
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Check</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
$(function() {    
    $(document).ready(function() {
        $( "#voucher_date" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yyyy'
        });	        
    });    
});
</script>

@endpush
