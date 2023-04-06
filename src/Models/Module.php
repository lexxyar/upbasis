<?php

namespace Lexxsoft\Upbasis\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Lexxsoft\Upbasis\Exceptions\ModuleNameIsEmptyException;
use Lexxsoft\Upbasis\Exceptions\ModuleNotFoundException;
use Lexxsoft\Upbasis\Support\Traits\HasModuleFactory;

/**
 * @method static firstOrCreate(string[] $array, array $array1)
 * @method static where(string $string, string $moduleName)
 * @property mixed $version
 * @property mixed $name
 */
class Module extends Model
{
    use HasModuleFactory;

    protected $fillable = ['name', 'enabled'];

    protected $hidden = [
        'providers', 'files', 'migration', 'priority'
    ];

    protected bool $metaLoaded = false;

    private function basePath(): string
    {
        $tmpPath = Storage::path('');
        $aParts = explode(DIRECTORY_SEPARATOR, $tmpPath);
        $index = array_search('storage', $aParts);
        $aParts = array_slice($aParts, 0, $index);
        return implode(DIRECTORY_SEPARATOR, $aParts);
    }

    /**
     * @throws ModuleNameIsEmptyException
     * @throws ModuleNotFoundException
     */
    public function loadMeta(): void
    {
        if (empty($this->name)) {
            throw new ModuleNameIsEmptyException();
        }

        $filePath = $this->basePath()
            . DIRECTORY_SEPARATOR . 'Modules'
            . DIRECTORY_SEPARATOR . $this->name
            . DIRECTORY_SEPARATOR . 'module.json';

        if (!file_exists($filePath)) {
            throw new ModuleNotFoundException($this->name);
        }

        $data = json_decode(file_get_contents($filePath));
        foreach ($data as $key => $line) {
            $this->$key = $line;
        }

        $this->metaLoaded = true;
    }

    protected function enabled(): Attribute
    {
        return new Attribute(
            get: fn($value) => boolval($value),
            set: fn($value) => intval($value)
        );
    }

    public function enable()
    {
        $activatorName = config('modules.activator');
        $activatorClass = config('modules.activators.' . $activatorName . '.class');
        $activator = new $activatorClass(app());
//        $activator = new DatabaseModuleActivator();
        $activator->setActiveByName($this->name, true);
    }

    public function disable()
    {
        $activatorName = config('modules.activator');
        $activatorClass = config('modules.activators.' . $activatorName . '.class');
        $activator = new $activatorClass(app());
//        $activator = new DatabaseModuleActivator();
        $activator->setActiveByName($this->name, false);
    }
}
