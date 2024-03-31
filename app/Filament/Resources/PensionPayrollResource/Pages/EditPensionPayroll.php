<?php

namespace App\Filament\Resources\PensionPayrollResource\Pages;

use App\Filament\Resources\PensionPayrollResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPensionPayroll extends EditRecord
{
    protected static string $resource = PensionPayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
