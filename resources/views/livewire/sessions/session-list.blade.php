<div>
   <div class="pagetitle">
      <h1>Sessions</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Session</li>
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
                        <h5 class="card-title">List Of Sessions</h5>

                        <x-alerts />

                        <div class="table-responsive">

                            <table class="table table-hover table-bordered mt-2">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sessions as $session)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $session->name }}</td>
                                            <td><span class="badge bg-info">{{ $session->code }}</span></td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $session->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($session->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="openEditModal({{ $session->id }})"
                                                    class="btn btn-primary btn-sm me-2" title="Edit Class"
                                                    style="background: #1e40af;">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <button wire:click="updateStatus({{ $session->id }})"
                                                    class="btn btn-{{ $session->status === 'active' ? 'warning' : 'success' }} btn-sm"
                                                    title="{{ $session->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                    wire:confirm="Are you sure you want to {{ $session->status === 'active' ? 'deactivate' : 'activate' }} this session?">
                                                    <i
                                                        class="bi bi-{{ $session->status === 'active' ? 'x-circle' : 'check-circle' }}"></i>
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
                                    Showing {{ $sessions->firstItem() }} to {{ $sessions->lastItem() }} of
                                    {{ $sessions->total() }} entries
                                </span>
                            </div>
                            <div>
                                {{ $sessions->links() }}
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
                        <form wire:submit.prevent="updateSession">
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
                                <x-primary-button type="submit" target="updateSession">
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
