<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

#[Icon('s.tag')]
/**
 * @extends ModelResource<Category>
 */
class CategoryResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Category::class;

    protected string $title = 'Categorías';

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    protected bool $detailInModal = true;

    protected string $column = 'name';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected ?PageType $redirectAfterDelete = PageType::INDEX;

    protected bool $isAsync = false;

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW);
    }

    private function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Nombre', 'name'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ...$this->fields(),
            HasMany::make(
                'Productos',
                'products',
                resource: ProductResource::class
            )
                ->relatedLink(),

        ];
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
     * @param  Category  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => moonshineRequest()->isMethod('post')
                ? 'required|string|unique:categories,name'
                : 'required|string|unique:categories,name,'.$item->id,
        ];
    }
}
