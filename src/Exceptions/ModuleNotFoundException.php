<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class ModuleNotFoundException extends Exception
{
    public function __construct(string $sModuleName = "")
    {
        parent::__construct("Module $sModuleName not found");
    }
}
