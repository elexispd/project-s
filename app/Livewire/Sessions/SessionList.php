<?php

namespace App\Livewire\Sessions;

use Livewire\Component;
use App\Models\Session;
use Livewire\WithPagination;

class SessionList extends Component
{
    use WithPagination;

    public $selectedSession;
    public $editName;
    public $editCode;
    public $showModal = false;

     protected $rules = [
        'editName' => 'required|string|max:255',
        'editCode' => 'required|string|max:50|unique:sessions,code',
    ];

    protected $messages = [
        'editName.required' => 'The class name is required.',
        'editCode.required' => 'The class code is required.',
        'editCode.unique' => 'This class code already exists.',
    ];

    public function openEditModal($classId)
    {
        $this->selectedSession = Session::findOrFail($classId);
        $this->editName = $this->selectedSession->name;
        $this->editCode = $this->selectedSession->code;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['editName', 'editCode', 'selectedSession']);
    }

    public function updateSession()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editCode' => 'required|string|max:50|unique:school_classes,code,' . $this->selectedSession->id,
        ]);

        $this->selectedSession->update([
            'name' => trim($this->editName),
            'code' => trim($this->editCode),
        ]);

        $this->closeModal();
        session()->flash('success', 'Session updated successfully.');
    }

    public function updateStatus($classId)
    {
        $class = Session::findOrFail($classId);
        $newStatus = $class->status === 'active' ? 'inactive' : 'active';

        $class->update(['status' => $newStatus]);

        session()->flash('success', "Class {$newStatus}d successfully.");
    }



    public function render()
    {
        $sessions = Session::paginate(10);
        return view('livewire.sessions.session-list', [
            'sessions' => $sessions
        ]);
    }
}
