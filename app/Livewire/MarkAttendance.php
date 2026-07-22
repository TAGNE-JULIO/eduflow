<?php

namespace App\Livewire;

use App\Models\MyClass;
use App\Models\Section;
use App\Models\User;
use App\Models\Attendance;
use Livewire\Component;

class MarkAttendance extends Component
{
    public $classes = [];
    public $sections = [];
    public $students = [];

    public $selectedClass = null;
    public $selectedSection = null;
    public $attendanceDate;

    public $attendances = []; // To hold student_id => status

    public function mount()
    {
        $this->classes = MyClass::all();
        $this->attendanceDate = date('Y-m-d');
    }

    public function updatedSelectedClass($classId)
    {
        $this->sections = Section::where('my_class_id', $classId)->get();
        $this->selectedSection = null;
        $this->students = [];
    }

    public function updatedSelectedSection($sectionId)
    {
        $this->loadStudents();
    }

    public function updatedAttendanceDate()
    {
        $this->loadStudents();
    }

    public function loadStudents()
    {
        if ($this->selectedSection && $this->selectedClass) {
            $this->students = User::whereHas('studentRecord', function($query) {
                $query->where('my_class_id', $this->selectedClass)
                      ->where('section_id', $this->selectedSection);
            })->get();

            // Load existing attendance
            foreach ($this->students as $student) {
                $record = Attendance::where('student_id', $student->id)
                    ->where('section_id', $this->selectedSection)
                    ->where('date', $this->attendanceDate)
                    ->first();
                
                $this->attendances[$student->id] = $record ? $record->status : 'present';
            }
        }
    }

    public function saveAttendance()
    {
        foreach ($this->attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'section_id' => $this->selectedSection,
                    'date' => $this->attendanceDate
                ],
                [
                    'status' => $status
                ]
            );
        }

        session()->flash('success', 'Attendance saved successfully!');
    }

    public function render()
    {
        return view('livewire.mark-attendance');
    }
}
