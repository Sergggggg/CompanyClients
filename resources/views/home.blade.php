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
                   
                    <label for="" class="col-md-4 col-form-label text-md-right">{{ $infoCompany->company }}</label>

                    @foreach($infoCompany->clients ?? [] as $clientData)

                    <form id="editClient">

                    <input class="client_id" name="id" type="hidden" value="{{ $clientData->id }}">

                    <input class="check__input" name="client" type="text" value="{{ $clientData->client }}">

                    <button type="submit" class="btn btn-danger">
                        {{ __('Save edited') }} 
                    </button>

                    </form>

                    <form id="deleteClient">

                    <input class="client_id" name="id" type="hidden" value="{{ $clientData->id }}">

                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure delete this record?')">
                        {{ __('Delete client') }} 
                    </button>

                    </form>

                    @endforeach

                    <form action="{{ route('company.destroy', ['company' => $infoCompany->id]) }}" method="POST">
                     @csrf

                     @method('DELETE')

                     <input class="check__input" name="user_id" type="hidden" value="{{auth()->user()->id}}">
                      <button type="submit" onclick="return confirm('Are you sure delete this record?')" class="btn btn-danger">
                        <i class="fa fa-btn fa-trash"></i>{{ __('Delete') }} 
                    </button>
                    </form>

                    <a href="{{route('client.show', $infoCompany->id ) }}"> {{ __('Add new clients') }} </a>

                    <a href="{{route('edit.show', $infoCompany->id ) }}"> {{ __('Edit') }} </a>

                @endforeach

                </div>

                <a href="{{route('company.create')}}"> {{ __('Create new company') }} </a>

        </div>
    </div>
</div>
@endsection

@section('js')
    <script> 

    $(document).on("submit", "#editClient", function (event) {
        
        event.preventDefault();

        prepareRequest(event, 'PUT');
    
    });

    $(document).on("submit", "#deleteClient", function (event) {
        
        event.preventDefault();

        prepareRequest(event, 'DELETE');
    
    });

    function prepareRequest(event, types){

    let client = $(event.target).find('.check__input').val(),
    
        client_id = $(event.target).find('.client_id').val(),

        url = "{{url('client') }}" + '/' + client_id,

        type = types;

        ajaxRequest(client, client_id, url, type);

    } 
    function ajaxRequest(client, client_id, url, type){

        $.ajax({

          url: url,
          type:type,
          data:{
            "_token": "{{ csrf_token() }}",
            client:client,
            id:client_id,
          },
          success:function(response){

            $(".card-body").html($(response.html).find('.card-body').html());
          
          },


        });
    }


    </script>
@endsection