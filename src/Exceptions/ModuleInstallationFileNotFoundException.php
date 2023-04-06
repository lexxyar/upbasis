<?php

namespace Lexxsoft\Upbasis\Exceptions;

use Exception;

class ModuleInstallationFileNotFoundException extends Exception
{
    protected $message = 'Installation file not found';
}
