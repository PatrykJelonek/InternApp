<?php

namespace Config\Constants;

class PermissionConstants
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
}
