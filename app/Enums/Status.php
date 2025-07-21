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
    case UNPUBLISHED = 8; // 1
    case NO_ASSOCIATION = 9; // 0
    case PUBLISHED = 10; // 2
}
