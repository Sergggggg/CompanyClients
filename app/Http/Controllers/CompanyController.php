<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Companies;

class CompanyController extends Controller
{
    
	public function create(){

		return view('create-company');
	}

	/**
	* 	Add data company to database.
	*/

	public function store(Request $request){

		$rules = $this->rules();

		$validator = $this->validator($request->all(), [$rules['company']]);

		if($validator->fails()){
			
			$errors = $validator->errors()->all();
		
			return	view('create-company', compact('errors'));

		}else{

	    	Companies::create([
			    'company' => $request->company,
			    'user_id' => (int)$request->user_id,
			]);

			return redirect()->route('home')->with('success','Company created successfully!');
		}
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
	       'company' => ['required', 'string', 'max:50'],
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

	/**
	* 	Delete data company from database.
	*/
    
    public function destroy(Request $request, $id){

		$rules = $this->rules();

		$validator = $this->validator([$id], [$rules['company']]);

		if($validator->fails()){
			
			$errors = $validator->errors()->all();
		
			return	redirect()->route('home')->with('errors', 'Validation failed');

		}else{

			Companies::where('id', $id)
			   ->where('user_id', $request->user_id)
			   ->delete();


		    return redirect()->route('home')->with('success','Company deleted successfully!');

    	}
	}

}
