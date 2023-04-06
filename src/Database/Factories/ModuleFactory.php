<?php

namespace Lexxsoft\Upbasis\Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Lexxsoft\Upbasis\Models\Module;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Module>
 */
class ModuleFactory extends Factory
{
    protected $model = Module::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(8),
            'enabled' => random_int(1, 255) % 7 == 0
        ];
    }
}
