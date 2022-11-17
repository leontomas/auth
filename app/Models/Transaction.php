<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 
        'type', 
        'note',
        'user_id',
        'wallet_id'
    ];

    public function user(){
        return $this->belongsto(User::class);
    }

    public function wallet(){
        return $this->belongsto(Wallet::class);
    }
}
