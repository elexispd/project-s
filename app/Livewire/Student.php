<?php

use App\Models\SchoolClass;
use Livewire\Component;
use App\Models\Student as ModelsStudent;
use App\Services\AdmissionNumberService;
use Illuminate\Support\Str;


class Student extends Component
{
    public $first_name, $middle_name, $last_name, $admission_year, $class, $gender, $classarm;
    public $classes; // add this

    protected $admissionService;

    public function mount()
    {
        $this->admissionService = app(AdmissionNumberService::class);

        // Populate classes for the dropdown
        $this->classes = SchoolClass::where('status', 'active')->get();
    }

    protected function rules()
    {
        return [
            'first_name'     => 'required|string|max:255',
            'middle_name'    => 'nullable|string|max:255',
            'last_name'      => 'required|string|max:255',
            'admission_year' => 'required|digits:4|integer|min:2015|max:' . (date('Y') + 1),
            'class'          => 'required|exists:school_classes,id',
            'classarm'       => 'required|string',
            'gender'         => 'required|in:male,female',
        ];
    }

    public function create()
    {
        dd('test');
        $validated = $this->validate();

        $admissionNumber = $this->admissionService->generate($validated['admission_year']);

        ModelsStudent::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'admission_number' => $admissionNumber,
            'admission_year' => $validated['admission_year'],
            'school_class_id' => $validated['class'],
            'class_arm' => $validated['classarm'],
            'gender' => $validated['gender'],
            'result_pin' => \Illuminate\Support\Str::random(8),
        ]);

        $this->reset(['first_name','middle_name','last_name','admission_year','class','gender','classarm']);
        session()->flash('success', "Student created successfully. Admission Number: $admissionNumber");
    }

    public function created(){
        dd('test');
    }

  public function render()
{
    return view('livewire.student');
}

}
