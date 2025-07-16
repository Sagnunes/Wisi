<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DigitalObject extends Model
{
    public $timestamps = false;

    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
