<?php

namespace App\Livewire\Classarms;

use Livewire\Component;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ClassArmList extends Component
{
    use WithPagination;

    public $selectedClassId = '';
    public $selectedArm = null;
    public $editName = '';
    public $showModal = false;
    public $classes;

    public function mount()
    {
        $this->classes = SchoolClass::where('status', 'active')->get();
    }

    public function updatedSelectedClassId()
    {
        $this->resetPage();
    }

    public function getClassArmsProperty()
    {
        if (!$this->selectedClassId) {
            return collect();
        }

        return ClassArm::where('school_class_id', $this->selectedClassId)
            ->with('schoolClass')
            ->latest()
            ->paginate(10);
    }

    public function openEditModal($armId)
    {
        $this->selectedArm = ClassArm::findOrFail($armId);
        $this->editName = $this->selectedArm->name;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['selectedArm', 'editName']);
        $this->resetValidation();
    }

    public function updateArm()
    {
        $this->validate([
            'editName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('class_arms', 'name')
                    ->where('school_class_id', $this->selectedArm->school_class_id)
                    ->ignore($this->selectedArm->id)
            ]
        ]);

        $this->selectedArm->update(['name' => trim($this->editName)]);
        $this->closeModal();
        session()->flash('success', 'Class arm updated successfully.');
    }

    public function updateStatus($armId)
    {
        $arm = ClassArm::findOrFail($armId);
        $newStatus = $arm->status === 'active' ? 'inactive' : 'active';
        $s = $newStatus === 'active' ? 'activated' : 'deactivated';
        $arm->update(['status' => $newStatus]);

        session()->flash('success', "Class arm {$s} successfully.");
    }

    public function render()
    {
        return view('livewire.classarms.class-arm-list');
    }
}
