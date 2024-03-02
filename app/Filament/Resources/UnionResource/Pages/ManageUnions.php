<?php

namespace App\Filament\Resources\UnionResource\Pages;

use App\Filament\Resources\UnionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnions extends ManageRecords
{
    protected static string $resource = UnionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
