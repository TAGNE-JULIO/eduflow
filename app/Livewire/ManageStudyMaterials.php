<?php

namespace App\Livewire;

use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ManageStudyMaterials extends Component
{
    use WithPagination, WithFileUploads;

    public $subjects = [];
    public $sections = [];
    
    public $title;
    public $description;
    public $subject_id;
    public $section_id;
    public $file;

    public $showCreateForm = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'subject_id' => 'required|exists:subjects,id',
        'section_id' => 'nullable|exists:sections,id',
        'file' => 'required|file|max:20480', // 20MB max for materials
    ];

    public function mount()
    {
        $this->subjects = Subject::all();
        $this->sections = Section::all();
    }

    public function saveMaterial()
    {
        $this->validate();

        $filePath = null;
        if ($this->file) {
            $filePath = $this->file->store('study-materials', 'public');
        }

        StudyMaterial::create([
            'title' => $this->title,
            'description' => $this->description,
            'subject_id' => $this->subject_id,
            'section_id' => $this->section_id ?: null,
            'file_path' => $filePath,
        ]);

        $this->reset(['title', 'description', 'subject_id', 'section_id', 'file', 'showCreateForm']);
        
        session()->flash('success', 'Study material uploaded successfully.');
    }

    public function render()
    {
        return view('livewire.manage-study-materials', [
            'materials' => StudyMaterial::with(['subject', 'section'])->orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
}
