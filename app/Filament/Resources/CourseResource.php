<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use App\Filament\Resources\CourseResource\RelationManagers;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Course Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        Forms\Components\TextInput::make('credits')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name')
                            ->required(),
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required(),
                        Forms\Components\Select::make('professor_id')
                            ->relationship('professor', 'first_name')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Schedule Information')
                    ->schema([
                        Forms\Components\Select::make('semester')
                            ->options([
                                'fall' => 'Fall',
                                'spring' => 'Spring',
                                'summer' => 'Summer',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('max_students')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'cancelled' => 'Cancelled',
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
                Tables\Columns\TextColumn::make('professor.full_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'cancelled' => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('professor')
                    ->relationship('professor', 'first_name'),
                Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('level')
                    ->relationship('level', 'name'),
                Tables\Filters\SelectFilter::make('semester')
                    ->options([
                        'fall' => 'Fall',
                        'spring' => 'Spring',
                        'summer' => 'Summer',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'cancelled' => 'Cancelled',
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
            'index' => Pages\ListCourses::route('/courses'),
            'create' => Pages\CreateCourse::route('/courses/create'),
            'edit' => Pages\EditCourse::route('/courses/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }
} 