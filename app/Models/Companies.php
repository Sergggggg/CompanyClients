<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

        protected $fillable = [
        
        'company',
        'user_id',

    ];

    public function clients()
    {
        return $this->belongsToMany(Clients::class, 'client_companies', 'company_id', 'client_id');
    }
}
