<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: int
{
    case NO_ASSOCIATION = 8;
    case UNPUBLISHED = 9;
    case PUBLISHED = 10;
}
