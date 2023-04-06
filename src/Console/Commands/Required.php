<?php

namespace Lexxsoft\Upbasis\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Lexxsoft\Upbasis\Exceptions\ModuleFileDownloadException;
use Lexxsoft\Upbasis\Support\ModuleInstaller;
use Lexxsoft\Upbasis\Support\Traits\ConsoleOutputTrait;
use Symfony\Component\Console\Command\Command as CommandAlias;


class Required extends Command
{
    use ConsoleOutputTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'up:require {module} {--M|no-migration} {--T|no-translation} {--P|no-permission} {--A|no-activate} {--S|skip-server-installation} {--C|skip-client-installation} {--b|backup-exist} {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Download and install Universal Platform extension module";

    private string $moduleName = '';
    private string $zipFilePath = '';
    private string $currentProcessName = '';

    public function handle(): int
    {
        $time_start = microtime(true);

        $this->moduleName = $this->argument('module');
        $noMigration = boolval($this->option('no-migration'));
        $noTranslation = boolval($this->option('no-translation'));
        $noPermission = boolval($this->option('no-permission'));
        $noActivate = boolval($this->option('no-activate'));
        $skipServerInstallation = boolval($this->option('skip-server-installation'));
        $skipClientInstallation = boolval($this->option('skip-client-installation'));
        $backupExist = boolval($this->option('backup-exist'));
        $forceRewrite = boolval($this->option('force'));

        // Check module name is provided
        if (!$this->moduleName) {
            $this->components->error('Module name is required');
            return CommandAlias::FAILURE;
        }

        // Create URL for download
        $repoUrl = Config::get('up.repository_url');
        $url = $repoUrl . "/$this->moduleName.zip";

        // Installation process...
        $this->newLine();
        $this->components->twoColumnDetail('<fg=gray>Module installation</>', '<fg=gray>Status</>');

        // Check packages
        $this->process('Check packages');
        $this->processSub();

        $packageName = 'nwidart/laravel-modules';
        $this->process($packageName, 1);
        if (!file_exists(base_path('vendor' . DIRECTORY_SEPARATOR . $packageName))) {
            $this->processFail();
            $this->components->error("Package '$packageName' not found");
            $this->output->write("Run 'composer require $packageName' to install it and rerun the process");
            return CommandAlias::FAILURE;
        }
        $this->processDone();

        try {
            // Download file from repo
            $this->process('Download module');
            $this->downloadModule($url);
            $this->processDone();

            $this->process('Installation');
            ModuleInstaller::install($this->zipFilePath,
                noMigration: $noMigration,
                noTranslation: $noTranslation,
                noPermission: $noPermission,
                noActivate: $noActivate,
                skipServerInstallation: $skipServerInstallation,
                skipClientInstallation: $skipClientInstallation,
                backupExist: $backupExist,
                forceRewrite: $forceRewrite
            );
            $this->processDone();

        } catch (Exception $e) {
            $this->processFail();
            $this->components->error($e->getMessage());
            return CommandAlias::FAILURE;
        }

        $time_end = microtime(true);

        // execution time in seconds
        $execution_time = $time_end - $time_start;

        $this->components->info('Executed in ' . number_format((float)$execution_time, 2, '.', '') . ' seconds');

        return CommandAlias::SUCCESS;
    }

    /**
     * @throws ModuleFileDownloadException
     */
    private function downloadModule(string $url): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Pragma: no-cache',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: none',
            'Sec-Fetch-User: ?1',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
            'sec-ch-ua: "Google Chrome";v="111", "Not(A:Brand";v="8", "Chromium";v="111"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "macOS"',
            'Accept-Encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=bb0fc872e6decbea731f2853484e1d24; 1d426e88-9cc3-4014-2d0c-f6258825ffbf=1680172682543; orders[sort]=id; claim[sort]=claimdate; reserve[sort]=deptime; carriers[sort]=name; vehicles[sort]=capacity; caraccept[sort]=docnum; payservice[sort]=name; paymanagers[sort]=id; region[sort]=name; address[sort]=name; schedule[sort]=routenum; price[sort]=direct; carbprice[sort]=direct; customers[sort]=surname; vclmodel[sort]=model; person[sort]=name; 15e1220b-746f-0484-79a9-5b1a2d7bc502=1680176755994; tourcompany[sort]=name; tourmanagers[sort]=name; paytransfer[sort]=name; 824d8c5f-6843-a114-0db1-cf84cf7b169f=1680178910149; elogmgr[sort]=id; elogdsp[sort]=id; f1413cc4-178e-ca84-c1bc-59a09c60509c=1680180501886; routelist[sort]=docnum; 61130326-ab25-3664-6595-3032068e4bc4=1680181134728; f5641c8d-8491-3bb4-7d1f-acd40ca25951=1680181198936; roadlist[sort]=docnum; elogservice[sort]=id; town[sort]=regioncode; 45c4de34-aaf6-6e54-8d30-63820b59535e=1680195845790; locale=en; accessToken=34|ePW84IVypDXsV0e2HG47xxB0vjL7cae631DV3rNs; tokenType=Bearer; XSRF-TOKEN=eyJpdiI6IitLdXE3cmlsU2JOOUlIUDdrOXJEZVE9PSIsInZhbHVlIjoidFNzck54SUtER2R6a3Y3ZVFIN28vZURTUm5BZkVrSXcydlozTFpzRzgwVVdjaFdiakk0UWZYY0RPY3FMcnMwWjdnbTVrVzdEZFUzVUpONE1vV0ZuTVdtUmp2SUdPWmtKcnRqb2VycCtIZnppNVdjKzluWFdHdm0yYnBoMlhyaGUiLCJtYWMiOiIzY2ZlOTFhNTc1MTY2OTI2Y2I5ZGY5NjViZDE4MTAxMGI4MjYwNWZhYmRiMjRhMGMwYTg3OTlhZDQxNGQwYjRiIiwidGFnIjoiIn0%3D; universal_platform_session=eyJpdiI6ImY3bWxxMGZCcmw5RDZPd3N3bGVrL2c9PSIsInZhbHVlIjoiRnUxaDhPWHE4NWU3ZWFpZ1F3YU0wTVFDWThuMmZwZlQ5NXVjeitwUEtVK0IxaXpvSi83TndnVHVIanFsbklJdVkrbGVlRzdqSnVnUk0zS2V5TUVOYnJQOTJBaWY5Ylg0RkJ6bitmVDRadnFRZEJzQnc2UkZOdUx4eVFuWUVUK1oiLCJtYWMiOiJjZmRiOTFkNjkxY2M0MmZkYzQwNjQxODA3Y2EyZGU4ODQ4MzI5NjBjNWMzY2IwMTQ3NzY4OTNiNmNiYmEzN2RiIiwidGFnIjoiIn0%3D');

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response === false) {
            throw new ModuleFileDownloadException();
        }

        Storage::disk('tmp')->put("$this->moduleName.zip", $response);
        $this->zipFilePath = Storage::disk('tmp')->path("$this->moduleName.zip");
    }
}
