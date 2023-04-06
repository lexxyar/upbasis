<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class ModuleFolderExistException extends Exception
{
    public function __construct(string $path = '')
    {
        parent::__construct("Locale class [$path] not found");
    }
}
