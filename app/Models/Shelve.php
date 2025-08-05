<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelve extends Model
{
    /** @use HasFactory<\Database\Factories\ShelveFactory> */
    use HasFactory;

    use SoftDeletes;

    protected array $dates = ['deleted_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
    ];
}
