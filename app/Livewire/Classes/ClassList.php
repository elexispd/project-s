<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use App\Models\SchoolClass;
use Livewire\WithPagination;

class ClassList extends Component
{
    use WithPagination;

    public $selectedClass;
    public $editName;
    public $editCode;
    public $editCategory;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'editName' => 'required|string|max:255',
        'editCode' => 'required|string|max:50|unique:school_classes,code',
        'editCategory' => 'required|in:junior,senior',
    ];

    protected $messages = [
        'editName.required' => 'The class name is required.',
        'editCode.required' => 'The class code is required.',
        'editCode.unique' => 'This class code already exists.',
        'editCategory.required' => 'Please select a category.',
    ];

    public function openEditModal($classId)
    {
        $this->selectedClass = SchoolClass::findOrFail($classId);
        $this->editName = $this->selectedClass->name;
        $this->editCode = $this->selectedClass->code;
        $this->editCategory = $this->selectedClass->category;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['editName', 'editCode', 'editCategory', 'selectedClass']);
    }

    public function updateClass()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editCode' => 'required|string|max:50|unique:school_classes,code,' . $this->selectedClass->id,
            'editCategory' => 'required|in:junior,senior',
        ]);

        $this->selectedClass->update([
            'name' => trim($this->editName),
            'code' => trim($this->editCode),
            'category' => $this->editCategory,
        ]);

        $this->closeModal();
        session()->flash('success', 'Class updated successfully.');
    }

    public function updateStatus($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        $newStatus = $class->status === 'active' ? 'inactive' : 'active';

        $class->update(['status' => $newStatus]);
        $s = $newStatus === 'active' ? 'activated' : 'deactivated';
        session()->flash('success', "Class {$s} successfully.");
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $classes = SchoolClass::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        })
        ->latest()
        ->paginate(10);

        return view('livewire.classes.class-list', compact('classes'));
    }
}
