<div>
    <div class="pagetitle">
        <h1>Subjects</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Subjects</li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Subject List</h5>
                        <x-alerts />
                        <div class="table-responsive">
                            <div style="display:flex; justify-content: end;">

                                <input type="search" wire:model.live.debounce.300ms="search" style="width: 200px;"
                                    class="form-control " placeholder="Search classes..." aria-label="Search">
                                @if ($search)
                                    <button class="btn btn-outline-secondary" type="button" wire:click="clearSearch">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @else
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                @endif
                            </div>

                            <table class="table table-hover table-bordered mt-2">
                                <thead>
                                    <tr class="bg-info bg-opacity-10">
                                        <th class="py-3 fw-semibold text-info">
                                            <i class="bi bi-hash me-1"></i>ID
                                        </th>
                                        <th class="py-3  fw-semibold text-info">
                                            <i class="bi bi-building me-1"></i>Name
                                        </th>
                                        <th class="py-3  fw-semibold text-info">
                                            <i class="bi bi-circle me-1"></i>Code
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
                                    @forelse($subjects as $subject)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->code }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $subject->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($subject->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="openEditModal({{ $subject->id }})"
                                                    class="btn btn-primary btn-sm me-2" title="Edit Class"
                                                    style="background: #1e40af;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <button wire:click="updateStatus({{ $subject->id }})"
                                                    class="btn btn-{{ $subject->status === 'active' ? 'warning' : 'success' }} btn-sm"
                                                    title="{{ $subject->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                    wire:confirm="Are you sure you want to {{ $subject->status === 'active' ? 'deactivate' : 'activate' }} this subject?">
                                                    <i
                                                        class="bi bi-{{ $subject->status === 'active' ? 'x-circle' : 'check-circle' }}"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Subjects found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="text-muted">
                                    Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of
                                    {{ $subjects->total() }} entries
                                </span>
                            </div>
                            <div>
                                {{ $subjects->links() }}
                            </div>
                        </div>

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
                        <h5 class="modal-title">Edit Class</h5>
                        <span type="button" class="btn-close" wire:click="closeModal"></span>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateSubject">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" wire:model="editName"
                                    class="form-control @error('editName') is-invalid @enderror">
                                @error('editName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" wire:model="editCode"
                                    class="form-control @error('editCode') is-invalid @enderror">
                                @error('editCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                                <x-primary-button type="submit" target="updateSubject">
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
