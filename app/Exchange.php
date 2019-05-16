<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = [
        'exchange_name',
        'type',
        'last_seen',
        'is_ignored',
    ];
}
