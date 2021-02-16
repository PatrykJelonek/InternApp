<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    const PERMISSION_VIEW_STUDENTS = 'view_students';

    const PERMISSIONS = [
        self::PERMISSION_VIEW_STUDENTS
    ];

    const PERMISSIONS_DISPLAY_NAMES = [
        self::PERMISSION_VIEW_STUDENTS => 'Wyświetl studentów',
    ];

    const PERMISSIONS_DESCRIPTIONS = [
        self::PERMISSION_VIEW_STUDENTS => 'Użytkownik może wyświetlać listę studentów.',
    ];

    protected $table = 'permissions';
    protected $fillable = ['name'];
}
