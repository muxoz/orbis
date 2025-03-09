<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Product;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\ImportExport\Contracts\HasImportExportContract;
use MoonShine\ImportExport\Traits\ImportExportConcern;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image as IMG;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.square2x2')]
/**
 * @extends ModelResource<Product>
 */
class ProductResource extends ModelResource implements HasImportExportContract
{   
    use ImportExportConcern, WithRolePermissions;

    protected string $model = Product::class;

    protected string $title = 'Productos';

    protected bool $isAsync = false;

    protected string $column = 'name';

    protected bool $columnSelection = true;

    protected bool $errorsAbove = false;

    protected int $itemsPerPage = 15;

    protected array $with = ['image'];

    protected function exportFields(): iterable
    {
        return [
            ID::make(),

            Number::make('Código', 'code'),

            Text::make('Nombre', 'name'),

            Text::make('Descripción', 'description'),

            Text::make('Precio', 'price'),

            Number::make('Existencias', 'stock'),

            BelongsTo::make(
                'Categoría',
                'category',
                resource: CategoryResource::class
            ),

            BelongsTo::make(
                'Proveedor',
                'supplier',
                resource: SupplierResource::class
            ),

            Date::make('Creado En', 'created_at')
                ->format('d/M/Y'),
        ];
    }

    protected function importFields(): iterable
    {
        return [
            ID::make(),

            Number::make('Código', 'code'),

            Text::make('Nombre', 'name'),

            Text::make('Descripción', 'description'),

            Text::make('Precio', 'price'),

            Number::make('Existencias', 'stock'),

            BelongsTo::make(
                'Categoría',
                'category',
                resource: CategoryResource::class
            ),

            BelongsTo::make(
                'Proveedor',
                'supplier',
                resource: SupplierResource::class
            ),

            Date::make('Creado En', 'created_at')
                ->format('d/M/Y'),
        ];
    }

    protected function search(): array
    {
        return ['id', 'code', 'name'];
    }

    protected function filters(): iterable
    {
        return [
            BelongsTo::make(
                'Categoría',
                'category',
                resource: CategoryResource::class
            ),

            BelongsTo::make(
                'Proveedor',
                'supplier',
                resource: SupplierResource::class
            )->nullable(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),

            Img::make('Imagen', 'image.name')
                ->disk('products'),

            Number::make('Código', 'code'),

            Text::make('Nombre', 'name'),

            Text::make('Precio', 'price')
                ->sortable(),

            Number::make('Existencias', 'stock')
                ->badge(fn ($value) => $value > 10 ? 'green' : 'red'),

            BelongsTo::make(
                'Categoría',
                'category',
                resource: CategoryResource::class
            ),

            BelongsTo::make(
                'Proveedor',
                'supplier',
                resource: SupplierResource::class
            ),

            Date::make('Creado En', 'created_at')
                ->format('d/M/Y'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Grid::make([
                    Column::make([
                        Number::make('Código', 'code'),

                        Text::make('Precio', 'price'),

                        Number::make('Existencias', 'stock')
                            ->buttons(),
                    ], 6),

                    Column::make([
                        Text::make('Nombre', 'name'),

                        BelongsTo::make(
                            'Categoría',
                            'category',
                            resource: CategoryResource::class
                        ),

                        BelongsTo::make(
                            'Proveedor',
                            'supplier',
                            resource: SupplierResource::class
                        )->nullable(),
                    ], 6),
                ]),
                Textarea::make('Descripción', 'description'),

                RelationRepeater::make(
                    'Imágenes',
                    'images',
                    resource: ImageResource::class
                )
                    ->fields([
                        Img::make('Imagen', 'name')
                            ->disk('products'),
                    ])
                    ->creatable(limit: 3)
                    ->removable(),
            ]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make()->sortable(),

            HasMany::make('Imágenes', 'images', resource: ImageResource::class)
                ->searchable(false),

            Number::make('Código', 'code'),

            Text::make('Nombre', 'name'),

            Text::make('Precio', 'price'),

            Number::make('Existencias', 'stock')
                ->badge(fn ($value) => $value > 10 ? 'green' : 'red'),

            BelongsTo::make(
                'Categoría',
                'category',
                resource: CategoryResource::class
            ),

            BelongsTo::make(
                'Proveedor',
                'supplier',
                resource: SupplierResource::class
            ),

            Date::make('Creado En', 'created_at')
                ->format('d/M/Y'),
        ];
    }

    /**
     * @param  Product  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'code' => 'required|string|max:14|unique:products,code'.
                       moonshineRequest()->isMethod('post') ? '' : $item->id,
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ];
    }
}
