<?php

namespace Tv2regionerne\StatamicAssetdrop;

use Statamic\Events\AssetContainerBlueprintFound;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $actions = [
        Actions\CP\ProcessUpload::class,
    ];

    protected $listen = [
        AssetContainerBlueprintFound::class => [
            Listeners\AssetContainerBlueprintListener::class,
        ],
    ];

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
        ],
    ];

    public function bootAddon()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/assetdrop.php', 'assetdrop');

        $this->publishes([
            __DIR__.'/../config/assetdrop.php' => config_path('assetdrop.php'),
        ], 'assetdrop-config');

        Permission::extend(function () {
            Permission::register('access assetdrop')
                ->label(__('Access Assetdrop'));
        });

        Nav::extend(function ($nav) {
            $nav->create(__('Assetdrop'))
                ->section('Tools')
                ->route('assetdrop.index')
                ->icon('assets')
                ->can('access assetdrop');
        });
    }
}
