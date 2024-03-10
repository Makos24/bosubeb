<?php

namespace App\Filament\Resources\AgencyResource\Pages;

use App\Filament\Imports\AgencyImporter;
use App\Filament\Resources\AgencyResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListAgencies extends ListRecords
{
    protected static string $resource = AgencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->color('primary')
            ->importer(AgencyImporter::class)
        ];
    }
}
