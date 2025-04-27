<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimetableResource\Pages;
use App\Models\Timetable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimetableResource extends Resource
{
    protected static ?string $model = Timetable::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Schedule Information')
                    ->schema([
                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('section_id', null)),

                        Forms\Components\Select::make('section_id')
                            ->relationship('section', 'name', function (Builder $query, $get) {
                                return $query->where('level_id', $get('level_id'));
                            })
                            ->required()
                            ->disabled(fn ($get) => !$get('level_id')),

                        Forms\Components\Select::make('course_id')
                            ->relationship('course', 'name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                                if ($state) {
                                    $course = \App\Models\Course::find($state);
                                    if ($course) {
                                        $set('professor_id', $course->professor_id);
                                    }
                                }
                            }),

                        Forms\Components\Select::make('professor_id')
                            ->relationship('professor', 'first_name')
                            ->required(),

                        Forms\Components\Select::make('day_of_week')
                            ->options([
                                'Monday' => 'Monday',
                                'Tuesday' => 'Tuesday',
                                'Wednesday' => 'Wednesday',
                                'Thursday' => 'Thursday',
                                'Friday' => 'Friday',
                                'Saturday' => 'Saturday',
                                'Sunday' => 'Sunday',
                            ])
                            ->required(),

                        Forms\Components\TimePicker::make('start_time')
                            ->required()
                            ->seconds(false),

                        Forms\Components\TimePicker::make('end_time')
                            ->required()
                            ->seconds(false)
                            ->after('start_time'),

                        Forms\Components\TextInput::make('room')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->options([
                                'lecture' => 'Lecture',
                                'lab' => 'Laboratory',
                                'tutorial' => 'Tutorial',
                            ])
                            ->required(),

                        Forms\Components\Select::make('semester')
                            ->options([
                                'fall' => 'Fall',
                                'spring' => 'Spring',
                                'summer' => 'Summer',
                            ])
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
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('professor.full_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('day_of_week')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('semester')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->relationship('level', 'name'),
                Tables\Filters\SelectFilter::make('section')
                    ->relationship('section', 'name'),
                Tables\Filters\SelectFilter::make('professor')
                    ->relationship('professor', 'first_name'),
                Tables\Filters\SelectFilter::make('semester')
                    ->options([
                        'fall' => 'Fall',
                        'spring' => 'Spring',
                        'summer' => 'Summer',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'lecture' => 'Lecture',
                        'lab' => 'Laboratory',
                        'tutorial' => 'Tutorial',
                    ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimetables::route('/timetables'),
            'create' => Pages\CreateTimetable::route('/timetables/create'),
            'edit' => Pages\EditTimetable::route('/timetables/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }
}