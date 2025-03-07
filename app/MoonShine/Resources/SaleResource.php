<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Sale;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.clipboard-document-list')]
/**
 * @extends ModelResource<Sale>
 */
class SaleResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Sale::class;

    protected string $title = 'Ventas';

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->only(Action::VIEW);
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsToMany::make('Productos', 'products', ProductResource::class)
                ->onlyCount(),
            Number::make('Total', 'total_amount')
                ->sortable(),

            Date::make('Fecha Venta', 'created_at')
                ->sortable()
                ->format('d/m/Y'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Date::make('Fecha Venta', 'created_at')
                ->format('d/m/Y'),

            Number::make('Total', 'total_amount'),

            BelongsToMany::make('Productos', 'products', ProductResource::class)
                ->fields([
                    Text::make('Cantidad', 'quantity'),
                ]),
        ];
    }

    /**
     * @param  Sale  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
