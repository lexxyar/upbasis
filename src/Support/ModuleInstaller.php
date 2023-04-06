<?php

namespace Lexxsoft\Upbasis\Support;

use DirectoryIterator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Lexxsoft\Upbasis\Exceptions\DatabaseMigrationException;
use Lexxsoft\Upbasis\Exceptions\FileExtractionException;
use Lexxsoft\Upbasis\Exceptions\LocaleClassNotFoundException;
use Lexxsoft\Upbasis\Exceptions\LocalekeyClassNotFoundException;
use Lexxsoft\Upbasis\Exceptions\ModuleFolderExistException;
use Lexxsoft\Upbasis\Exceptions\ModuleInstallationFileNotFoundException;
use Lexxsoft\Upbasis\Exceptions\ModuleInstallationSectionMissedException;
use Lexxsoft\Upbasis\Exceptions\ModuleNameIsEmptyException;
use Lexxsoft\Upbasis\Exceptions\ModuleNameIsNotSetException;
use Lexxsoft\Upbasis\Exceptions\ModuleNotFoundException;
use Lexxsoft\Upbasis\Exceptions\PermissionClassNotFoundException;
use Lexxsoft\Upbasis\Models\Module;
use Lexxsoft\Upbasis\Support\Traits\FileCopyableTrait;
use Lexxsoft\Upbasis\Support\Traits\ZippableTrait;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Yaml\Yaml;
use ZipArchive;

class ModuleInstaller
{
    use FileCopyableTrait, ZippableTrait;

    private mixed $yaml;
    private string $installationFilePath;
    private string $yamlModuleName;
    /**
     * @var mixed|null
     */
    private mixed $yamlInstallationSection;
    private string $backId;
    private Module $newModule;
    private string $zipFilePath;
    private string $instanceKey;

    /**
     * @throws LocaleClassNotFoundException
     * @throws ModuleInstallationFileNotFoundException
     * @throws PermissionClassNotFoundException
     * @throws ModuleInstallationSectionMissedException
     * @throws ModuleNotFoundException
     * @throws FileExtractionException
     * @throws ModuleNameIsNotSetException
     * @throws ModuleNameIsEmptyException
     * @throws ModuleFolderExistException
     * @throws LocalekeyClassNotFoundException
     * @throws DatabaseMigrationException
     */
    public static function install(string $zipFilePath,
                                   bool   $noMigration = false,
                                   bool   $noTranslation = false,
                                   bool   $noPermission = false,
                                   bool   $noActivate = false,
                                   bool   $skipServerInstallation = false,
                                   bool   $skipClientInstallation = false,
                                   bool   $backupExist = false,
                                   bool   $forceRewrite = false): void
    {
        (new self($zipFilePath,
            $noMigration,
            $noTranslation,
            $noPermission,
            $noActivate,
            $skipServerInstallation,
            $skipClientInstallation,
            $backupExist,
            $forceRewrite))->installation();
    }

    public function __construct(string                $zipFilePath,
                                private readonly bool $noMigration = false,
                                private readonly bool $noTranslation = false,
                                private readonly bool $noPermission = false,
                                private readonly bool $noActivate = false,
                                private readonly bool $skipServerInstallation = false,
                                private readonly bool $skipClientInstallation = false,
                                private readonly bool $backupExist = false,
                                private readonly bool $forceRewrite = false,
    )
    {
        $this->instanceKey = Str::random(14);

        // Move ZIP file to TMP directory
        $this->zipFilePath = Storage::disk('tmp')->path(File::basename($zipFilePath));
        File::move($zipFilePath, $this->zipFilePath);
    }

    /**
     * @throws LocaleClassNotFoundException
     * @throws ModuleInstallationFileNotFoundException
     * @throws PermissionClassNotFoundException
     * @throws ModuleInstallationSectionMissedException
     * @throws ModuleNotFoundException
     * @throws FileExtractionException
     * @throws ModuleNameIsNotSetException
     * @throws ModuleNameIsEmptyException
     * @throws ModuleFolderExistException
     * @throws LocalekeyClassNotFoundException
     * @throws DatabaseMigrationException
     */
    public function installation(): void
    {
        if ($this->backupExist) {
            $this->backId = date('_YmdHis');
        }

        try {

            // Extract archive
            if (!$this->unzip($this->zipFilePath, Storage::disk('tmp')->path($this->instanceKey))) {
                throw new FileExtractionException();
            }

            // Find installation file
            $this->findInstallationFile();

            // Load YAML installation description
            $this->yaml = Yaml::parseFile($this->installationFilePath);

            // Find installation section
            $this->findYamlInstallationSection();

            // Install server
            if (!$this->skipServerInstallation) {
                if (isset($this->yamlInstallationSection['server'])) {
                    // Create module directory
                    $newModulePath = base_path(Config::get('up.module.server_folder') . DIRECTORY_SEPARATOR . $this->yamlModuleName);
                    $this->createModuleDir($newModulePath);

                    // Copy files to Module directory
                    $filesDir = dirname($this->installationFilePath) . DIRECTORY_SEPARATOR . 'server';
                    self::copyFiles($filesDir, $newModulePath);

                    // Migrate database
                    if (!$this->noMigration) {
                        $response = Artisan::call('module:migrate', ['module' => $this->yamlModuleName]);
                        if (!$response == CommandAlias::SUCCESS) {
                            throw new DatabaseMigrationException($this->yamlModuleName);
                        }
                    }

                    // Add module to DB
                    $this->registerModule();

                    // Create permission records in DB
                    if (!$this->noPermission) {
                        if ($this->yamlInstallationSection['permissions']) {
                            $this->createPermissionRecords();
                        }
                    }

                    // Create translation keys records in DB
                    if (!$this->noTranslation) {
                        if ($this->yamlInstallationSection['translations']) {
                            $this->createTranslationRecords();
                        }
                    }

                    // Activate module
                    if (!$this->noActivate) {
                        $this->newModule->enable();
                    }
                }
            }

            // Install client
            if (!$this->skipClientInstallation) {
                if (isset($this->yamlInstallationSection['client'])) {

                    // Create module directory
                    $newModulePath = resource_path(Config::get('up.module.client_folder') . DIRECTORY_SEPARATOR . $this->yamlModuleName);
                    $this->createModuleDir($newModulePath);

                    // Copy files to Module directory
                    $filesDir = dirname($this->installationFilePath) . DIRECTORY_SEPARATOR . 'client';
                    self::copyFiles($filesDir, $newModulePath);
                }
            }
        } finally {
            // Clear trash
            $this->clearTrash();
        }
    }

