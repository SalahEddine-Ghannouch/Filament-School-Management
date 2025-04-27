<?php

namespace App\Filament\Resources\StudyLevelResource\Pages;

use App\Filament\Resources\StudyLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudyLevels extends ListRecords
{
    protected static string $resource = StudyLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 