<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class LocalekeyClassNotFoundException extends Exception
{
    public function __construct(string $className = '')
    {
        parent::__construct("Localekey class [$className] not found");
    }
}
