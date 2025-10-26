<div>
    <div class="pagetitle">
        <h1>Class Arm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Class Arm</li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Class Arm List</h5>

                        <!-- Flash Messages -->
                        <x-alerts />

                        <!-- Class Selector -->
                        <div class="mb-3">
                            <label class="form-label">Select Class</label>
                            <select wire:model.live="selectedClassId" class="form-control">
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($selectedClassId)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="bg-info bg-opacity-10">
                                            <th class="py-3 fw-semibold text-info">
                                                <i class="bi bi-hash me-1"></i>ID
                                            </th>
                                            <th class="py-3  fw-semibold text-info">
                                                <i class="bi bi-building me-1"></i>Class
                                            </th>
                                            <th class="py-3  fw-semibold text-info">
                                                <i class="bi bi-diagram-3 me-1"></i>Class Arm
                                            </th>
                                            <th class="py-3  fw-semibold text-info">
                                                <i class="bi bi-circle-fill me-1"></i>Status
                                            </th>
                                            <th class="py-3 fw-semibold text-info text-center">
                                                <i class="bi bi-gear me-1"></i>Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($this->classArms as $arm)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $arm->schoolClass->name }}</td>
                                                <td>{{ $arm->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $arm->status === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($arm->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button wire:click="openEditModal({{ $arm->id }})"
                                                        class="btn btn-primary btn-sm me-2" title="Edit Class Arm">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>

                                                    <button wire:click="updateStatus({{ $arm->id }})"
                                                        class="btn btn-{{ $arm->status === 'active' ? 'danger' : 'success' }} btn-sm"
                                                        title="{{ $arm->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                        wire:confirm="Are you sure you want to {{ $arm->status === 'active' ? 'deactivate' : 'activate' }} this class arm?">
                                                        <i
                                                            class="bi bi-{{ $arm->status === 'active' ? 'x-circle' : 'check-circle' }}"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                                    <p class="text-muted mt-2">No class arms found for this class.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                @if ($this->classArms->hasPages())
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <span class="text-muted">
                                                Showing {{ $this->classArms->firstItem() }} to
                                                {{ $this->classArms->lastItem() }} of {{ $this->classArms->total() }}
                                                entries
                                            </span>
                                        </div>
                                        <div>
                                            {{ $this->classArms->links() }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-folder-plus display-4 text-muted"></i>
                                <p class="text-muted mt-2">Please select a class to view class arms.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Modal -->
    @if ($showModal)
        <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5)" wire:click.self="closeModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class Arm</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateArm">
                            <div class="mb-3">
                                <label class="form-label">Class Arm Name</label>
                                <input type="text" wire:model="editName"
                                    class="form-control @error('editName') is-invalid @enderror"
                                    placeholder="Enter class arm name">
                                @error('editName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-pill" wire:click="closeModal">Cancel</button>
                                <x-primary-button type="submit">
                                    Update
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
