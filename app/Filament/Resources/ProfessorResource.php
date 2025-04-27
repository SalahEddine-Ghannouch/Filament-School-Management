<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfessorResource\Pages;
use App\Models\Professor;
use Filament\Forms;
use App\Filament\Resources\ProfessorResource\RelationManagers;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfessorResource extends Resource
{
    protected static ?string $model = Professor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
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
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('professors'),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required(),
                        Forms\Components\DatePicker::make('hire_date')
                            ->required(),
                        Forms\Components\TextInput::make('employee_id')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Professional Information')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('specialization')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('qualification')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('bio')
                            ->maxLength(65535),
                    ])->columns(2),

                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'on_leave' => 'On Leave',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('employee_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('specialization')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'on_leave' => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'on_leave' => 'On Leave',
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
            RelationManagers\CoursesRelationManager::class,
            RelationManagers\ClubsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfessors::route('/professors'),
            'create' => Pages\CreateProfessor::route('/professors/create'),
            'edit' => Pages\EditProfessor::route('/professors/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }
} 