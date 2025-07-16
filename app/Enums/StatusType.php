<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusType: int
{
    case USERS = 1;
    case ORDERS = 2;
    case DIGITAL_COLLECTION = 3;
}
