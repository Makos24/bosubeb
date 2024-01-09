<?php

namespace App\Filament\Resources\LGAResource\Pages;

use App\Filament\Resources\LGAResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLGA extends EditRecord
{
    protected static string $resource = LGAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
