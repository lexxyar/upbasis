<?php

namespace Lexxsoft\Upbasis\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Lexxsoft\Upbasis\Support\Stub;
use Lexxsoft\Upbasis\Support\Traits\ConsoleOutputTrait;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Process\Process;

class Init extends Command
{
    use ConsoleOutputTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'up:init {--F|no-code-modification} {--C|no-composer-modification} {--I|no-package-install}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Universal Platform initialization.
    This command ";

    private bool $noCodeModification;
    private bool $noComposerModification;
    private bool $noPackageInstall;

    public function handle(): int
    {
        $this->noCodeModification = boolval($this->option('no-code-modification'));
        $this->noComposerModification = boolval($this->option('no-composer-modification'));
        $this->noPackageInstall = boolval($this->option('no-package-install'));

        // Installation process...
        $this->newLine();
        $this->components->twoColumnDetail('<fg=gray>Epoch</>', '<fg=gray>Status</>');

        // Install packages
        if ($this->noPackageInstall) {
            $this->process('Package installation');
            $this->processSkip();
        } else {
            $requiredPackages = [
                'laravel/sanctum' => "Laravel\Sanctum\SanctumServiceProvider",
                'nwidart/laravel-modules' => "Nwidart\Modules\LaravelModulesServiceProvider",
                'spatie/laravel-permission' => "Spatie\Permission\PermissionServiceProvider",
            ];
            foreach ($requiredPackages as $packageName => $publishCommand) {
                $this->msg = $packageName;
                $this->process("Require package:");
                if (!File::exists(base_path('vendor' . DIRECTORY_SEPARATOR . $packageName))) {
                    $this->processInstalling();

                    $composerCommand = "composer require $packageName";
                    $composerRoot = base_path();
                    $process = new Process(['cd', $composerRoot]);
                    $process->mustRun();
                    exec($composerCommand . ' 2>&1', $msg, $res);

                    if ($res != 0) {
                        $this->processFail();
                        $this->output->text($msg);
                        return CommandAlias::FAILURE;
                    }

                    if (!!$publishCommand) {
                        $res = Artisan::call('vendor:publish', ['--provider' => $publishCommand]);

                        exec("php artisan vendor:publish --provider=\"$publishCommand\" 2>&1", $msg, $res);
                        if ($res != 0) {
                            $this->processFail();
                            $this->output->error($msg);
                        }
                    }

                }
                $this->processDone();
            }
        }

        // Create Modules folder
        $folderName = 'Modules';
        $this->msg = $folderName;
        $this->process("Create folder:");
        if (!File::exists(base_path($folderName))) {
            File::makeDirectory(base_path($folderName));
        }
        $this->processDone();


        // Modify composer.json
        $this->process("Modify composer.json:");
        if ($this->noComposerModification) {
            $this->processSkip();
        } else {
            $composerFile = base_path('composer.json');
            $composerFileBackup = base_path('composer.json.bak');
            $c = File::json($composerFile);
            File::put($composerFileBackup, json_encode($c, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $composerValues = [
                'autoload.psr-4.Modules\\' => "Modules/"
            ];
            $has = ['done' => false, 'skip' => false];
            foreach ($composerValues as $composerPath => $composerValue) {
                if (!Arr::has($c, $composerPath)) {
                    Arr::set($c, $composerPath, $composerValue);
                    $has['done'] = true;
                } else {
                    $has['skip'] = true;
                }
            }
            if ($has['done'] && $has['skip']) {
                File::put($composerFile, json_encode($c, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                $this->processPartial();
            } elseif ($has['done'] && !$has['skip']) {
                File::put($composerFile, json_encode($c, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                $this->processDone();
            } else {
                $this->processDone();
            }
        }


        // Code modification
        if ($this->noCodeModification) {
            $this->process("Code modification");
            $this->processSkip();
        } else {
            $codeStubs = [
                'app/Providers/AuthServiceProvider.php' => '/AuthServiceProvider.stub',
                'app/Http/Kernel.php' => '/Kernel.stub',
                'routes/web.php' => '/Routes.web.stub',
                'config/cors.php' => '/ConfigCors.stub',
                'vite.config.js' => '/vite.config.stub',
            ];
            foreach ($codeStubs as $filepath => $fileStub) {
                $this->msg = $filepath;
                $this->process("Code modification:");

                $authServiceProviderFile = base_path($filepath);
                $code = (new Stub($fileStub))->render();
                File::put($authServiceProviderFile, $code);
                $this->processDone();
            }
        }

        // Copy files
        $copyFolders = [
            'resources',
        ];
        foreach ($copyFolders as $folderPath) {
            $this->msg = $folderPath;
            $this->process("Copy to:");

            $path = __DIR__ . '/../../Storage/Files/' . $folderPath;
            File::copyDirectory($path, base_path($folderPath));

            $this->processDone();
        }

        // Modify package.json
        $this->process("Modify package.json:");
        $packageFile = base_path('package.json');
        $packageFileBackup = base_path('package.json.bak');
        $c = File::json($packageFile);
        File::put($packageFileBackup, json_encode($c, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $packageValues = [
            "devDependencies.@esbuild-plugins/node-globals-polyfill" => "^0.2.3",
            "devDependencies.@types/node" => "^18.11.2",
            "devDependencies.@vitejs/plugin-vue" => "^3.0.3",
            "devDependencies.postcss" => "^8.1.14",
            "devDependencies.sass" => "^1.59.2",
            "devDependencies.typescript" => "^4.9.5",
            "devDependencies.vue-tsc" => "^1.0.8",
            "dependencies.@casl/ability" => "^6.3.1",
            "dependencies.@casl/vue" => "^2.2.0",
            "dependencies.@ckeditor/ckeditor5-build-classic" => "^36.0.1",
            "dependencies.@ckeditor/ckeditor5-vue" => "^4.0.1",
            "dependencies.@fortawesome/fontawesome-svg-core" => "^6.2.0",
            "dependencies.@fortawesome/free-brands-svg-icons" => "^6.2.0",
            "dependencies.@fortawesome/free-regular-svg-icons" => "^6.2.0",
            "dependencies.@fortawesome/free-solid-svg-icons" => "^6.2.0",
            "dependencies.@fortawesome/vue-fontawesome" => "^3.0.1",
            "dependencies.js-base64" => "^3.7.5",
            "dependencies.js-cookie" => "^3.0.1",
            "dependencies.lexx-odata-query-builder" => "^1.5.0",
            "dependencies.pinia" => "^2.0.23",
            "dependencies.vue" => "^3.2.37",
            "dependencies.vue-i18n" => "^9.2.2",
            "dependencies.vue-router" => "^4.1.5",
        ];
        foreach ($packageValues as $packagePath => $packageValue) {
            if (!Arr::has($c, $packagePath)) {
                Arr::set($c, $packagePath, $packageValue);
            }
        }
        File::put($composerFile, json_encode($c, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->processDone();


        // Migrate database

        return CommandAlias::SUCCESS;
    }
}
