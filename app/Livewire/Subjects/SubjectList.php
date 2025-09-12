<?php

namespace App\Livewire\Subjects;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectList extends Component
{
    use WithPagination;

    public $selectedSubject;
    public $editName;
    public $editCode;
    public $showModal = false;
    public $search = '';


    protected $rules = [
        'editName' => 'required|string|max:255|unique:subjects,name',
        'editCode' => 'required|string|max:50|unique:subjects,code',
    ];

    protected $messages = [
        'editName.required' => 'The class name is required.',
        'editCode.required' => 'The class code is required.',
        'editCode.unique' => 'This class code already exists.',
    ];


    public function openEditModal($subjectId)
    {
        $this->selectedSubject = Subject::findOrFail($subjectId);
        $this->editName = $this->selectedSubject->name;
        $this->editCode = $this->selectedSubject->code;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['editName', 'editCode',  'selectedSubject']);
    }

    public function updateSubject()
    {

        $validated = $this->validate([
            'editName' => 'required|string|max:255',
            'editCode' => 'required|string|max:50|unique:subjects,code'
        ]);

        $this->selectedSubject->update([
            'name' => trim($validated['editName']),
            'code' => trim($validated['editCode']),
        ]);

        $this->closeModal();
        session()->flash('success', 'Subject updated successfully.');
    }

    public function updateStatus($subjectId)
    {
        $class = Subject::findOrFail($subjectId);
        $newStatus = $class->status === 'active' ? 'inactive' : 'active';

        $class->update(['status' => $newStatus]);
        $s = $newStatus === 'active' ? 'activated' : 'deactivated';
        session()->flash('success', "Subject {$s} successfully.");
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $subjects = Subject::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%');
            });
        })
        ->orderBy('name', 'asc')
        ->paginate();

        return view('livewire.subjects.subject-list', [
            'subjects' => $subjects
        ]);
    }
}
