<?php

namespace App\Filament\Resources\ProfessorResource\Pages;

use App\Filament\Resources\ProfessorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfessor extends EditRecord
{
    protected static string $resource = ProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 