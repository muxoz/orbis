<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Text;

#[Icon('s.user-group')]
/**
 * @extends ModelResource<Customer>
 */
class CustomerResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Clientes';

    protected bool $isAsync = false;

    protected string $column = 'name';

    protected int $itemsPerPage = 15;
    

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->only();
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder->whereDoesntHave('roles');
    }
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nombre', 'name'),

            Email::make('Correo', 'email'),
        ];
    }


    /**
     * @param Customer $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
