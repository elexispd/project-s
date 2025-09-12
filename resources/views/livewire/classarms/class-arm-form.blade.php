<div>
    <div class="pagetitle">
      <h1>Class Arm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Class Arm</li>
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
              <h5 class="card-title">Add Class Arm</h5>


              <form class="row g-3" wire:submit.prevent="createArm" >
                @csrf
                <x-alerts />

                <div class="col-12">
                  <label for="inputNanme5" class="form-label">Class</label>
                  <select wire:model="school_class_id" id="inputNanme5" class="form-control">
                    <option value="" disabled selected>Select Class</option>
                    @foreach($classes as $class)
                      <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                  </select>
                    @error('school_class_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Class Arm Name</label>
                  <input type="text" wire:model="name" class="form-control" id="inputNanme4">
                </div>

                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="text-center">
                  <x-primary-button type="submit">Create</x-primary-button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>
</div>
