<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class ModuleNameIsNotSetException extends Exception
{
    protected $message = 'Module name is not set';
}
