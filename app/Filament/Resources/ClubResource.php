<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClubResource\Pages;
use App\Models\Club;
use Filament\Forms;
use App\Filament\Resources\ClubResource\RelationManagers;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Student Life';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Club Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        Forms\Components\TextInput::make('meeting_schedule')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('max_members')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        Forms\Components\Select::make('professor_id')
                            ->relationship('professor', 'first_name')
                            ->label('Club Advisor')
                            ->required(),
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
                Tables\Columns\TextColumn::make('professor.full_name')
                    ->label('Club Advisor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('meeting_schedule')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_members')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('professor')
                    ->relationship('professor', 'first_name')
                    ->label('Club Advisor'),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClubs::route('/clubs'),
            'create' => Pages\CreateClub::route('/clubs/create'),
            'edit' => Pages\EditClub::route('/clubs/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }
} 