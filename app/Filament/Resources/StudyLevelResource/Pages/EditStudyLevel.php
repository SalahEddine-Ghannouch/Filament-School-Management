<?php

namespace App\Filament\Resources\StudyLevelResource\Pages;

use App\Filament\Resources\StudyLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudyLevel extends EditRecord
{
    protected static string $resource = StudyLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 