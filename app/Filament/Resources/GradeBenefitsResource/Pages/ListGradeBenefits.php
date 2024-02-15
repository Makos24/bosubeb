<?php

namespace App\Filament\Resources\GradeBenefitsResource\Pages;

use App\Filament\Imports\GradeBenefitsImporter;
use App\Filament\Resources\GradeBenefitsResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListGradeBenefits extends ListRecords
{
    protected static string $resource = GradeBenefitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->color('primary')
            ->importer(GradeBenefitsImporter::class)
        ];
    }
}
