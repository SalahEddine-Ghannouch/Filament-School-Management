<?php

namespace App\Filament\Resources\StudyLevelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\Select::make('professor_id')
                    ->relationship('professor', 'first_name')
                    ->required(),
                Forms\Components\Select::make('semester')
                    ->options([
                        'fall' => 'Fall',
                        'spring' => 'Spring',
                        'summer' => 'Summer',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('department.name'),
                Tables\Columns\TextColumn::make('professor.full_name'),
                Tables\Columns\TextColumn::make('semester'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('professor')
                    ->relationship('professor', 'first_name'),
                Tables\Filters\SelectFilter::make('semester')
                    ->options([
                        'fall' => 'Fall',
                        'spring' => 'Spring',
                        'summer' => 'Summer',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 