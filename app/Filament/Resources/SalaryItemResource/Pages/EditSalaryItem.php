<?php

namespace App\Filament\Resources\SalaryItemResource\Pages;

use App\Filament\Resources\SalaryItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalaryItem extends EditRecord
{
    protected static string $resource = SalaryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
