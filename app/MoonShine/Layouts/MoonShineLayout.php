<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Pages\POS;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\SaleResource;
use App\MoonShine\Resources\SupplierResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\Layout\Favicon;
use MoonShine\UI\Components\Layout\Footer;
use MoonShine\UI\Components\Layout\Layout;
use Sweet1s\MoonshineRBAC\Components\MenuRBAC;
use Sweet1s\MoonshineRBAC\Resource\PermissionResource;
use Sweet1s\MoonshineRBAC\Resource\RoleResource;
use Sweet1s\MoonshineRBAC\Resource\UserResource;
use App\MoonShine\Resources\CustomerResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function getFaviconComponent(): Favicon
    {
        return parent::getFaviconComponent()->customAssets([
            'apple-touch' => '/icon.svg',
            '32' => '/icon.svg',
            '16' => '/icon.svg',
            'safari-pinned-tab' => '/icon.svg',
            'web-manifest' => '/icon.svg',
        ]);
    }

    protected function getFooterComponent(): Footer
    {
        return Footer::make()
            ->copyright(fn (): string => 'COMPRANAX'
            );
    }

    protected function menu(): array
    {
        return MenuRBAC::menu(
            MenuGroup::make('system', [
                MenuItem::make('admins_title', UserResource::class)
                    ->translatable('moonshine::ui.resource')
                    ->icon('s.user-group'),

                MenuItem::make('role', RoleResource::class)
                    ->translatable('moonshine::ui.resource')
                    ->icon('s.rectangle-group'),

                MenuItem::make('permissions', PermissionResource::class)
                    ->translatable('moonshine-rbac::ui')
                    ->icon('s.shield-check'),

            ], 'm.cube')->translatable('moonshine::ui.resource'),

            MenuGroup::make('Inventario', [
                MenuItem::make('Categorías', CategoryResource::class),
                MenuItem::make('Proveedores', SupplierResource::class),
                MenuItem::make('Productos', ProductResource::class),
            ], 's.archive-box'),

            MenuGroup::make('Caja', [
                MenuItem::make('POS', POS::class),
                MenuItem::make('Ventas', SaleResource::class),
            ], 's.computer-desktop'),

            MenuGroup::make('CRM', [
                MenuItem::make('Clientes', CustomerResource::class),
            ], 's.briefcase'),

        );
    }

    /**
     * @param  ColorManager  $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        // parent::colors($colorManager);
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
