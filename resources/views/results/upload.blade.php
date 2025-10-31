@extends('layouts.portal')

@section('content')

<div class="pagetitle">
    <h1>Result Upload</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Result</li>
            <li class="breadcrumb-item active">Upload</li>
        </ol>
    </nav>
</div>


<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload Result</h5>

                    <x-alerts />

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs nav-tabs-bordered" id="uploadTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="manual-tab" data-bs-toggle="tab"
                                    data-bs-target="#manual" type="button" role="tab"
                                    aria-controls="manual" aria-selected="true">
                                <i class="bi bi-pencil-square"></i> Manual Upload
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="excel-tab" data-bs-toggle="tab"
                                    data-bs-target="#excel" type="button" role="tab"
                                    aria-controls="excel" aria-selected="false">
                                <i class="bi bi-file-spreadsheet"></i> Excel Upload
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content pt-4" id="uploadTabsContent">

                        <!-- Manual Upload Tab -->
                        <div class="tab-pane fade show active" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                            <form class="row g-3" method="POST" action="{{ route('results.store') }}">
                                @csrf

                                <div class="col-6">
                                    <label for="session" class="form-label">Session</label>
                                    <select name="session_id" class="form-control" required>
                                        <option value="" selected disabled>Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="term" class="form-label">Term</label>
                                    <select name="term" id="term" class="form-control" required>
                                        <option value="1">First Term</option>
                                        <option value="2">Second Term</option>
                                        <option value="3">Third Term</option>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="class" class="form-label">Class</label>
                                    <select name="school_class_id" id="class" class="form-control @error('school_class_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class') == $class->name ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('school_class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="class_arm_id" class="form-label">Class Arm</label>
                                    <select name="class_arm_id" id="classarm" class="form-control @error('class_arm_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Class Arm</option>
                                    </select>
                                    @error('class_arm_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label for="subject_id" class="form-label">Subject</label>
                                    <select name="subject_id" class="form-control" required>
                                        <option value="" selected disabled>Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="button" id="generateBtn" class="btn btn-primary">
                                        <i class="bi bi-grid"></i> Generate Student List
                                    </button>
                                </div>

                                <div id="studentResults" style="display: none;">
                                    <!-- The student table will be injected here by the AJAX request -->
                                </div>
                            </form>
                        </div>

                        <!-- Excel Upload Tab -->
                        <div class="tab-pane fade" id="excel" role="tabpanel" aria-labelledby="excel-tab">

                            <!-- Instructions -->
                            <div class="alert alert-info">
                                <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Instructions:</h6>
                                <ol class="mb-0">
                                    <li>Select class and class arm below to download the template</li>
                                    <li>Fill in the CA and Exam scores in the Excel file</li>
                                    <li>Upload the completed file using the form below</li>
                                </ol>
                            </div>

                            <!-- Download Template Form -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">Step 1: Download Template</h6>
                                    <form action="{{ route('results.download-template') }}" method="GET" class="row g-3">
                                        <div class="col-md-6">
                                            <label for="template_class" class="form-label">Class</label>
                                            <select name="school_class_id" id="template_class" class="form-control" required>
                                                <option value="" disabled selected>Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="template_classarm" class="form-label">Class Arm</label>
                                            <select name="class_arm_id" id="template_classarm" class="form-control" required>
                                                <option value="" disabled selected>Select Class Arm</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-download"></i> Download Template
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Upload Form -->
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Step 2: Upload Completed Excel File</h6>
                                    <form action="{{ route('results.excel-upload') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                        @csrf

                                        <div class="col-md-6">
                                            <label for="excel_session" class="form-label">Session</label>
                                            <select name="session_id" class="form-control" required>
                                                <option value="" selected disabled>Select Session</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="excel_term" class="form-label">Term</label>
                                            <select name="term" id="excel_term" class="form-control" required>
                                                <option value="1">First Term</option>
                                                <option value="2">Second Term</option>
                                                <option value="3">Third Term</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label for="excel_class" class="form-label">Class</label>
                                            <select name="school_class_id" id="excel_class" class="form-control @error('school_class_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('school_class_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label for="excel_classarm" class="form-label">Class Arm</label>
                                            <select name="class_arm_id" id="excel_classarm" class="form-control @error('class_arm_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>Select Class Arm</option>
                                            </select>
                                            @error('class_arm_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="subject_id" class="form-label">Subject</label>
                                            <select name="subject_id" class="form-control" required>
                                                <option value="" selected disabled>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('subject_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="excel_file" class="form-label">Excel File</label>
                                            <input type="file" name="excel_file" id="excel_file"
                                                   class="form-control @error('excel_file') is-invalid @enderror"
                                                   accept=".xlsx,.xls,.csv" required>
                                            <small class="text-muted">Accepted formats: .xlsx, .xls, .csv (Max: 5MB)</small>
                                            @error('excel_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-upload"></i> Upload Results
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Reusable function to handle class arm population
    function setupClassArmSelect(classSelector, classArmSelector) {
        var $classSelect = $(classSelector);
        var $classArmSelect = $(classArmSelector);

        $classSelect.change(function() {
            var classId = $(this).val();

            // Clear and disable class arm select while loading
            $classArmSelect.empty()
                        .append($('<option>', {
                            value: '',
                            text: 'Loading...',
                            disabled: true
                        }))
                        .prop('disabled', true);

            if (classId) {
                $.ajax({
                    url: "{{ url('/classarms/by-class') }}/" + classId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $classArmSelect.empty()
                                    .append($('<option>', {
                                        value: '',
                                        text: 'Select Class Arm',
                                        disabled: true,
                                        selected: true
                                    }));

                        // Process response data
                        if (Array.isArray(data)) {
                            data.forEach(function(item) {
                                $classArmSelect.append($('<option>', {
                                    value: item.id || item,
                                    text: item.name || item
                                }));
                            });
                        } else if (typeof data === 'object') {
                            Object.keys(data).forEach(function(key) {
                                $classArmSelect.append($('<option>', {
                                    value: key,
                                    text: data[key]
                                }));
                            });
                        }

                        // Enable select
                        $classArmSelect.prop('disabled', false);
                    },
                    error: function() {
                        $classArmSelect.empty()
                                    .append($('<option>', {
                                        value: '',
                                        text: 'Error loading class arms',
                                        disabled: true
                                    }));
                    }
                });
            } else {
                $classArmSelect.empty()
                            .append($('<option>', {
                                value: '',
                                text: 'Select Class Arm',
                                disabled: true
                            }));
            }
        });
    }

    // Setup for Manual Upload Form
    setupClassArmSelect('#class', '#classarm');

    // Setup for Template Download Form
    setupClassArmSelect('#template_class', '#template_classarm');

    // Setup for Excel Upload Form
    setupClassArmSelect('#excel_class', '#excel_classarm');

    // Handle old values for manual upload form
    @if(old('class'))
        $('#class').trigger('change');
        @if(old('classarm'))
            setTimeout(function() {
                $('#classarm').val("{{ old('classarm') }}");
            }, 500);
        @endif
    @endif

    // Generate button handler for manual upload
    $('#generateBtn').click(function() {
        const classId = $('#class').val();
        const classArmId = $('#classarm').val();
        const term = $('#term').val();
        const subjectId = $('select[name="subject_id"]').val();

        if (!classId || !classArmId || !subjectId) {
            alert("Please select class, class arm, and subject before generating.");
            return;
        }

        $.ajax({
            url: "{{ route('results.fetch') }}",
            method: "POST",
            dataType: "html",
            data: {
                _token: "{{ csrf_token() }}",
                school_class_id: classId,
                class_arm_id: classArmId,
                subject_id: subjectId,
                term: term,
            },
            success: function(response) {
                $('#studentResults').html(response);
                $('#studentResults').show();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching students:", error);
                alert("There was an error fetching students.");
            }
        });
    });
});
</script>

@endsection
