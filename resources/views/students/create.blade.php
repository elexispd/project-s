@extends('layouts.portal')

@section('content')

<div class="pagetitle">
      <h1>Student   </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Student</li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-lg-12">

          <div class="card">
            <livewire:add-student />
          </div>

        </div>
      </div>
    </section>

 @include('layouts.partials.class-arm')

@endsection
