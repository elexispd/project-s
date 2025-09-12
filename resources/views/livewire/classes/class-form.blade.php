<div>
    <div class="pagetitle">
      <h1>Class</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Class</li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Class</h5>


              <form wire:submit.prevent="createClass" class="row g-3" method="POST" action="{{ route('classes.store') }}" >
                @csrf
                <x-alerts />
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Name</label>
                  <input type="text" wire:model="name"  class="form-control" id="inputNanme4">
                  @error('name')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <label for="inputNanme5" class="form-label">Code</label>
                  <input type="text" wire:model="code" class="form-control" id="inputNanme5">
                  @error('code')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-12">
                  <label for="inputNanme6" class="form-label">Category</label>
                  <select wire:model="category" id="inputNae6" class="form-control">
                    <option value="" disabled selected>Select Category</option>
                    <option value="junior">Junior</option>
                    <option value="senior">Senior</option>
                  </select>
                  @error('category')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="text-center">
                    <x-primary-button target="createClass"  type="submit">
                        Create
                    </x-primary-button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>



            </div>
          </div>

        </div>
      </div>
    </section>
</div>
