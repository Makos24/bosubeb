<?php

namespace App\Filament\Resources\CadreResource\Pages;

use App\Filament\Resources\CadreResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCadres extends ManageRecords
{
    protected static string $resource = CadreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
