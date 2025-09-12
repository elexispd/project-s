<?php

namespace App\Livewire\Classarms;

use App\Models\SchoolClass;
use App\Models\ClassArm;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ClassArmForm extends Component
{
    #[Validate('required|integer|exists:school_classes,id')]
    public $school_class_id = '';

    #[Validate('required|string|max:255')]
    public $name = '';

    public function createArm()
    {
        $this->validate([
            'school_class_id' => 'required|integer|exists:school_classes,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('class_arms')->where(function ($query) {
                    return $query->where('school_class_id', $this->school_class_id);
                })
            ],
        ]);

        try {
            ClassArm::create([
                'school_class_id' => $this->school_class_id,
                'name' => trim($this->name),
            ]);

            $this->reset(['school_class_id', 'name']);
            session()->flash('success', 'Class arm created successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating class arm: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $classes = SchoolClass::where('status', 'active')->get();
        return view('livewire.classarms.class-arm-form', [
            "classes" => $classes
        ]);
    }
}
