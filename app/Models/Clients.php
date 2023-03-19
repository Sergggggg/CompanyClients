<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [

        'client',
    
    ];

    public function companies()
    {
        return $this->belongsToMany(Companies::class, 'client_companies', 'client_id', 'company_id');
    }
}
