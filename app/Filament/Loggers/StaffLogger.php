<?php

namespace App\Filament\Loggers;

use App\Models\Staff;
use App\Filament\Resources\StaffResource;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\RelationManager;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class StaffLogger extends Logger
{
    public static ?string $model = Staff::class;

    public static function getLabel(): string | Htmlable | null
    {
        return StaffResource::getModelLabel();
    }

    public static function resource(ResourceLogger $logger): ResourceLogger
    {
        return $logger
            ->fields([
                Field::make('date_of_last_promotion'),
                Field::make('expected_date_of_retirement'),
                Field::make('grade_level'),
                Field::make('salary_grade_level'),
                Field::make('gross_salary'),
                Field::make('net_salary'),
                Field::make('salary_grade'),
                Field::make('salary_step'),
            ])
            ->relationManagers([
                RelationManager::make('promotions')
                ->label('Promotion')
                ->fields([
                    Field::make('promotion'),
                    Field::make('date'),
                ]),
            ]);
    }
}
