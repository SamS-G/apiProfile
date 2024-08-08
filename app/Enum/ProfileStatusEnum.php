<?php
    declare(strict_types=1);

    namespace App\Enum;

    enum ProfileStatusEnum: string
    {
        case Active = 'active';
        case Inactive = 'inactive';
        case Deleted = 'deleted';
        case Pending = 'pending';
    }
