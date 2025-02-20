<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encrypt extends Model
{
    use HasFactory;
    protected $fillable = [
        'userDocument',
        'documentSalt',
        'creditCardToken',
        'tokenSalt',
        'value',
    ];

}
