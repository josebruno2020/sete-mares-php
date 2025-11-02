<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message'
    ];

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => preg_replace('/\D/', '', $value),
        );
    }
}
