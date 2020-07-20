<?php

namespace Fabrica\Console\Commands\Sync;

use Illuminate\Console\Command;
use Fabrica\Services\RepositoryFolderService;

class PackagesSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Packges !';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        RepositoryFolderService::findPackages();
    }
}
