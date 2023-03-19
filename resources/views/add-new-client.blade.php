@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (is_array($errors))
            <div class="alert alert-danger">
                 <ul>
                    @foreach ($errors as $error)
                       <li>{{ $error }}</li>
                    @endforeach
                 </ul>
            </div>
            @endif
            
            <form method="POST" action="{{route('client.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row" style="margin-top: 15px;">
                    <label for="" class="col-md-4 col-form-label text-md-right">{{ __('Сlient') }}</label>

                    <div class="col-md-6">
                        <input id="text" type="text" class="form-control" placeholder="Сlient" name="client">
                    </div>
                </div>
                <input id="text" type="hidden" class="form-control" value="{{$id}}" name="company_id">

                <input id="text" type="hidden" class="form-control" value="{{auth()->user()->id}}" name="user_id">

                <button type="submit" class="btn btn-primary">{{ __('Добавить клиента') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection