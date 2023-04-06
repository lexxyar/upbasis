<?php

namespace Lexxsoft\Upbasis\Support;

use Illuminate\Database\Eloquent\Collection;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Nwidart\Modules\Module;

class DatabaseModuleActivator implements ActivatorInterface
{
    private mixed $cacheKey;
    private mixed $cacheLifetime;

    public function __construct()
    {
        $this->cacheKey = config('modules.activators.up_database.cache-key');
        $this->cacheLifetime = config('modules.activators.up_database.cache-lifetime');
    }

    public function enable(Module $module): void
    {
        $this->setActiveByName($module->getName(), true);
    }

    public function disable(Module $module): void
    {
        $this->setActiveByName($module->getName(), false);
    }

    public function hasStatus(Module $module, bool $status): bool
    {
        $this->fillCache();

        /** @var Collection $moduleCollection */
        $moduleCollection = cache($this->cacheKey);

        $dbModule = $moduleCollection->where('name', $module->getName())
            ->first();
        if ($dbModule) {
            return $dbModule->enabled;
        }

        return false;
    }

    public function setActive(Module $module, bool $active): void
    {
        $this->setActiveByName($module->getName(), $active);
    }

    public function setActiveByName(string $name, bool $active): void
    {
        $dbModul = \Lexxsoft\Upbasis\Models\Module::where('name', $name)->first();
        if (!$dbModul) {
            \Lexxsoft\Upbasis\Models\Module::factory()->create(['name' => $name, 'enabled' => $active]);
        } else {
            $dbModul->enabled = $active;
            $dbModul->save();
        }

        $this->flushCache();
        $this->fillCache();

    }

    public function delete(Module $module): void
    {
        $this->disable($module);
    }

    public function reset(): void
    {
        \Lexxsoft\Upbasis\Models\Module::query()->update(['enabled' => false]);

        $this->flushCache();
        $this->fillCache();
    }

    /**
     * Flushes the modules activation statuses cache
     */
    private function flushCache(): void
    {
        cache()->forget($this->cacheKey);
    }

    private function fillCache(): void
    {
        cache()->remember($this->cacheKey, $this->cacheLifetime, function () {
            return \Lexxsoft\Upbasis\Models\Module::all();
        });
    }
}
