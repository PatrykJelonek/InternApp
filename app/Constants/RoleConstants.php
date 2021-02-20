<?php

namespace App\Constants;

class RoleConstants
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
        self::ROLE_ADMIN,
        self::ROLE_STUDENT,
        self::ROLE_UNIVERSITY_WORKER,
        self::ROLE_UNIVERSITY_OWNER,
        self::ROLE_DEANERY_WORKER,
        self::ROLE_COMPANY_WORKER,
        self::ROLE_COMPANY_OWNER,
        self::ROLE_INTERN,
        self::ROLE_USER,
    ];

    const BASIC_ROLE_USER_TYPES = [
        self::ROLE_USER => 'User type: ' . self::ROLE_USER,
        self::ROLE_ADMIN => 'User type: ' . self::ROLE_ADMIN,
        self::ROLE_COMPANY_WORKER => 'User type: ' . self::ROLE_COMPANY_WORKER,
        self::ROLE_COMPANY_OWNER => 'User type: ' . self::ROLE_COMPANY_OWNER,
        self::ROLE_UNIVERSITY_WORKER => 'User type: ' . self::ROLE_UNIVERSITY_WORKER,
        self::ROLE_UNIVERSITY_OWNER => 'User type: ' . self::ROLE_UNIVERSITY_OWNER,
        self::ROLE_DEANERY_WORKER => 'User type: ' . self::ROLE_DEANERY_WORKER,
        self::ROLE_INTERN => 'User type: ' . self::ROLE_INTERN,
        self::ROLE_STUDENT => 'User type: ' . self::ROLE_STUDENT,
    ];

    const BASIC_ROLE_DISPLAY_NAMES = [
        self::ROLE_USER => 'Użytkownik',
        self::ROLE_ADMIN => 'Administrator',
        self::ROLE_COMPANY_WORKER => 'Pracownik Firmy',
        self::ROLE_COMPANY_OWNER => 'Właściciel Firmy',
        self::ROLE_UNIVERSITY_WORKER => 'Pracownik Uczelni',
        self::ROLE_UNIVERSITY_OWNER => 'Właściciel Uczelni',
        self::ROLE_DEANERY_WORKER => 'Pracownik Dziekanatu',
        self::ROLE_INTERN => 'Praktykant/Stażysta',
        self::ROLE_STUDENT => 'Student',
    ];

    const BASIC_ROLE_DESCRIPTIONS = [
        self::ROLE_USER => 'Podstawowy użytkownik',
        self::ROLE_ADMIN => 'Administrator serwisu',
        self::ROLE_COMPANY_WORKER => 'Pracownik firmy',
        self::ROLE_COMPANY_OWNER => 'Właściciel firmy',
        self::ROLE_UNIVERSITY_WORKER => 'Pracownik uczelni',
        self::ROLE_UNIVERSITY_OWNER => 'Właściciel uczelni',
        self::ROLE_DEANERY_WORKER => 'Pracownik dziekanatu',
        self::ROLE_INTERN => 'Praktykant/Stażysta',
        self::ROLE_STUDENT => 'Student',
    ];
}
