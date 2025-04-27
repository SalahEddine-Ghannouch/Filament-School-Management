<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Results - {{ $student->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .student-info {
            margin-bottom: 30px;
        }
        .semester-section {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .summary {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Academic Results</h1>
        <h2>{{ config('app.name') }}</h2>
    </div>

    <div class="student-info">
        <h3>Student Information</h3>
        <p><strong>Name:</strong> {{ $student->full_name }}</p>
        <p><strong>ID:</strong> {{ $student->student_id }}</p>
        <p><strong>Level:</strong> {{ $student->level->name }}</p>
        <p><strong>Section:</strong> {{ $student->section->name }}</p>
    </div>

    @foreach($results as $semester => $semesterResults)
        <div class="semester-section">
            <h3>{{ ucfirst($semester) }} Semester</h3>
            <table>
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Department</th>
                        <th>Professor</th>
                        <th>Midterm</th>
                        <th>Final</th>
                        <th>Total</th>
                        <th>Grade</th>
                        <th>GPA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semesterResults as $result)
                        <tr>
                            <td>{{ $result->course->code }}</td>
                            <td>{{ $result->course->name }}</td>
                            <td>{{ $result->course->department->name }}</td>
                            <td>{{ $result->course->professor->full_name }}</td>
                            <td>{{ $result->midterm_mark }}</td>
                            <td>{{ $result->final_mark }}</td>
                            <td>{{ $result->total_mark }}</td>
                            <td>{{ $result->grade }}</td>
                            <td>{{ $result->gpa }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary">
                <p><strong>Semester GPA:</strong> {{ $semesterResults->avg('gpa') }}</p>
                <p><strong>Total Credits:</strong> {{ $semesterResults->sum('course.credits') }}</p>
            </div>
        </div>
    @endforeach

    <div class="summary">
        <h3>Overall Summary</h3>
        <p><strong>Cumulative GPA:</strong> {{ $results->flatten()->avg('gpa') }}</p>
        <p><strong>Total Credits Completed:</strong> {{ $results->flatten()->sum('course.credits') }}</p>
    </div>
</body>
</html> 