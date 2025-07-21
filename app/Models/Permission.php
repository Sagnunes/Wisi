<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Permission extends Model
{
    /** @use HasFactory<\Database\Factories\PermissionFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
