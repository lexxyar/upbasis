<?php

namespace Lexxsoft\Upbasis\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Lexxsoft\Upbasis\Support\Stub;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'up:generate {model} {module} {--vers=V1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate platform files in module [module], based on [model]
    Files will be generate:
    * Resource files
    * Request files
    * Controller with default API methods
    * Factory template
    * Seeder template
    Fill `\$fillable` attribute in [model] to get more relevant result";

    private string $moduleName;
    private string $modelName;
    private mixed $oModel;
    private string $version;
    private string $modulePath;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->moduleName = $this->argument('module');
        $this->modelName = $this->argument('model');
        $this->version = $this->option('vers');

        $modelClassName = 'Modules\\' . $this->moduleName . '\\Models\\' . $this->modelName;
        try {
            $this->oModel = new $modelClassName;
        } catch (Exception $ex) {
            $this->alert('Model ' . $modelClassName . ' is undefined');
            return CommandAlias::FAILURE;
        }

        $this->modulePath = base_path('Modules/' . $this->moduleName);

        $this->generateResource();
        $this->generateRequest();
        $this->generateController();
        $this->generateFactory();
        $this->generateSeeder();

        return CommandAlias::SUCCESS;
    }

    private function generateSeeder()
    {
        $seederPath = $this->modulePath . '/Database/Seeders';
        $seederNamespace = 'Modules\\' . $this->moduleName . '\\Database\\Seeders';

        if (!file_exists($seederPath)) {
            mkdir($seederPath);
            $this->info('Created folder ' . str_replace(base_path(), '', $seederPath));
        }

        $seederFilePath = $seederPath . '/' . $this->modelName . 'Seeder.php';

        if (file_exists($seederFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $seederFilePath) . '?')) {
                $this->error('Passed');
                return;
            }
        }

        $str = (new Stub('/Seeder.stub', [
            'NAMESPACE' => $seederNamespace,
            'MODULE_NAME' => $this->moduleName,
            'MODEL_NAME' => $this->modelName,
        ]))->render();
        file_put_contents($seederFilePath, $str);
    }

    private function generateFactory()
    {
        $factoryPath = $this->modulePath . '/Database/Factories';
        $factoryNamespace = 'Modules\\' . $this->moduleName . '\\Database\\Factories';

        if (!file_exists($factoryPath)) {
            mkdir($factoryPath);
            $this->info('Created folder ' . str_replace(base_path(), '', $factoryPath));
        }

        $factoryFilePath = $factoryPath . '/' . $this->modelName . 'Factory.php';

        if (file_exists($factoryFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $factoryFilePath) . '?')) {
                $this->error('Passed');
                return;
            }
        }

        $str = [];
        foreach ($this->oModel->getFillable() as $item) {
            $str[] = "\t\t\t'$item' => fake()->text(),";
        }

        $str = (new Stub('/Factory.stub', [
            'NAMESPACE' => $factoryNamespace,
            'MODULE_NAME' => $this->moduleName,
            'MODEL_NAME' => $this->modelName,
            'LOOP_FIELDS' => implode("\n", $str),
        ]))->render();
        file_put_contents($factoryFilePath, $str);
    }

    private function generateController()
    {
        $controllerPath = $this->modulePath . '/Http/Controllers/Api/' . $this->version;
        $controllerNamespace = 'Modules\\' . $this->moduleName . '\\Http\\Controllers\\Api\\' . $this->version;

        // Controllers api folder
        $pathPart = $this->modulePath . '/Http/Controllers';
        if (!file_exists($pathPart)) {
            mkdir($pathPart);
            $this->info('Created folder ' . str_replace(base_path(), '', $pathPart));
        }
        $pathPart = $this->modulePath . '/Http/Controllers/Api';
        if (!file_exists($pathPart)) {
            mkdir($pathPart);
            $this->info('Created folder ' . str_replace(base_path(), '', $pathPart));
        }

        if (!file_exists($controllerPath)) {
            mkdir($controllerPath);
            $this->info('Created folder ' . str_replace(base_path(), '', $controllerPath));
        }

        // CreateRequest file
        $controllerFilePath = $controllerPath . '/' . $this->modelName . 'Controller.php';

        if (file_exists($controllerFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $controllerFilePath) . '?')) {
                $this->error('Passed');
                return;
            }
        }

        $str = (new Stub('/Controller.stub', [
            'NAMESPACE' => $controllerNamespace,
            'MODULE_NAME' => $this->moduleName,
            'MODEL_NAME' => $this->modelName,
            'MODEL_NAME_LOWERCASE' => strtolower($this->modelName),
            'VERSION' => $this->version,
        ]))->render();
        file_put_contents($controllerFilePath, $str);
    }

    private function generateRequest()
    {
        $requestPath = $this->modulePath . '/Http/Requests/' . $this->version . '/' . $this->modelName;
        $requestNamespace = 'Modules\\' . $this->moduleName . '\\Http\\Requests\\' . $this->version . '\\' . $this->modelName;

        /** Requests folder */
        $pathPart = $this->modulePath . '/Http/Requests';
        if (!file_exists($pathPart)) {
            mkdir($pathPart);
            $this->info('Created folder ' . str_replace(base_path(), '', $pathPart));
        }
        $pathPart = $this->modulePath . '/Http/Requests/' . $this->version;
        if (!file_exists($pathPart)) {
            mkdir($pathPart);
            $this->info('Created folder ' . str_replace(base_path(), '', $pathPart));
        }

        if (!file_exists($requestPath)) {
            mkdir($requestPath);
        }

        /** CreateRequest file */
        $createRequestFilePath = $requestPath . '/Create' . $this->modelName . 'Request.php';

        $bOverwrite = true;
        if (file_exists($createRequestFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $createRequestFilePath) . '?')) {
                $bOverwrite = false;
                $this->error('Passed');
            }
        }

        if ($bOverwrite) {
            $str = (new Stub('/CreateRequest.stub', [
                'NAMESPACE' => $requestNamespace,
                'MODULE_NAME' => $this->moduleName,
                'MODEL_NAME' => $this->modelName,
                'MODEL_NAME_LOWERCASE' => strtolower($this->modelName),
                'VERSION' => $this->version,
            ]))->render();
            file_put_contents($createRequestFilePath, $str);
        }

        // UpdateRequest file
        $updateRequestFilePath = $requestPath . '/Update' . $this->modelName . 'Request.php';

        $bOverwrite = true;
        if (file_exists($updateRequestFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $updateRequestFilePath) . '?')) {
                $bOverwrite = false;
                $this->error('Passed');
            }
        }

        if ($bOverwrite) {
            $str = (new Stub('/UpdateRequest.stub', [
                'NAMESPACE' => $requestNamespace,
                'MODULE_NAME' => $this->moduleName,
                'MODEL_NAME' => $this->modelName,
                'MODEL_NAME_LOWERCASE' => strtolower($this->modelName),
                'VERSION' => $this->version,
            ]))->render();
            file_put_contents($updateRequestFilePath, $str);
        }

        // DefaultRulesRequest file
        $defaultRulesRequestFilePath = $requestPath . '/DefaultRules' . $this->modelName . 'Request.php';

        $bOverwrite = true;
        if (file_exists($defaultRulesRequestFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $defaultRulesRequestFilePath) . '?')) {
                $bOverwrite = false;
                $this->error('Passed');
            }
        }

        if ($bOverwrite) {
            $str = [];
            foreach ($this->oModel->getFillable() as $item) {
                $str[] = "\t\t\t'$item' => ['required', 'string', 'max:255'],";
            }

            $str = (new Stub('/DefaultRulesRequest.stub', [
                'NAMESPACE' => $requestNamespace,
                'MODEL_NAME' => $this->modelName,
                'LOOP_FIELDS' => implode("\n", $str)
            ]))->render();
            file_put_contents($defaultRulesRequestFilePath, $str);
        }

    }

    private function generateResource()
    {
        $resourcesPath = $this->modulePath . '/Http/Resources/' . $this->version . '/' . $this->modelName;
        $resourcesNamespace = 'Modules\\' . $this->moduleName . '\\Http\\Resources\\' . $this->version . '\\' . $this->modelName;

        // Resource folder
        $pathPart = $this->modulePath . '/Http/Resources';
        if (!file_exists($pathPart)) {
            mkdir($pathPart);
            $this->info('Created folder ' . str_replace(base_path(), '', $pathPart));
        }
        $pathPart = $this->modulePath . '/Http/Resources/' . $this->version;
        if (!file_exists($pathPart)) {
            mkdir($pathPart);
            $this->info('Created folder ' . str_replace(base_path(), '', $pathPart));
        }
        if (!file_exists($resourcesPath)) {
            mkdir($resourcesPath);
        }

        // Resource file
        $resourceFilePath = $resourcesPath . '/' . $this->modelName . 'Resource.php';

        $bOverwrite = true;
        if (file_exists($resourceFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $resourceFilePath) . '?')) {
                $bOverwrite = false;
                $this->error('Passed');
            }
        }

        if ($bOverwrite) {
            $str = [];
            foreach ($this->oModel->getFillable() as $item) {
                $str[] = "\t\t\t'$item' => \$this->$item,";
            }

            $str = (new Stub('/Resource.stub', [
                'NAMESPACE' => $resourcesNamespace,
                'MODEL_NAME' => $this->modelName,
                'LOOP_FIELDS' => implode("\n", $str)
            ]))->render();
            file_put_contents($resourceFilePath, $str);
        }

        // Collection file
        $resourceCollectionFilePath = $resourcesPath . '/' . $this->modelName . 'Collection.php';

        $bOverwrite = true;
        if (file_exists($resourceCollectionFilePath)) {
            if (!$this->confirm('Overwrite file ' . str_replace(base_path(), '', $resourceCollectionFilePath) . '?')) {
                $bOverwrite = false;
                $this->error('Passed');
            }
        }

        if ($bOverwrite) {
            $str = (new Stub('/ResourceCollection.stub', [
                'NAMESPACE' => $resourcesNamespace,
                'MODEL_NAME' => $this->modelName,
            ]))->render();
            file_put_contents($resourceCollectionFilePath, $str);
        }
    }
}
