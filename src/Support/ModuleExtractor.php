<?php

namespace Lexxsoft\Upbasis\Support;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Lexxsoft\Upbasis\Exceptions\LocaleClassNotFoundException;
use Lexxsoft\Upbasis\Exceptions\LocalekeyClassNotFoundException;
use Lexxsoft\Upbasis\Exceptions\ModuleNameIsEmptyException;
use Lexxsoft\Upbasis\Exceptions\ModuleNotFoundException;
use Lexxsoft\Upbasis\Models\Module;
use Lexxsoft\Upbasis\Support\Traits\FileCopyableTrait;
use Lexxsoft\Upbasis\Support\Traits\ZippableTrait;
use stdClass;
use Symfony\Component\Yaml\Yaml;

class ModuleExtractor
{
    use FileCopyableTrait, ZippableTrait;

    private stdClass $yaml;

    /**
     * @throws LocaleClassNotFoundException
     * @throws ModuleNotFoundException
     * @throws LocalekeyClassNotFoundException
     * @throws ModuleNameIsEmptyException
     */
    public static function export(string $sModuleName): string
    {
        return (new self($sModuleName))->exportModule();
    }

    public function __construct(private readonly string $moduleName)
    {
        $this->yaml = new stdClass();
    }

    /**
     * @throws LocaleClassNotFoundException
     * @throws ModuleNotFoundException
     * @throws LocalekeyClassNotFoundException
     * @throws ModuleNameIsEmptyException
     */
    public function exportModule(): string
    {
        // create yaml installation file
        /** @var Module $oModule */
        $oModule = Module::where('name', $this->moduleName)->first();
        if (!$oModule) {
            throw new ModuleNotFoundException($this->moduleName);
        }
        $oModule->loadMeta();

        $this->yaml->module = $this->moduleName;
        $this->yaml->version = $oModule->version;
        $this->yaml->installation = new stdClass();
        $this->yaml->installation->server = new stdClass();
        $this->yaml->installation->permissions = new stdClass();
        $this->yaml->installation->translations = new stdClass();


        $moduleName = $this->moduleName;

        $modelClassLocale = Config::get('up.models.locale');
        if ($modelClassLocale == null || !class_exists($modelClassLocale)) {
            throw new LocaleClassNotFoundException($modelClassLocale);
        }
        $modelClassLocalekey = Config::get('up.models.localekey');
        if ($modelClassLocalekey == null || !class_exists($modelClassLocalekey)) {
            throw new LocalekeyClassNotFoundException($modelClassLocalekey);
        }

        $aAllKeys = $modelClassLocalekey::orderBy('name')
            ->where('name', 'LIKE', 'i18n_' . strtolower($this->moduleName) . '_%')
            ->get();
        $aLocale = $modelClassLocale::with(['localekeys' => function ($query) use ($moduleName) {
            $query->where('name', 'LIKE', 'i18n_' . strtolower($moduleName) . '_%');
        }])
            ->get();

        foreach ($aLocale as $locale) {
            $keyval = [];
            foreach ($aAllKeys as $item) {
                $keyval[$item->name] = '';
                foreach ($locale->localekeys as $oTranslation) {
                    if ($oTranslation->name == $item->name) {
                        $keyval[$item->name] = $oTranslation->pivot->translation;
                        break;
                    }
                }
            }
            $localeName = $locale->name;

            $this->yaml->installation->translations->$localeName = new stdClass();
            $this->yaml->installation->translations->$localeName->description = $locale->description;
            $this->yaml->installation->translations->$localeName->keys = $keyval;
        }

        // create solt for unique
        $solt = '_' . date('YmdHis');

        // create tmp folder to gather archive
        $sTmpDir = $this->moduleName . $solt;
        if (!file_exists($sTmpDir)) {
            mkdir(Storage::disk('tmp')->path($sTmpDir));
        }

        // craete server folder for module files
        $sTmpServerDir = $sTmpDir . DIRECTORY_SEPARATOR . 'server';
        if (!file_exists($sTmpServerDir)) {
            mkdir(Storage::disk('tmp')->path($sTmpServerDir));
        }

        // copy server files
        $moduleDir = base_path('Modules' . DIRECTORY_SEPARATOR . $this->moduleName);
        self::copyFiles($moduleDir, Storage::disk('tmp')->path($sTmpServerDir));


        $clientResourcePath = Config::get('up.module.client_folder'). DIRECTORY_SEPARATOR . $this->moduleName;
        if (file_exists(resource_path($clientResourcePath))) {
            $this->yaml->installation->client = new stdClass();

            // craete client folder for module files
            $sTmpClientDir = $sTmpDir . DIRECTORY_SEPARATOR . 'client';
            if (!file_exists($sTmpClientDir)) {
                mkdir(Storage::disk('tmp')->path($sTmpClientDir));
            }

            // copy client files
            self::copyFiles(resource_path($clientResourcePath), Storage::disk('tmp')->path($sTmpClientDir));
        }

        $content = Yaml::dump($this->yaml, 10, 4, Yaml::DUMP_OBJECT_AS_MAP);
        file_put_contents(Storage::disk('tmp')->path($sTmpDir . DIRECTORY_SEPARATOR . 'installation.yml'), $content);

        // make archive
        $zipFile = Storage::disk('tmp')->path($this->moduleName . $solt . '.zip');
        self::zipDir(Storage::disk('tmp')->path($sTmpDir), $zipFile);

        // clear tmp dir
        File::deleteDirectory(Storage::disk('tmp')->path($sTmpDir));

        return $zipFile;
    }
}
