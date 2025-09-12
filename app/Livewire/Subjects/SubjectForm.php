<?php

namespace App\Livewire\Subjects;

use App\Models\Subject;
use Livewire\Component;

class SubjectForm extends Component
{

    public $name;
    public $code;

    protected $rules = [
        'name' => 'required|string|max:255|unique:subjects,name',
        'code' => 'required|string|max:50|unique:subjects,code'
    ];

    protected $messages = [
        'name.required' => 'The subject name is required.',
        'code.required' => 'The subject code is required.',
        'code.unique' => 'This subject code already exists.',
        'name.unique' => 'This subject already exists.'
    ];

    public function createSubject()
    {
        $this->validate();

        try {
            Subject::create([
                'name' => trim($this->name),
                'code' => trim($this->code)
            ]);

            $this->resetForm();
            session()->flash('success', 'Subject created successfully.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating subject: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'code']);
        $this->resetErrorBag();
    }

    // This enables real-time validation as users type
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.subjects.subject-form');
    }
}
