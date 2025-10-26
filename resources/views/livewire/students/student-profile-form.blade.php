<div>
    <div class="mt-4 d-flex justify-content-start gap-3">
        @if ($student->status === 'active')
            <button wire:click="suspend" class="btn btn-warning btn-lg px-4">
                <i class="bi bi-pause-circle me-2"></i> Suspend
            </button>
        @else
            <button wire:click="activate" class="btn btn-success btn-lg px-4">
                <i class="bi bi-play-circle me-2"></i> Activate
            </button>
        @endif

        @if ($student->graduated_at)
            <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#bringBackModal">
                <i class="bi bi-arrow-repeat me-2"></i> Bring Back Student
            </button>
        @endif
    </div>

    <!-- Bring Back Modal -->
    <div class="modal fade" id="bringBackModal" tabindex="-1" aria-labelledby="bringBackModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="bringBackModalLabel">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Bring Back Student
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="bringBackStudent">
                    <div class="modal-body">
                        <x-alerts />
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select wire:model="class_id" id="class" class="form-select">
                                <option value="">-- Select Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="class_arm_id" class="form-label">Class Arm</label>
                            <select wire:model="class_arm_id" id="classarm" class="form-select">
                                <option value="">-- Select Class Arm --</option>
                            </select>
                            @error('class_arm_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill rounded-pill px-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-circle me-2"></i> Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.partials.class-arm')

</div>
