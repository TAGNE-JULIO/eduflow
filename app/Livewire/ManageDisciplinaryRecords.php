<?php

namespace App\Livewire;

use App\Models\DisciplinaryRecord;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageDisciplinaryRecords extends Component
{
    use WithPagination;

    public $students = [];
    
    // Form fields
    public $student_id;
    public $title;
    public $type = 'warning';
    public $description;
    public $date;

    public $showCreateForm = false;

    protected $rules = [
        'student_id' => 'required|exists:users,id',
        'title' => 'required|string|max:255',
        'type' => 'required|in:merit,warning,suspension',
        'description' => 'nullable|string',
        'date' => 'required|date',
    ];

    public function mount()
    {
        $this->students = User::students()->get();
        $this->date = date('Y-m-d');
    }

    public function saveRecord()
    {
        $this->validate();

        DisciplinaryRecord::create([
            'student_id' => $this->student_id,
            'author_id' => auth()->id(),
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'date' => $this->date,
        ]);

        $this->reset(['student_id', 'title', 'type', 'description', 'showCreateForm']);
        $this->date = date('Y-m-d');
        $this->type = 'warning';
        
        session()->flash('success', 'Disciplinary record added successfully.');
    }

    public function render()
    {
        return view('livewire.manage-disciplinary-records', [
            'records' => DisciplinaryRecord::with(['student', 'author'])->orderBy('date', 'desc')->paginate(10)
        ]);
    }
}
