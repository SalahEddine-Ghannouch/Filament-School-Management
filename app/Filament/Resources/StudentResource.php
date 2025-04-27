<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 1;

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
                            ->directory('students'),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required(),
                        Forms\Components\DatePicker::make('admission_date')
                            ->required(),
                        Forms\Components\TextInput::make('student_id')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Academic Information')
                    ->schema([
                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name')
                            ->required(),
                        Forms\Components\Select::make('section_id')
                            ->relationship('section', 'name')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Parent/Guardian Information')
                    ->schema([
                        Forms\Components\TextInput::make('parent_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('parent_phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('parent_email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emergency_contact')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Medical Information')
                    ->schema([
                        Forms\Components\TextInput::make('blood_group')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('medical_conditions')
                            ->maxLength(65535),
                    ]),

                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'graduated' => 'Graduated',
                        'suspended' => 'Suspended',
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
                Tables\Columns\TextColumn::make('student_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'graduated' => 'info',
                        'suspended' => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->relationship('level', 'name'),
                Tables\Filters\SelectFilter::make('section')
                    ->relationship('section', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'graduated' => 'Graduated',
                        'suspended' => 'Suspended',
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
            RelationManagers\AttendancesRelationManager::class,
            RelationManagers\AcademicResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/students/create'),
            'edit' => Pages\EditStudent::route('/students/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Academic Management';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-academic-cap';
    }

    public static function canViewAny(): bool
    {
        return User::hasPermissionTo('view_students');
    }

    public static function canCreate(): bool
    {
        return User::hasPermissionTo('create_students');
    }

    public static function canEdit(Model $record): bool
    {
        return User::hasPermissionTo('edit_students');
    }

    public static function canDelete(Model $record): bool
    {
        return User::hasPermissionTo('delete_students');
    }
}
