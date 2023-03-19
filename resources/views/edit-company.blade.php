@extends('adminlte::page')
@include('flash-message')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
                <div class="card-body">
                @if (is_array($errors))
                    <div class="alert alert-danger">
                         <ul>
                            @foreach ($errors as $error)
                               <li>{{ $error }}</li>
                            @endforeach
                         </ul>
                    </div>
                @endif
                   @foreach($infoCompanies ?? [] as $infoCompany)

                   <form action="{{route('edit.store')}}" method="POST">

                    @csrf

                        <div class="col-md-6">
                            <input id="text" type="text" class="form-control" placeholder="Company" name="company" 
                            value="{{ $infoCompany->company }}">
                        </div><br>

                        <input class="check__input" name="id" type="hidden" value="{{$infoCompany->id}}">

                        <input class="check__input" name="user_id" type="hidden" value="{{auth()->user()->id}}">

                        <button type="submit" class="btn btn-danger">
                            {{ __('Save edited') }} 
                        </button>
                    </form>

                @endforeach

                </div>
        </div>
    </div>
</div>
@endsection
