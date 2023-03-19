<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Clients;
use App\Models\Companies;

class ClientController extends Controller
{

	private $clients;

    public function __construct(Clients $clients)
    {
    	$this->clients = $clients;
    }
    
	public function show($id){

		return view('add-new-client', compact('id'));
	}

	/**
	* 	Add data client to database.
	*/

	public function store(Request $request){

		$errors = $this->rulesResults($request->client, 'client');

		if($errors){
		
			return	redirect()->route('home')->with('errors', 'Validate data failed');
		
		}else{

			$this->clients->client = $request->client;

			$this->clients->save();

			$this->clients->companies()->sync($request->company_id);

			return redirect()->route('home')->with('success','Сlidient created successfully!');
 
		}
 
	}

	/**
	* 	Update data client from database.
	*/

	public function update(Request $request){

		$errors = $this->rulesResults($request->client, 'client');

		if($errors){

			return response()->json(['errors' => 'Validate data failed!']);
		
		}else{

			$dataClients   =  $this->clients->query()
		 			  		  ->where('id', $request->id)
		 			  		  ->first();

		    $dataClients->client = $request->client; 

		    $dataClients->update();

		    $infoCompanies = $this->updateCompaniesData();

		    return response()->json(['html'=> view('home', compact('infoCompanies'))->render()]);
		}

	}

	/**
	* 	Delete data clients from database.
	*/

	public function destroy(Request $request){

			$clients = $this->clients->query()
		  		  ->where('id', $request->id)
		  		  ->first();
		  	
		  	$clients->companies()->detach();

		  	$clients ->delete();

		  	$infoCompanies = $this->updateCompaniesData();

		return response()->json(['html'=> view('home', compact('infoCompanies'))->render()]);

	}

	/**
	* 	Updates data after ajax request.
	*/

	public function updateCompaniesData(){

		$user = Auth::user();

		return Companies::query()->where('user_id', $user->id)->get();
	}


	/**
	* 	Get the validation results.
	*/

	public function rulesResults($client, $field){
		
    	$rules = $this->rules();

    	$validator = $this->validator([$client],[$rules[$field]]);
		
		$errors = $validator->errors()->all();

		return $errors;

	}

	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/

	public function rules()
	{
	   return [
	       'id' => 'numeric|not_in:0',
	       'client' => ['required', 'string', 'max:50'],
	   ];
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }

}
