<?php

namespace Lexxsoft\Upbasis\Support\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait HasModuleFactory
{
    use HasFactory;

    protected static string $moduleFactoryNamespace = '\\Modules\\<MODULE_NAME>\\Database\\Factories\\';

    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        $modelClass = get_called_class();
        $parts = explode("\\", $modelClass);
        $module_name = $parts[1];
        $sNamespace = str_replace('<MODULE_NAME>', $module_name, static::$moduleFactoryNamespace);
        $modelName = array_pop($parts);

        /** @var \Illuminate\Database\Eloquent\Factories\Factory $class */
        $class = $sNamespace . $modelName . 'Factory';

        return $class::new();
    }
}
