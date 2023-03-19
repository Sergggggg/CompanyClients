<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\JsonResponseFormat;
use App\Models\Companies;
use App\Models\Clients;
use Illuminate\Http\Request;


class ExportController extends Controller
{
    use JsonResponseFormat;

    public function getCompanies()
    {

        return Companies::paginate(100);
    }

    public function getClients($id)
    {
        return Clients::select('client')->whereHas('companies', function($q) use($id){
            
            $q->where('company_id', $id);
        
        })->get();
    }


    public function getClientCompanies($id)
    {

        return Companies::select('company')->whereHas('clients', function($q) use($id){
            
            $q->where('client_id', $id);
        
        })->get();
    }
}