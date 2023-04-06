<?php

namespace Lexxsoft\Upbasis\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Lexxsoft\Upbasis\Support\ModuleExtractor;
use Lexxsoft\Upbasis\Support\Traits\ConsoleOutputTrait;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Extract extends Command
{
    use ConsoleOutputTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'up:extract {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Collect module files and data and put them in ZIP archive";

    public function handle(): int
    {
        $time_start = microtime(true);

        $moduleName = $this->argument('module');

        // Check module name is provided
        if (!$moduleName) {
            $this->components->error('Module name is required');
            return CommandAlias::FAILURE;
        }

        try {
            $path = ModuleExtractor::export($moduleName);
        } catch (Exception $e) {
            $this->components->error($e->getMessage());
            return CommandAlias::FAILURE;
        }

        $this->components->info("Create package file: $path");

        $time_end = microtime(true);

        // execution time in seconds
        $execution_time = $time_end - $time_start;
        $this->components->info('Executed in ' . number_format((float)$execution_time, 2, '.', '') . ' seconds');

        return CommandAlias::SUCCESS;
    }
}
