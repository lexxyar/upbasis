<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class DatabaseMigrationException extends Exception
{
    public function __construct(string $moduleName = '')
    {
        parent::__construct("Database migration for module [$moduleName] failed");
    }
}
