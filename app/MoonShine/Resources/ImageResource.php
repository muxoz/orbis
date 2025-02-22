<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Image;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image as Img;

/**
 * @extends ModelResource<Image>
 */
class ImageResource extends ModelResource
{
    protected string $model = Image::class;

    protected string $title = 'Images';

    protected string $column = 'name';

    private function fields(): array
    {
        return [
            Img::make('Imagen', 'name')
                ->disk('products'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return $this->fields();
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
            ]),
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
     * @param  Image  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'name' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
