<?php

namespace App\Filament\Pages;

use App\Models\Student;
use App\Models\Professor;
use App\Models\Course;
use App\Models\Club;
use App\Models\Department;
use App\Models\ClassSection;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Widgets\StatsOverviewWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
        ];
    }
}

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // return [
        //     Stat::make('Total Students', Student::count())
        //         ->description('Active students in all levels')
        //         ->descriptionIcon('heroicon-m-academic-cap')
        //         ->chart([7, 3, 4, 5, 6, 3, 5, 3])
        //         ->color('success'),

        //     Stat::make('Total Professors', Professor::count())
        //         ->description('Teaching staff members')
        //         ->descriptionIcon('heroicon-m-user-group')
        //         ->chart([3, 5, 4, 3, 4, 5, 4, 3])
        //         ->color('info'),

        //     Stat::make('Active Courses', Course::where('status', 'active')->count())
        //         ->description('Currently running courses')
        //         ->descriptionIcon('heroicon-m-book-open')
        //         ->chart([4, 3, 5, 4, 3, 4, 3, 4])
        //         ->color('warning'),

        //     Stat::make('Departments', Department::count())
        //         ->description('Academic departments')
        //         ->descriptionIcon('heroicon-m-building-office-2')
        //         ->chart([2, 3, 2, 3, 2, 3, 2, 3])
        //         ->color('danger'),

        //     Stat::make('Class Sections', ClassSection::where('status', 'active')->count())
        //         ->description('Active class sections')
        //         ->descriptionIcon('heroicon-m-user-group')
        //         ->chart([5, 4, 6, 5, 4, 5, 4, 5])
        //         ->color('primary'),

        //     Stat::make('Student Clubs', Club::where('status', 'active')->count())
        //         ->description('Active student clubs')
        //         ->descriptionIcon('heroicon-m-user-plus')
        //         ->chart([2, 3, 2, 3, 4, 3, 4, 3])
        //         ->color('success'),

        //     Stat::make('Male Students', Student::where('gender', 'male')->count())
        //         ->description('Total male students')
        //         ->descriptionIcon('heroicon-m-user')
        //         ->chart([4, 5, 4, 5, 4, 5, 4, 5])
        //         ->color('info'),

        //     Stat::make('Female Students', Student::where('gender', 'female')->count())
        //         ->description('Total female students')
        //         ->descriptionIcon('heroicon-m-user')
        //         ->chart([3, 4, 3, 4, 3, 4, 3, 4])
        //         ->color('warning'),

        //     Stat::make('Active Students', Student::where('status', 'active')->count())
        //         ->description('Currently enrolled')
        //         ->descriptionIcon('heroicon-m-check-circle')
        //         ->chart([6, 5, 7, 6, 5, 6, 5, 6])
        //         ->color('success'),
        // ];
        return [
            
        ];
    }
} 