<?php

namespace App\Livewire\Classes;

use Livewire\Component;
use App\Models\SchoolClass;

class ClassForm extends Component
{
    public $name;
    public $code;
    public $category;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:school_classes,code',
        'category' => 'required|in:junior,senior',
    ];

    protected $messages = [
        'name.required' => 'The class name is required.',
        'code.required' => 'The class code is required.',
        'code.unique' => 'This class code already exists.',
        'category.required' => 'Please select a category.',
        'category.in' => 'Please select a valid category.',
    ];

    public function createClass()
    {
        $this->validate();

        try {
            SchoolClass::create([
                'name' => trim($this->name),
                'code' => trim($this->code),
                'category' => $this->category,
                'status' => 'active'
            ]);

            $this->resetForm();
            session()->flash('success', 'Class created successfully.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating class: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'code', 'category']);
        $this->resetErrorBag();
    }

    // This enables real-time validation as users type
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.classes.class-form');
    }
}
