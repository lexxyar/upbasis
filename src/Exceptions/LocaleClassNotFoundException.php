<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class LocaleClassNotFoundException extends Exception
{
    public function __construct(string $className = '')
    {
        parent::__construct("Locale class [$className] not found");
    }
}
