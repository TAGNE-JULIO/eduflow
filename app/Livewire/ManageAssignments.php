<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ManageAssignments extends Component
{
    use WithPagination, WithFileUploads;

    public $subjects = [];
    public $sections = [];
    
    public $title;
    public $description;
    public $subject_id;
    public $section_id;
    public $due_date;
    public $file;

    public $showCreateForm = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'subject_id' => 'required|exists:subjects,id',
        'section_id' => 'nullable|exists:sections,id',
        'due_date' => 'required|date',
        'file' => 'nullable|file|max:10240', // 10MB max
    ];

    public function mount()
    {
        $this->subjects = Subject::all();
        $this->sections = Section::all();
        $this->due_date = date('Y-m-d');
    }

    public function saveAssignment()
    {
        $this->validate();

        $filePath = null;
        if ($this->file) {
            $filePath = $this->file->store('assignments', 'public');
        }

        Assignment::create([
            'title' => $this->title,
            'description' => $this->description,
            'subject_id' => $this->subject_id,
            'section_id' => $this->section_id ?: null,
            'due_date' => $this->due_date,
            'file_path' => $filePath,
        ]);

        $this->reset(['title', 'description', 'subject_id', 'section_id', 'file', 'showCreateForm']);
        $this->due_date = date('Y-m-d');
        
        session()->flash('success', 'Assignment created successfully.');
    }

    public function render()
    {
        return view('livewire.manage-assignments', [
            'assignments' => Assignment::with(['subject', 'section'])->orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
}
