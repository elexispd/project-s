<div>
    <div class="pagetitle">
        <h1>Classes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Class</li>
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
                        <h5 class="card-title">Class List</h5>

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
                                            <i class="bi bi-diagram-3 me-1"></i>Category
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
                                    @forelse($classes as $class)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td><span class="">{{ $class->code }}</span></td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $class->category === 'senior' ? 'primary' : 'info' }}">
                                                    {{ ucfirst($class->category) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $class->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($class->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="openEditModal({{ $class->id }})"
                                                    class="btn btn-primary btn-sm me-2" title="Edit Class"
                                                    style="background: #1e40af;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <button wire:click="updateStatus({{ $class->id }})"
                                                    class="btn btn-{{ $class->status === 'active' ? 'warning' : 'success' }} btn-sm"
                                                    title="{{ $class->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                    wire:confirm="Are you sure you want to {{ $class->status === 'active' ? 'deactivate' : 'activate' }} this class?">
                                                    <i
                                                        class="bi bi-{{ $class->status === 'active' ? 'x-circle' : 'check-circle' }}"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 text-muted"></i>
                                                <p class="text-muted mt-2">No classes found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="text-muted">
                                    Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of
                                    {{ $classes->total() }} entries
                                </span>
                            </div>
                            <div>
                                {{ $classes->links() }}
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
                        <form wire:submit.prevent="updateClass">
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

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select wire:model="editCategory"
                                    class="form-control @error('editCategory') is-invalid @enderror">
                                    <option value="" disabled>Select Category</option>
                                    <option value="junior">Junior</option>
                                    <option value="senior">Senior</option>
                                </select>
                                @error('editCategory')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-pill" wire:click="closeModal">Cancel</button>
                                <x-primary-button type="submit" target="updateClass">
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
