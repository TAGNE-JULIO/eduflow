<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\DisciplinaryRecord;
use Livewire\Component;

class StudentDashboard extends Component
{
    public $assignments = [];
    public $absences = [];
    public $disciplinaryRecords = [];

    public function mount()
    {
        $user = auth()->user();
        
        if ($user->hasRole('student') && $user->studentRecord) {
            $sectionId = $user->studentRecord->section_id;
            
            // Get recent assignments for the student's section or all sections
            $this->assignments = Assignment::with('subject')
                ->where(function($query) use ($sectionId) {
                    $query->where('section_id', $sectionId)
                          ->orWhereNull('section_id');
                })
                ->where('due_date', '>=', now()->toDateString())
                ->orderBy('due_date', 'asc')
                ->take(5)
                ->get();

            // Get recent absences
            $this->absences = Attendance::where('student_id', $user->id)
                ->whereIn('status', ['absent', 'late'])
                ->orderBy('date', 'desc')
                ->take(5)
                ->get();

            // Get recent disciplinary records
            $this->disciplinaryRecords = DisciplinaryRecord::with('author')
                ->where('student_id', $user->id)
                ->orderBy('date', 'desc')
                ->take(3)
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.student-dashboard');
    }
}
