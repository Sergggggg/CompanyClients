<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Companies;

class CreateCompanyController extends Controller
{
    
	public function create(){

		return view('create-company');
	}

	/**
     *  Save new data company.
     */
	
	public function store(Request $request){

		$validator = $this->validator($request->all());

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company' => ['required', 'string', 'max:50'],
        ]);
    }

}
