<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: int
{
    // Authentication
    case PENDING = 1;
    case ACTIVE = 2;
    case BLOCKED = 3;

    // Digital Collection
    case NO_ASSOCIATION = 8;
    case UNPUBLISHED = 9;
    case PUBLISHED = 10;
}
