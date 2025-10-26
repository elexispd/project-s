<?php

namespace App\Livewire\Forms;

use App\Models\SchoolClass;
use Livewire\Component;

class ClassSelect extends Component
{
    public $selectedClass = '';
    public $label = 'Class';
    public $name = 'class_id';
    public $required = false;
    public $placeholder = 'Select Class';

    public function updatedSelectedClass($value)
    {
        $this->dispatch('classSelected', $value)->to('*');
    }

    public function render()
    {
        $classes = SchoolClass::where('status', 'active')->get();

        return view('livewire.forms.class-select', compact('classes'));
    }
}