    /**
     * @throws ModuleInstallationFileNotFoundException
     */
    private function findInstallationFile(): void
    {
        $bFileFound = false;
        $sInstallationFile = Storage::disk('tmp')->path($this->instanceKey . DIRECTORY_SEPARATOR . Config::get('up.module.installation_yaml'));

        if (!file_exists($sInstallationFile)) {
            $dir = new DirectoryIterator(dirname($sInstallationFile));
            foreach ($dir as $fileInfo) {
                if ($fileInfo->isDot() || $fileInfo->isFile()) {
                    continue;
                }
                $sInstallationFile = Storage::disk('tmp')->path($this->instanceKey . DIRECTORY_SEPARATOR . $fileInfo->getFilename() . DIRECTORY_SEPARATOR . Config::get('up.module.installation_yaml'));

                if (file_exists($sInstallationFile)) {
                    $bFileFound = true;
                    break;
                }
            }
        } else {
            $bFileFound = true;
        }

        if (!$bFileFound) {
            throw new ModuleInstallationFileNotFoundException();
        }

        $this->installationFilePath = $sInstallationFile;
    }

    /**
     * @throws ModuleNameIsNotSetException
     * @throws ModuleInstallationSectionMissedException
     */
    private function findYamlInstallationSection(): void
    {
        $this->yamlModuleName = ucfirst(trim($this->yaml['module'] ?: ''));

        if ($this->yamlModuleName == '') {
            throw new ModuleNameIsNotSetException();
        }

        $this->yamlInstallationSection = $this->yaml['installation'] ?? null;
        if ($this->yamlInstallationSection == null) {
            throw new ModuleInstallationSectionMissedException();
        }
    }

    /**
     * @throws ModuleFolderExistException
     */
    private function createModuleDir(string $path): void
    {
        if (!file_exists($path)) {
            mkdir($path);
        } else {
            if ($this->backupExist) {
                $newName = $path . $this->backId;
                rename($path, $newName);
            } else {
                if ($this->forceRewrite) {
                    File::deleteDirectory($path);
                } else {
                    throw new ModuleFolderExistException($path);
                }
            }
        }
    }

    /**
     * @throws ModuleNameIsEmptyException
     * @throws ModuleNotFoundException
     */
    private function registerModule(): void
    {
        $this->newModule = Module::firstOrCreate(
            ['name' => $this->yamlModuleName],
            ['name' => $this->yamlModuleName, 'enabled' => false]
        );

        $this->newModule->loadMeta();
    }

    /**
     * @throws PermissionClassNotFoundException
     */
    private function createPermissionRecords(): void
    {
        $modelClass = Config::get('up.models.permission');
        if ($modelClass == null || !class_exists($modelClass)) {
            throw new PermissionClassNotFoundException($modelClass);
        }

        $aPermissions = [];
        foreach ($this->yamlInstallationSection['permissions'] as $name => $desc) {
            $aPermissions[$name] = ['name' => $name, 'description' => $desc, 'guard_name' => 'web'];
        }
        $exist = $modelClass::whereIn('name', array_keys($aPermissions))
            ->select(['name'])
            ->get()
            ->pluck('name');
        $newRecords = array_diff_key($aPermissions, array_flip($exist->toArray()));

        $modelClass::factory()->createMany($newRecords);
    }

    /**
     * @throws LocaleClassNotFoundException
     * @throws LocalekeyClassNotFoundException
     */
    private function createTranslationRecords(): void
    {
        $modelClassLocale = Config::get('up.models.locale');
        if ($modelClassLocale == null || !class_exists($modelClassLocale)) {
            throw new LocaleClassNotFoundException($modelClassLocale);
        }
        $modelClassLocalekey = Config::get('up.models.localekey');
        if ($modelClassLocalekey == null || !class_exists($modelClassLocalekey)) {
            throw new LocalekeyClassNotFoundException($modelClassLocalekey);
        }

        // Loop through translations
        foreach ($this->yamlInstallationSection['translations'] as $locale => $content) {
            // Check locale exist. If not exist, then create it
            $oLocale = $modelClassLocale::firstOrCreate(
                ['name' => strtolower($locale)],
                ['name' => strtolower($locale), 'description' => $content['description'] ?: '']
            );

            // Loop through $content['keys'] to create locale keys and
            // gather it to sync with locales
            $sync = [];
            foreach ($content['keys'] as $key => $value) {
                $t_key = $modelClassLocalekey::firstOrCreate(['name' => strtolower($key)]);

                if (!!(trim($value)))
                    $sync[$t_key->id] = ['translation' => $value];
            }

            // Sync locale and locale keys
            $oLocale->localekeys()->sync($sync);
        }
    }

    private function clearTrash(): void
    {
        if (file_exists(Storage::disk('tmp')->path($this->instanceKey))) {
            File::deleteDirectory(Storage::disk('tmp')->path($this->instanceKey));
        }
    }
}
