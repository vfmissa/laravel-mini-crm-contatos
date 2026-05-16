<?php

namespace App\Domain\Contact\Enums;

enum ContactStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case ACTIVE = 'active';
    case FAILED = 'failed';
}