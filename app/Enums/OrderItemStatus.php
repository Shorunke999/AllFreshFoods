<?php

namespace App\Enums;

enum OrderItemStatus: string
{
    case PENDING = 'pending';
    case FULFILLED = 'fulfilled';
}
