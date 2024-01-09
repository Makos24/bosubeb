<?php

namespace App\Filament\Resources\LGAResource\Pages;

use App\Filament\Resources\LGAResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLGAS extends ListRecords
{
    protected static string $resource = LGAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
