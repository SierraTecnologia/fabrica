<?php

namespace Fabrica;

use App;
use Config;
use Fabrica\Facades\Fabrica as FabricaFacade;
use Fabrica\Services\FabricaService;
use Illuminate\Contracts\Events\Dispatcher;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Log;

use Muleta\Traits\Providers\ConsoleTools;
use Route;

class FabricaProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'fabrica';
    const pathVendor = 'sierratecnologia/fabrica';

    public static $aliasProviders = [
        'Fabrica' => \Fabrica\Facades\Fabrica::class,
    ];

    public static $providers = [

        \Support\SupportProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text' => 'Workspace',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'section'     => 'painel',
            'level'       => 1, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        [
            'text' => 'Configurações',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'section'     => 'admin',
            'level'       => 1, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        'Workspace|5' => [
            [
                'text' => 'Desenvolvimento',
                'icon' => 'fas fa-fw fa-search',
                'icon_color' => "blue",
                'label_color' => "success",
                'section'     => 'painel',
                'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            ],
            'Desenvolvimento' => [
                // [
                //     'text'        => 'Procurar',
                //     'icon'        => 'fas fa-fw fa-search',
                //     'icon_color'  => 'blue',
                //     'label_color' => 'success',
                //     'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                //     // 'access' => \Porteiro\Models\Role::$ADMIN
                // ],
                // [
                //     'text'        => 'Administração',
                //     'icon'        => 'fas fa-fw fa-search',
                //     'icon_color'  => 'blue',
                //     'label_color' => 'success',
                //     'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                //     // 'access' => \Porteiro\Models\Role::$ADMIN
                // ],
                // 'Procurar' => [
                    [
                        'text'        => 'Projetos',
                        'route'       => 'painel.fabrica.projects.index',
                        'icon'        => 'fas fa-fw fa-ship',
                        'icon_color'  => 'blue',
                        'label_color' => 'success',
                        'section'     => 'painel',
                        'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                        // 'access' => \Porteiro\Models\Role::$ADMIN
                    ],
                    [
                        'text'        => 'Issues',
                        'route'       => 'painel.fabrica.issues.index',
                        'icon'        => 'fas fa-fw fa-car',
                        'icon_color'  => 'blue',
                        'label_color' => 'success',
                        'section'     => 'painel',
                        'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                        // 'access' => \Porteiro\Models\Role::$ADMIN
                    ],
                    // ],
            ],
        ],
        'Configurações|250' => [
            // [
            //     'text'        => 'Tarefas',
            //     'icon'        => 'fas fa-fw fa-search',
            //     'icon_color'  => 'blue',
            //     'label_color' => 'success',
            //     'section'     => 'admin',
            //     'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
            //     // 'access' => \Porteiro\Models\Role::$ADMIN
            // ],
            [
                'text'        => 'Itens',
                'icon'        => 'fas fa-fw fa-search',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section'     => 'admin',
                'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            'Itens' => [
                [
                    'text'        => 'Stages',
                    'route'       => 'admin.fabrica.stages.index',
                    'icon'        => 'fas fa-fw fa-car',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section'     => 'admin',
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
                [
                    'text'        => 'Status',
                    'route'       => 'admin.fabrica.status.index',
                    'icon'        => 'fas fa-fw fa-car',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section'     => 'admin',
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
                [
                    'text'        => 'Resolutions',
                    'route'       => 'admin.fabrica.resolutions.index',
                    'icon'        => 'fas fa-fw fa-car',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section'     => 'admin',
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
            // ],
            // 'Tarefas' => [
                [
                    'text'        => 'Fields',
                    'route'       => 'admin.fabrica.fields.index',
                    'icon'        => 'fas fa-fw fa-car',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section'     => 'admin',
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
            ],
        ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(
            function () {
                $this->routes();
            }
        );

        $this->loadLogger();
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        /**
         * Transmissor; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'routes');

        // /**
        //  * Fabrica; Routes
        //  */
        // Route::group(
        //     [
        //         'namespace' => '\Fabrica\Http\Controllers',
        //         'prefix' => \Illuminate\Support\Facades\Config::get('application.routes.main', ''),
        //         'as' => 'rica.',
        //         // 'middleware' => 'rica',
        //     ], function ($router) {
        //         include __DIR__.'/../routes/web.php';
        //     }
        // );
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec'.DIRECTORY_SEPARATOR.'fabrica.php'), 'sitec.fabrica');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations');

        $this->app->singleton(
            'fabrica', function () {
                return new Fabrica();
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Fabrica;
         */
        $this->app->singleton(
            FabricaService::class, function ($app) {
                Log::channel('sitec-fabrica')->info('Singleton Fabrica;');
                return new FabricaService(\Illuminate\Support\Facades\Config::get('sitec.fabrica'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/fabrica/src/Console/Commands') => '\Fabrica\Console\Commands',
            ]
        );

        // /**
        //  * Helpers
        //  */
        // Aqui noa funciona
        // if (!function_exists('fabrica_asset')) {
        //     function fabrica_asset($path, $secure = null)
        //     {
        //         return route('rica.fabrica.assets').'?path='.urlencode($path);
        //     }
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'fabrica',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes(
            [
            // Paths
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec') => config_path('sitec'),
            ], ['config',  'sitec', 'sitec-config']
        );

        // // Publish fabrica css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('fabrica') => public_path('assets/fabrica')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();
    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'fabrica');
        $this->publishes(
            [
            $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'fabrica'),
            ], ['views',  'sitec', 'sitec-views']
        );
    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'fabrica')
            ], ['lang',  'sitec', 'sitec-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'fabrica');
    }


    /**
     *
     */
    private function loadLogger()
    {
        Config::set(
            'logging.channels.sitec-fabrica', [
            'driver' => 'single',
            'path' => storage_path('logs'.DIRECTORY_SEPARATOR.'sitec-fabrica.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }
}
