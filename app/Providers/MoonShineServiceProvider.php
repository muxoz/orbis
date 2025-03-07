<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Pages\POS;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\ImageResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\SaleResource;
use App\MoonShine\Resources\SupplierResource;
use App\Services\ThemeApplier;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use Sweet1s\MoonshineRBAC\Resource\PermissionResource;
use Sweet1s\MoonshineRBAC\Resource\RoleResource;
use Sweet1s\MoonshineRBAC\Resource\UserResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     */
    public function boot(
        CoreContract $core,
        ConfiguratorContract $config,
        ColorManagerContract $colorManager
    ): void {
        // $config->authEnable();

        (new ThemeApplier($colorManager))->theme1();

        $core
            ->resources([
                UserResource::class,
                RoleResource::class,
                PermissionResource::class,

                CategoryResource::class,
                SupplierResource::class,
                ProductResource::class,
                ImageResource::class,
                SaleResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                POS::class,
            ]);
    }
}
