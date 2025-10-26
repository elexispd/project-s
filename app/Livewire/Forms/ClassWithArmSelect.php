<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class ClassWithArmSelect extends Component
{
    public $selectedClass = '';
    public $selectedClassArm = '';

    public function updatedSelectedClass($value)
    {
        $this->dispatch('classSelected', classId: $value);
    }

    public function render()
    {
        return view('livewire.forms.class-with-arm-select');
    }
}
