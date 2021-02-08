<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_COMPANY_WORKER = 'company_worker';
    const ROLE_COMPANY_OWNER = 'company_owner';
    const ROLE_UNIVERSITY_WORKER = 'university_worker';
    const ROLE_UNIVERSITY_OWNER = 'university_owner';
    const ROLE_DEANERY_WORKER = 'deanery_worker';
    const ROLE_INTERN = 'intern';
    const ROLE_STUDENT = 'student';

    const BASIC_ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
        self::ROLE_COMPANY_WORKER,
        self::ROLE_COMPANY_OWNER,
        self::ROLE_UNIVERSITY_WORKER,
        self::ROLE_UNIVERSITY_OWNER,
        self::ROLE_DEANERY_WORKER,
        self::ROLE_INTERN,
        self::ROLE_STUDENT,
    ];

    protected $table = 'roles';
    protected $fillable = ['name', 'display_name', 'description'];
}
