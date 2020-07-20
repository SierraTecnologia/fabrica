<?php
/**
 * Serviço referente a linha no banco de dados
 */

namespace Fabrica\Services;

use Illuminate\Filesystem\Filesystem;

/**
 * 
 */
class RepositoryFolderService
{

    protected $config;

    protected $modelServices = false;

    public function __construct($config = false)
    {
        // if (!$this->config = $config) {
        //     $this->config = \Illuminate\Support\Facades\Config::get('sitec.sitec.models');
        // }
    }
    
    public static function findPackages()
    {
        $realPath = '/sierra/Dev/Libs/';
        
        collect(scandir($realPath))
            ->each(
                function ($item) use ($realPath) {
                    RepositoryFolderService::readFolderPackages($item, $realPath);
                }
            );

    }

    public static function readFolderPackages($item, $realPath)
    {
        if (in_array($item, ['.', '..'])) {
            return;
        }

        if (is_file($realPath . $item)) {
            return;
        }

        if (!is_dir($realPath . $item)) {
            return ;
        }
        $filesystem = app(Filesystem::class);
        
        if ($filesystem->exists($realPath . $item.'/composer.lock')) {
            // Get the composer.lock file
            $composer = json_decode(
                $filesystem->get($realPath . $item.'/composer.json')
            );
            $composerLock = json_decode(
                $filesystem->get($realPath . $item.'/composer.lock')
            );

            unset($composerLock->packages);
            dd(
                // $composerLock,
                $composer,
                $realPath . $item
            );

            // // Loop through all the packages and get the version of transmissor
            // foreach ($composerLock->packages as $package) {
            //     if ($package->name == $this->packageName) {
            //         $this->version = $package->version;
            //         break;
            //     }
            // }
        }

        return ;
    }
}
