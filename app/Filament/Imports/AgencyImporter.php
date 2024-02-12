<?php

namespace App\Filament\Imports;

use App\Models\Agency;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AgencyImporter extends Importer
{
    protected static ?string $model = Agency::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('acronymn')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('category_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('salary_structure_id')
                ->requiredMapping()
                ->numeric()
                ->rules([]),
        ];
    }

    public function resolveRecord(): ?Agency
    {
        // return Agency::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Agency();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your agency import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
