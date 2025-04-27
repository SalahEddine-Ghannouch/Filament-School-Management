<?php

namespace App\Filament\Resources\TimetableResource\Pages;

use App\Filament\Resources\TimetableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimetables extends ListRecords
{
    protected static string $resource = TimetableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 