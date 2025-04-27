<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_results')
                ->label('Export Results')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $student = $this->record;
                    $results = $student->academicResults()
                        ->with(['course.department', 'course.professor'])
                        ->get()
                        ->groupBy('course.semester');

                    $pdf = Pdf::loadView('pdfs.student-results', [
                        'student' => $student,
                        'results' => $results,
                    ]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        "student-results-{$student->student_id}.pdf"
                    );
                })
                ->color('success')
                ->button(),
        ];
    }
} 