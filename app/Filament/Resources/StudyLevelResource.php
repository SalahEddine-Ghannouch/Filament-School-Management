<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyLevelResource\Pages;
use App\Models\StudyLevel;
use Filament\Forms;
use Filament\Forms\Form;
use App\Filament\Resources\StudyLevelResource\RelationManagers;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudyLevelResource extends Resource
{
    protected static ?string $model = StudyLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Level Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required()
                            ->minValue(1),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    }),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class,
            RelationManagers\CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudyLevels::route('/study-levels'),
            'create' => Pages\CreateStudyLevel::route('/study-levels/create'),
            'edit' => Pages\EditStudyLevel::route('/study-levels/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }
} 