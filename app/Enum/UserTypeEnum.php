<?php
    declare(strict_types=1);

    namespace App\Enum;

    enum UserTypeEnum: int
    {
        case user = 1;
        case admin = 2;
    }
