<?php

namespace App\Enum;

enum UserRoleType: string
{
    case MASTER = 'master';
    case COMPANY_ADMIN = 'companyAdmin';
    case STUDENT = 'student';
}
