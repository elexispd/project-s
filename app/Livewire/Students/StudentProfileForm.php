<?php

namespace App\Livewire\Students;

use App\Models\Student;
use Livewire\Component;

class StudentProfileForm extends Component
{
    public $student;
    public $class_id;
    public $class_arm_id;

    public function mount(Student $student)
    {
        $this->student = $student;
    }

    public function suspend()
    {
        $this->student->status = 'suspended';
        $this->student->save();
        $this->student->refresh();
    }

    public function activate()
    {
        $this->student->status = 'active';
        $this->student->save();
        $this->student->refresh();
    }

    public function bringBackStudent()
    {
        $this->validate([
            'class_id' => 'required|exists:school_classes,id',
            'class_arm_id' => 'required|exists:class_arms,id',
        ]);

        $this->student->update([
            'graduated_at' => null,
            'status' => 'active',
            'school_class_id' => $this->class_id,
            'class_arm_id' => $this->class_arm_id,
        ]);

        session()->flash('success', 'Student has been brought back successfully.');
        $this->reset(['class_id', 'class_arm_id']);
    }

    public function render()
    {
        return view('livewire.students.student-profile-form', [
            'classes' => \App\Models\SchoolClass::where('status', 'active')->get(),
            'classArms' => \App\Models\ClassArm::where('status', 'active')->get(),
        ]);
    }
}
