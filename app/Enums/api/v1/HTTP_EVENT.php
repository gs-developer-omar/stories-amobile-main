<?php

namespace App\Enums\api\v1;

enum HTTP_EVENT: string
{
    case UNCHANGED = 'UNCHANGED';
    case CREATED = 'CREATED';
    case UPDATED = 'UPDATED';
    case DELETED = 'DELETED';
}
