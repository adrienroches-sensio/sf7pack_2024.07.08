<?php

declare(strict_types=1);

namespace App\Security;

enum Permission
{
    public const EDIT_PROJECT = 'EDIT_PROJECT';
    public const EDIT_EVENT = 'EDIT_EVENT';
}
