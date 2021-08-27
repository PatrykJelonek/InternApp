<?php

namespace App\Constants;

class RoleConstants
{
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_COMPANY_WORKER = 'company_worker';
    public const ROLE_COMPANY_OWNER = 'company_owner';
    public const ROLE_UNIVERSITY_WORKER = 'university_worker';
    public const ROLE_UNIVERSITY_OWNER = 'university_owner';
    public const ROLE_UNIVERSITY_DEANERY_WORKER = 'deanery_worker';
    public const ROLE_INTERN = 'intern';
    public const ROLE_STUDENT = 'student';
    public const ROLE_UNIVERSITY_SUPERVISOR = 'university_supervisor';
    public const ROLE_COMPANY_SUPERVISOR = 'company_supervisor';

    public const ROLE_GROUP_UNIVERSITY = 'university';
    public const ROLE_GROUP_COMPANY = 'company';
    public const ROLE_GROUP_OTHER = 'other';
    public const ROLE_GROUP_ADMIN = 'admin';

    public const ROLE_GROUPS = [
        self::ROLE_GROUP_UNIVERSITY,
        self::ROLE_GROUP_COMPANY,
        self::ROLE_GROUP_OTHER,
        self::ROLE_GROUP_ADMIN,
    ];

    public const BASIC_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_STUDENT,
        self::ROLE_UNIVERSITY_WORKER,
        self::ROLE_UNIVERSITY_OWNER,
        self::ROLE_UNIVERSITY_DEANERY_WORKER,
        self::ROLE_COMPANY_WORKER,
        self::ROLE_COMPANY_OWNER,
        self::ROLE_INTERN,
        self::ROLE_USER,
        self::ROLE_UNIVERSITY_SUPERVISOR,
        self::ROLE_COMPANY_SUPERVISOR,
    ];

    public const BASIC_ROLE_USER_TYPES = [
        self::ROLE_USER => 'User type: ' . self::ROLE_USER,
        self::ROLE_ADMIN => 'User type: ' . self::ROLE_ADMIN,
        self::ROLE_COMPANY_WORKER => 'User type: ' . self::ROLE_COMPANY_WORKER,
        self::ROLE_COMPANY_OWNER => 'User type: ' . self::ROLE_COMPANY_OWNER,
        self::ROLE_UNIVERSITY_WORKER => 'User type: ' . self::ROLE_UNIVERSITY_WORKER,
        self::ROLE_UNIVERSITY_OWNER => 'User type: ' . self::ROLE_UNIVERSITY_OWNER,
        self::ROLE_UNIVERSITY_DEANERY_WORKER => 'User type: ' . self::ROLE_UNIVERSITY_DEANERY_WORKER,
        self::ROLE_INTERN => 'User type: ' . self::ROLE_INTERN,
        self::ROLE_STUDENT => 'User type: ' . self::ROLE_STUDENT,
        self::ROLE_UNIVERSITY_SUPERVISOR => 'User type: ' . self::ROLE_UNIVERSITY_SUPERVISOR,
        self::ROLE_COMPANY_SUPERVISOR => 'User type: ' . self::ROLE_COMPANY_SUPERVISOR,
    ];

    public const BASIC_ROLE_DISPLAY_NAMES = [
        self::ROLE_USER => 'Użytkownik',
        self::ROLE_ADMIN => 'Administrator',
        self::ROLE_COMPANY_WORKER => 'Pracownik firmy',
        self::ROLE_COMPANY_OWNER => 'Właściciel firmy',
        self::ROLE_UNIVERSITY_WORKER => 'Pracownik uczelni',
        self::ROLE_UNIVERSITY_OWNER => 'Właściciel uczelni',
        self::ROLE_UNIVERSITY_DEANERY_WORKER => 'Pracownik dziekanatu',
        self::ROLE_INTERN => 'Praktykant/Stażysta',
        self::ROLE_STUDENT => 'Student',
        self::ROLE_UNIVERSITY_SUPERVISOR => 'Opiekun praktykanta z uczelni',
        self::ROLE_COMPANY_SUPERVISOR => 'Opiekun praktykanta z firmy',
    ];

    public const BASIC_ROLE_DESCRIPTIONS = [
        self::ROLE_USER => 'Podstawowy użytkownik',
        self::ROLE_ADMIN => 'Administrator serwisu',
        self::ROLE_COMPANY_WORKER => 'Pracownik firmy',
        self::ROLE_COMPANY_OWNER => 'Właściciel firmy',
        self::ROLE_UNIVERSITY_WORKER => 'Pracownik uczelni',
        self::ROLE_UNIVERSITY_OWNER => 'Właściciel uczelni',
        self::ROLE_UNIVERSITY_DEANERY_WORKER => 'Pracownik dziekanatu',
        self::ROLE_INTERN => 'Praktykant/Stażysta',
        self::ROLE_STUDENT => 'Student',
        self::ROLE_UNIVERSITY_SUPERVISOR => 'Opiekun praktykanta z uczelni',
        self::ROLE_COMPANY_SUPERVISOR => 'Opiekun praktykanta z firmy',
    ];

    public const BASIC_ROLE_GROUP = [
        self::ROLE_USER => self::ROLE_GROUP_OTHER,
        self::ROLE_ADMIN => self::ROLE_GROUP_ADMIN,
        self::ROLE_COMPANY_WORKER => self::ROLE_GROUP_COMPANY,
        self::ROLE_COMPANY_OWNER => self::ROLE_GROUP_COMPANY,
        self::ROLE_UNIVERSITY_WORKER => self::ROLE_GROUP_UNIVERSITY,
        self::ROLE_UNIVERSITY_OWNER => self::ROLE_GROUP_UNIVERSITY,
        self::ROLE_UNIVERSITY_DEANERY_WORKER => self::ROLE_GROUP_UNIVERSITY,
        self::ROLE_INTERN => self::ROLE_GROUP_OTHER,
        self::ROLE_STUDENT => self::ROLE_GROUP_OTHER,
        self::ROLE_UNIVERSITY_SUPERVISOR => self::ROLE_GROUP_UNIVERSITY,
        self::ROLE_COMPANY_SUPERVISOR => self::ROLE_GROUP_COMPANY,
    ];
}
