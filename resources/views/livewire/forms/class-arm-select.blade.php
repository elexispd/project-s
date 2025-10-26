<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        wire:model="selectedClassArm"
        class="form-control @error($name) is-invalid @enderror"
        @if($required) required @endif
        @if(!$this->selectedClass) disabled @endif
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($this->classArms as $arm)
            <option value="{{ $arm->id }}">{{ $arm->name }}</option>
        @endforeach
    </select>
    @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror

    @if(!$this->selectedClass)
        <div class="form-text text-muted">Please select a class first</div>
    @endif
</div>
