<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AcademicResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'academicResults';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Forms\Components\TextInput::make('academic_year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('semester')
                    ->options([
                        'fall' => 'Fall',
                        'spring' => 'Spring',
                        'summer' => 'Summer',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('grade')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('score')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('professor_id')
                    ->relationship('professor', 'first_name')
                    ->required(),
                Forms\Components\Textarea::make('remarks')
                    ->maxLength(65535),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.name'),
                Tables\Columns\TextColumn::make('academic_year'),
                Tables\Columns\TextColumn::make('semester'),
                Tables\Columns\TextColumn::make('grade'),
                Tables\Columns\TextColumn::make('score'),
                Tables\Columns\TextColumn::make('professor.full_name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('course', 'name'),
                Tables\Filters\SelectFilter::make('academic_year'),
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