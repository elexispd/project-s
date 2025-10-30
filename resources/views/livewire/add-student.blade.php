<div>
               <div class="card-body">
              <h5 class="card-title">Add Student</h5>

              <form class="row g-3">
                @csrf
                <x-alerts />

                <!-- First Name -->
                <div class="col-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" wire:model="first_name" class="form-control @error('first_name') is-invalid @enderror"
                        id="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Middle Name -->
                <div class="col-6">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" wire:model="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                        id="middle_name" value="{{ old('middle_name') }}">
                    @error('middle_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="col-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" wire:model="last_name" class="form-control @error('last_name') is-invalid @enderror"
                        id="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Admission Year -->
                <div class="col-6">
                    <label for="admission_year" class="form-label">Admission Year</label>
                    <select wire:model="admission_year" id="admission_year" class="form-control @error('admission_year') is-invalid @enderror" required>
                        @for ($i = date('Y'); $i >= date('Y') - 6; $i--)
                            <option value="{{ $i }}" {{ old('admission_year') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('admission_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Class -->
                <div class="col-6">
                    <label for="class" class="form-label">Class</label>
                    <select wire:model="class" id="class" class="form-control @error('class') is-invalid @enderror" required>
                        <option value="" disabled selected>Select Class</option>
                      @foreach ($classes as $schoolClass)
                            <option value="{{ $schoolClass->id }}" {{ old('class') == $schoolClass->name ? 'selected' : '' }}>
                                {{ $schoolClass->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Class Arm -->
                <div class="col-6">
                    <label for="classarm" class="form-label">Class Arm</label>
                    <select wire:model="classarm" id="classarm" class="form-control @error('classarm') is-invalid @enderror" required>
                        <option value="" disabled selected>Select Class Arm</option>
                        <!-- Options will be populated via JavaScript based on class selection -->
                    </select>
                    @error('classarm')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gender -->
                <div class="col-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select wire:model="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                     <!-- Create button -->
                                <button wire:click.prevent="create" class="btn btn-primary"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="create">Create</span>
                                    <span wire:loading wire:target="create">Creating...</span>
                                </button>

                                <!-- Reset button -->
                                <button type="reset" class="btn btn-secondary rounded-pill">Reset</button>
                </div>
            </form>

            </div>
</div>
