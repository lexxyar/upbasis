<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class ModuleNameIsEmptyException extends Exception
{
    protected $message = 'Module name is empty';
}
