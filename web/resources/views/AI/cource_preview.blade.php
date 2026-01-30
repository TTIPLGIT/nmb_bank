@extends('layouts.adminnav')

@section('content')

<style>
    .modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
}
.modal-dialog {
    max-width: 90%;
}

.modal-body {
    max-height: 75vh;
    overflow-y: auto;
}

</style>
<div class="main-content">
    <form action="{{route('ai_course_store')}}" method="post">
        @csrf
    {{-- COURSE HEADER --}}
    <div class="card mb-4">
        <div class="card-body">

            {{-- Banner --}}
            @if(!empty($course['course_banner_url']))
                <img src="{{ $course['course_banner_url'] }}"
                     class="img-fluid mb-3 rounded"
                     style="max-height:300px; width:100%; object-fit:cover;">
            @endif

            <h3 class="text-primary">{{ $course['course_name'] }}</h3>
            <p class="text-muted">{{ $course['course_description'] }}</p>

            <div class="row mt-3">
                <div class="col-md-3"><strong>Category:</strong> {{ $course['category'] }}</div>
                <div class="col-md-3"><strong>Role:</strong> {{ $course['role'] }}</div>
                <div class="col-md-3"><strong>Designation:</strong> {{ $course['designation'] }}</div>
                <div class="col-md-3"><strong>Duration:</strong> {{ $course['course_duration'] }}</div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <strong>Classes:</strong> {{ $course['class_count'] }}
                </div>
                <div class="col-md-6">
                    <strong>Completion Logic:</strong> {{ $course['completion_points_logic'] }}
                </div>
            </div>

        </div>
    </div>

    {{-- COURSE INTRODUCTION --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-info">Course Introduction</h5>
            <pre style="white-space:pre-wrap;">{{ $course['course_introduction'] }}</pre>
        </div>
    </div>

    {{-- TABS --}}
    <ul class="nav nav-tabs" id="courseTabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#classes">Classes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#quiz">Quiz</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#exam">Final Exam</a>
        </li>
    </ul>
    <div class="card">
        <div class="card-body">
            <div class="tab-content mt-3">

                {{-- ================= CLASSES ================= --}}
                
                <div class="tab-pane fade show active" id="classes">

                    <div class="accordion" id="classAccordion">

                        @foreach($course['classes'] as $cIndex => $class)

                        <div class="card mb-2">
                            <div class="card-header">
                                <button class="btn btn-link"
                                        data-toggle="collapse"
                                        data-target="#class{{ $cIndex }}">
                                    {{ $class['class_name'] }}
                                    <span class="text-muted ml-2">
                                        ({{ $class['estimated_duration'] }})
                                    </span>
                                </button>
                            </div>

                            <div id="class{{ $cIndex }}" class="collapse">
                                <div class="card-body">

                                    <p>{{ $class['class_description'] }}</p>

                                    {{-- SLIDES --}}
                                    <h6 class="text-primary">Slides</h6>
                                    <ul class="list-group">
                                        @foreach($class['video_slides'] as $sIndex => $slide)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $slide['title'] }}

                                            <button class="btn btn-sm btn-outline-primary"
                                                    data-toggle="modal"
                                                    data-target="#slideModal{{ $cIndex }}{{ $sIndex }}">
                                                Preview
                                            </button>
                                        </li>

                                        {{-- SLIDE MODAL --}}
                                        <div class="modal fade"
                                            id="slideModal{{ $cIndex }}{{ $sIndex }}">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5>{{ $slide['title'] }}</h5>
                                                        <button class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="border p-3 mb-3">
                                                            {!! $slide['visual_text'] !!}
                                                        </div>

                                                        <h6>Voice-over Script</h6>
                                                        <p class="text-muted">
                                                            {{ $slide['voiceover_script'] }}
                                                        </p>

                                                        @if(!empty($slide['voiceover_audio_url']))
                                                        <audio controls style="width:100%;">
                                                            <source src="{{ $slide['voiceover_audio_url'] }}" type="audio/mpeg">
                                                        </audio>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>

                {{-- ================= QUIZ ================= --}}
                <div class="tab-pane fade" id="quiz">

                    @foreach($course['classes'] as $class)

                    <h5 class="text-primary mt-4">{{ $class['class_name'] }}</h5>

                    {{-- MCQ --}}
                    <h6>MCQ</h6>
                    @foreach($class['quiz']['mcq'] as $q)
                        <p><strong>{{ $q['question_text'] }}</strong></p>
                        <ul>
                            @foreach($q['options'] as $opt)
                                <li>{{ $opt['option_id'] }}. {{ $opt['text'] }}</li>
                            @endforeach
                        </ul>
                        <span class="badge badge-success">Correct: {{ $q['correct_option_id'] }}</span>
                    @endforeach

                    {{-- SHORT --}}
                    <h6 class="mt-3">Short Answers</h6>
                    @foreach($class['quiz']['short'] as $q)
                        <p><strong>{{ $q['question_text'] }}</strong><br>
                        <em>{{ $q['answer'] }}</em></p>
                    @endforeach

                    {{-- LONG --}}
                    <h6 class="mt-3">Long Answers</h6>
                    @foreach($class['quiz']['long'] as $q)
                        <p><strong>{{ $q['question_text'] }}</strong><br>
                        <em>{{ $q['answer'] }}</em></p>
                    @endforeach

                    {{-- TRUE / FALSE --}}
                    <h6 class="mt-3">True / False</h6>
                    @foreach($class['quiz']['true_false'] as $q)
                        <p>
                            <strong>{{ $q['question_text'] }}</strong><br>
                            Answer: <span class="badge badge-info">{{ $q['answer'] }}</span>
                        </p>
                    @endforeach

                    @endforeach
                </div>

                {{-- ================= FINAL EXAM ================= --}}
                <div class="tab-pane fade" id="exam">

                    <h5 class="text-danger mb-3">Final Examination</h5>

                    {{-- MCQ --}}
                    <h6>MCQ</h6>
                    @foreach($course['final_exam']['mcq'] as $q)
                        <p><strong>{{ $q['question_text'] }}</strong></p>
                        <ul>
                            @foreach($q['options'] as $opt)
                                <li>{{ $opt['option_id'] }}. {{ $opt['text'] }}</li>
                            @endforeach
                        </ul>
                        <span class="badge badge-success">
                            Correct: {{ $q['correct_option_id'] }}
                        </span>
                    @endforeach

                    {{-- SHORT --}}
                    <h6 class="mt-3">Short Answers</h6>
                    @foreach($course['final_exam']['short'] as $q)
                        <p><strong>{{ $q['question_text'] }}</strong><br>
                        <em>{{ $q['answer'] }}</em></p>
                    @endforeach

                    {{-- LONG --}}
                    <h6 class="mt-3">Long Answers</h6>
                    @foreach($course['final_exam']['long'] as $q)
                        <p><strong>{{ $q['question_text'] }}</strong><br>
                        <em>{{ $q['answer'] }}</em></p>
                    @endforeach

                    {{-- TRUE / FALSE --}}
                    <h6 class="mt-3">True / False</h6>
                    @foreach($course['final_exam']['true_false'] as $q)
                        <p>
                            <strong>{{ $q['question_text'] }}</strong><br>
                            Answer: <span class="badge badge-info">{{ $q['answer'] }}</span>
                        </p>
                    @endforeach

                </div>

            </div>
        </div>
    </div>

    <div class="mt-3" style="text-align:center">
        <button type="submit" class="btn btn-success">Submit</button>

    </div>
    </form>
</div>

@endsection
