<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Imports\LoanImporter;
use App\Filament\Resources\LoanResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->color('primary')
            ->importer(LoanImporter::class)
        ];
    }
}
