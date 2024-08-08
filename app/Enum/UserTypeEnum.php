<?php
    declare(strict_types=1);

    namespace App\Enum;

    enum UserTypeEnum: string
    {
        case User = 'user';
        case Admin = 'admin;';
    }
