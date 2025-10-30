<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Staff extends Component
{
    public $name;
    public $email;
    public $role;


    protected $rules = [
        'name' => 'required|min:3|max:50',
        'email' => 'required|email',
        'role' => 'required',
    ];

    public function create()
    {
        $validated = $this->validate();

        // Add password to the validated data
        $validated['password'] = Hash::make('password1234');

        // Create user
        User::create($validated);

         $this->reset('name', 'email', 'role');

        session()->flash('success', 'Staff created successfully!');
    }
    public function render()
    {
        return view('livewire.staff');
    }
}
