<?php

namespace App\Imports;

use App\Models\Result;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ResultsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    protected $sessionId;
    protected $term;
    protected $schoolClassId;
    protected $classArmId;
    protected $subjectId;
    protected $successCount = 0;
    protected $errorCount = 0;
    protected $errors = [];

    public function __construct($sessionId, $term, $schoolClassId, $classArmId, $subjectId)
    {
        $this->sessionId = $sessionId;
        $this->term = $term;
        $this->schoolClassId = $schoolClassId;
        $this->classArmId = $classArmId;
        $this->subjectId = $subjectId;
    }

    /**
     * Process each row from the Excel file
     */
    public function model(array $row)
    {
        try {
            // Get student_id from the row
            $studentId = $row['student_id'] ?? null;

            if (!$studentId) {
                $this->errorCount++;
                $this->errors[] = "Row skipped: Missing student ID";
                return null;
            }

            // Verify student exists
            $student = Student::find($studentId);
            if (!$student) {
                $this->errorCount++;
                $this->errors[] = "Row {$studentId}: Student not found";
                return null;
            }

            // Check if result already exists
            $existingResult = Result::where('student_id', $studentId)
                ->where('subject_id', $this->subjectId)
                ->where('term', $this->term)
                ->where('session_id', $this->sessionId)
                ->where('school_class_id', $this->schoolClassId)
                ->where('class_arm_id', $this->classArmId)
                ->first();

            if ($existingResult) {
                $this->errorCount++;
                $this->errors[] = "Row {$studentId}: Result already exists for {$student->first_name} {$student->last_name}";
                return null;
            }

            // Get scores from row (handle different column names)
            $ca1 = $this->getScore($row, ['ca1', 'ca_1', 'ca']);
            $ca2 = $this->getScore($row, ['ca2', 'ca_2']);
            $ca3 = $this->getScore($row, ['ca3', 'ca_3']);
            $ca4 = $this->getScore($row, ['ca4', 'ca_4']);
            $exam = $this->getScore($row, ['exam', 'examination']);

            // Calculate total
            $total = ($ca1 ?? 0) + ($ca2 ?? 0) + ($ca3 ?? 0) + ($ca4 ?? 0) + ($exam ?? 0);

            // Calculate grade
            $grade = $this->calculateGrade($total);

            $this->successCount++;

            return new Result([
                'student_id' => $studentId,
                'subject_id' => $this->subjectId,
                'term' => $this->term,
                'session_id' => $this->sessionId,
                'school_class_id' => $this->schoolClassId,
                'class_arm_id' => $this->classArmId,
                'ca' => $ca1,
                'ca2' => $ca2,
                'ca3' => $ca3,
                'ca4' => $ca4,
                'exam' => $exam,
                'total' => $total,
                'grade' => $grade,
            ]);

        } catch (\Exception $e) {
            $this->errorCount++;
            $this->errors[] = "Row error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Get score from row with flexible column naming
     */
    protected function getScore($row, $possibleKeys)
    {
        foreach ($possibleKeys as $key) {
            if (isset($row[$key]) && $row[$key] !== '' && $row[$key] !== null) {
                return (float) $row[$key];
            }
        }
        return null;
    }

    /**
     * Validation rules for the import
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'ca1' => 'nullable|numeric|min:0|max:100',
            'ca2' => 'nullable|numeric|min:0|max:100',
            'ca3' => 'nullable|numeric|min:0|max:100',
            'ca4' => 'nullable|numeric|min:0|max:100',
            'exam' => 'nullable|numeric|min:0|max:100',
        ];
    }

    /**
     * Custom error messages
     */
    public function customValidationMessages()
    {
        return [
            'student_id.required' => 'Student ID is required',
            'student_id.exists' => 'Student ID does not exist',
            'ca1.numeric' => 'CA1 must be a number',
            'ca2.numeric' => 'CA2 must be a number',
            'ca3.numeric' => 'CA3 must be a number',
            'ca4.numeric' => 'CA4 must be a number',
            'exam.numeric' => 'Exam score must be a number',
        ];
    }

    /**
     * Calculate grade based on total
     */
    protected function calculateGrade($total)
    {
        if ($total >= 80) return 'A';
        if ($total >= 70) return 'B';
        if ($total >= 60) return 'C';
        if ($total >= 50) return 'D';
        return 'F';
    }

    /**
     * Handle errors during import
     */
    public function onError(\Throwable $e)
    {
        $this->errorCount++;
        $this->errors[] = $e->getMessage();
    }

    // Getters for success/error tracking
    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
