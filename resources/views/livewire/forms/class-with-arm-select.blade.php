
<div>
    <div class="row">
        <div class="col-md-6">
            <livewire:forms.class-select
                wire:model="selectedClass"
                label="Class"
                name="class_id"
            />
        </div>
        <div class="col-md-6">
            <livewire:forms.class-arm-select
                wire:model="selectedClassArm"
                label="Class Arm"
                name="class_arm_id"
            />
        </div>
    </div>
</div>
