<?php

namespace App\Services;

use MoonShine\Contracts\ColorManager\ColorManagerContract;

class ThemeApplier
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ColorManagerContract $colorManager) {}

    public function theme1(): void
    {
        $this->colorManager->background('#17202a')
            ->content('#1c2833')
            ->tableRow('#212f3c')
            ->borders('#34495e')
            ->buttons('#34495e')
            ->dividers('#5d6d7e')
            ->primary('#DD5303')
            ->secondary('#F48B01')
            ->successBg('#117a65')
            ->successText('#82e0aa')
            ->warningBg('#b7950b')
            ->warningText('#f7dc6f')
            ->errorBg('#7b241c')
            ->errorText('#f5b7b1')
            ->infoBg('#21618c')
            ->infoText('#85c1e9');

        $this->colorManager->successBg('#1e8449')
            ->successBg('#117a65', dark: true)
            ->successText('#82e0aa', dark: true)
            ->warningBg('#b7950b', dark: true)
            ->warningText('#f7dc6f', dark: true)
            ->errorBg('#a93226', dark: true)
            ->errorText('#f5b7b1', dark: true)
            ->infoBg('#21618c', dark: true)
            ->infoText('#85c1e9', dark: true);
    }
}
