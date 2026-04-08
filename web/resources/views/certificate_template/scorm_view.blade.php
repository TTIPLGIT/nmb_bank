@extends('layouts.adminnav')

@section('content')

<style>
.pdf-container {
    width: 100%;
    height: 85vh;
}

.pdf-frame {
    width: 100%;
    height: 100%;
    border: none;
}
</style>

<div class="main-content">
    <section class="section">

        <a href="/elearning/allCourses?sorted=Recently+Added&tag=false&progress=false&q=false&course_id=1"
            class="btn btn-primary mb-3">
            ← Back to Courses
        </a>

        <div class="card">
            <div class="card-body p-0">
                <div class="pdf-container">

                    <iframe src="{{ $pdfPath }}" class="pdf-frame"></iframe>
                </div>
            </div>
        </div>

    </section>
</div>

@endsection