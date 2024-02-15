<?php

namespace App\Filament\Resources\GradeBenefitsResource\Pages;

use App\Filament\Resources\GradeBenefitsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGradeBenefits extends EditRecord
{
    protected static string $resource = GradeBenefitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
