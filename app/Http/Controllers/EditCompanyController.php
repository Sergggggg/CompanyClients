<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Companies;
use Illuminate\Support\Facades\Auth;

class EditCompanyController extends Controller
{

    
    public function show($id){

    	$rules = $this->rules();

    	$validator = $this->validator([$id],[$rules['id']]);

			if($validator->fails()){
		
			$errors = $validator->errors()->all();
		
			return	redirect()->route('home')->with('errors', 'Validate data failed');

		}else{

			$infoCompanies = $this->getInfoCompany($id);

			return view('edit-company', compact('infoCompanies'));
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
     *  Info company.
     */

    protected function getInfoCompany($id) {

    	$user = Auth::user();

    	$infoCompany = Companies::query()
    					->where('user_id', $user->id)
    					->where('id', $id)
    					->get();

		return $infoCompany;

    }

    /**
     *  Save edited data.
     */

    public function store(Request $request){

    	$rules = $this->rules();

    	$validator = $this->validator([$request->company],[$rules['company']]);

			if($validator->fails()) {
		
			$errors = $validator->errors()->all();
		
			return	redirect()->route('edit-company')->with('errors');

		} else{

			Companies::where('id', $request->id)
					   ->where('user_id', $request->user_id)
					   ->update(['company' => $request->company]);


		    return	redirect()->route('home')->with('success', 'Company updated successfully!');

		} 
    }

}
