<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Fund extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function digitalObjects(): HasMany
    {
        return $this->hasMany(DigitalObject::class);
    }
}
