@extends('layouts.portal')

@section('content')
    <div class="pagetitle">
        <h1>Student(s) Promotion</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Students</li>
                <li class="breadcrumb-item active">Promotion</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Student Promotion</h5>
                    </div>
                    <div class="card-body">
                        <x-alerts />

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                <strong>There were some problems with your input:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('promotions.promote') }}">
                            @csrf

                            <input type="hidden" name="from_class_id" value="{{ request('class') }}">
                            <input type="hidden" name="from_class_arm_id" value="{{ request('classarm') }}">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Student Name</th>
                                        <th>Current Class</th>
                                        <th>Current Arm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}">
                                            </td>
                                            <td>{{ $student->getFullNameAttribute() }}</td>
                                            <td>{{ $student->schoolClass->name }}</td>
                                            <td>{{ $student->classArm->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if ($students->isNotEmpty())
                                <div class="row mb-3">
                                    <div class="col-12 bg-primary p-1 text-white text-center mb-2">
                                        <h3>Promote To Section</h3>
                                    </div>

                                    {{-- Promote To Class/Arm --}}
                                    <div class="col-6" id="class_section">
                                        <select name="to_class_id" id="class" class="form-control">
                                            <option value="" disabled selected>Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 mt-2" id="classarm_section">
                                        <select name="to_class_arm_id" id="classarm" class="form-control">
                                            <option value="" disabled selected>Select Class Arm</option>
                                        </select>
                                    </div>

                                    {{-- Graduated Checkbox --}}
                                    <div class="row mb-3 mt-3">
                                        <div class="col-12">
                                            <label>
                                                <input type="checkbox" id="graduated_checkbox" name="graduated"
                                                    value="1">
                                                Graduated?
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Graduation Date --}}
                                    <div class="row mb-3" id="graduation_date_row" style="display: none;">
                                        <div class="col-6">
                                            <label for="graduated_at">Graduation Date</label>
                                            <input type="date" name="graduated_at" id="graduated_at"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Promote Selected</button>
                            @else
                                <div class="alert alert-warning text-center">
                                    No students found.
                                </div>
                            @endif
                        </form>

                        <script>
                            const graduatedCheckbox = document.getElementById('graduated_checkbox');
                            const graduationDateRow = document.getElementById('graduation_date_row');
                            const classSection = document.getElementById('class_section');
                            const classArmSection = document.getElementById('classarm_section');

                            graduatedCheckbox.addEventListener('change', function() {
                                if (this.checked) {
                                    graduationDateRow.style.display = 'block';
                                    classSection.style.display = 'none';
                                    classArmSection.style.display = 'none';

                                    // remove required from class & arm when graduating
                                    document.getElementById('class').removeAttribute('required');
                                    document.getElementById('classarm').removeAttribute('required');
                                } else {
                                    graduationDateRow.style.display = 'none';
                                    classSection.style.display = 'block';
                                    classArmSection.style.display = 'block';

                                    // reapply required when not graduating
                                    document.getElementById('class').setAttribute('required', 'required');
                                    document.getElementById('classarm').setAttribute('required', 'required');
                                }
                            });
                        </script>

                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('layouts.partials.class-arm')
@endsection
