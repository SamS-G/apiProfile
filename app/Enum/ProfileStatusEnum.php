<?php
    declare(strict_types=1);

    namespace App\Enum;

    enum ProfileStatusEnum: int
    {
        case active = 1;
        case inactive = 2;
        case deleted = 3;
        case pending = 4;
    }
