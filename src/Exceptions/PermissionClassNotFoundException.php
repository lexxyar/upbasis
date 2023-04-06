<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class PermissionClassNotFoundException extends Exception
{
    public function __construct(string $className = '')
    {
        parent::__construct("Permission class [$className] not found");
    }
}
