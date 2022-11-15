<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'money',
        'user_id'
    ];

    public function company(){
        return $this->belongsto(Company::class);
    }
}
