<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Supplier;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Phone;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.truck')]
/**
 * @extends ModelResource<Supplier>
 */
class SupplierResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Supplier::class;

    protected string $title = 'Proveedores';

    protected string $column = 'name';

    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW);
    }

    private function fields($vertical = false): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Nombre', 'name'),

            Json::make('Contacto', 'contact_info')
                ->fields([
                    Email::make('email', 'email'),
                    Phone::make('phone', 'phone'),
                    Url::make('Pagina', 'page'),
                    Text::make('Dirección', 'address'),
                ])->vertical($vertical),

            HasMany::make(
                'Productos', 'products',
                resource: ProductResource::class)
                ->relatedLink(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return $this->fields(true);
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make($this->fields()),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return $this->fields();
    }

    /**
     * @param  Supplier  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => moonshineRequest()->isMethod('post')
            ? 'required|string|unique:suppliers,name'
            : 'required|string|unique:suppliers,name,'.$item->id,
        ];
    }
}
