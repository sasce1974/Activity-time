<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'time_spent',
    ];
}
