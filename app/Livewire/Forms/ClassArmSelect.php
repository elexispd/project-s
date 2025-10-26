<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\On;
use App\Models\ClassArm;
use Livewire\Component;

class ClassArmSelect extends Component
{
    public $selectedClass = '';
    public $selectedClassArm = '';
    public $label = 'Class Arm';
    public $name = 'class_arm_id';
    public $required = false;
    public $placeholder = 'Select Class Arm';

    protected $listeners = ['classSelected' => 'updateClassArms'];

    #[On('classSelected')]
    public function updateClassArms($value)
    {
        $this->selectedClass = $value;
        $this->selectedClassArm = ''; // reset selection when class changes
    }

    public function getClassArmsProperty()
    {
        if (!$this->selectedClass) return collect();

        return ClassArm::where('school_class_id', $this->selectedClass)
                       ->where('status', 'active')
                       ->get();
    }

    public function render()
    {
        return view('livewire.forms.class-arm-select', [
            'classArms' => $this->classArms,
        ]);
    }

}
