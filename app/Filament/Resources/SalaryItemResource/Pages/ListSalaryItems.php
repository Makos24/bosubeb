<?php

namespace App\Filament\Resources\SalaryItemResource\Pages;

use App\Filament\Imports\SalaryItemImporter;
use App\Filament\Resources\SalaryItemResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListSalaryItems extends ListRecords
{
    protected static string $resource = SalaryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->color('primary')
            ->importer(SalaryItemImporter::class)
        ];
    }
}
