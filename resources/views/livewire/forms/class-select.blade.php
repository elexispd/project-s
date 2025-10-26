<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        wire:model="selectedClass"
        class="form-control @error($name) is-invalid @enderror"
        @if($required) required @endif
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }}</option>
        @endforeach
    </select>
    @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
