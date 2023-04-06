<?php

namespace Lexxsoft\Upbasis\Console\Commands;

use Illuminate\Console\Command;

class Hello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'up:hello {--M|no-migration} {--T|no-translation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Universal Platform say 'Hello'";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Hello there');

//        dump(config('filesystems.disks'));
//        exec('php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"', $msg, $res);
//        $this->info($res);
//        $path = __DIR__ . '/../Storage/Files';
//        dd($path);
    }
}
