<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'name')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\TextColumn::make('student_id'),
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('level.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->relationship('level', 'name'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 