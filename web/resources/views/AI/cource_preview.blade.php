@extends('layouts.adminnav')

@section('content')

<div class="main-content">

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="text-primary">{{ $course['course_name'] }}</h4>
            <p>{{ $course['course_description'] }}</p>

            <div class="row">
                <div class="col-md-3"><strong>Category:</strong> {{ $course['category'] }}</div>
                <div class="col-md-3"><strong>Role:</strong> {{ $course['role'] }}</div>
                <div class="col-md-3"><strong>Designation:</strong> {{ $course['designation'] }}</div>
                <div class="col-md-3"><strong>Duration:</strong> {{ $course['course_duration'] }}</div>
            </div>
        </div>
    </div>

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

    <div class="tab-content mt-3">

        <div class="tab-pane fade show active" id="classes">

            <div class="accordion" id="classAccordion">

                @foreach($course['classes'] as $index => $class)
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-link" data-toggle="collapse"
                            data-target="#class{{ $index }}">
                            {{ $class['class_name'] }}
                        </button>
                    </div>

                    <div id="class{{ $index }}" class="collapse">
                        <div class="card-body">

                            <p>{{ $class['class_description'] }}</p>

                            <h6>Slides</h6>
                            <ul class="list-group">
                                @foreach($class['video_slides'] as $sIndex => $slide)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $slide['title'] }}</span>

                                    <button class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#slideModal{{ $index }}{{ $sIndex }}">
                                        Preview
                                    </button>
                                </li>

                                <!-- Slide Preview Modal -->
                                <div class="modal fade" id="slideModal{{ $index }}{{ $sIndex }}">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $slide['title'] }}</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                {{-- Render slide HTML --}}
                                                <div class="p-3 border">
                                                    {!! $slide['visual_text'] !!}
                                                </div>

                                                {{-- Voice-over Player --}}
                                                <hr>
                                                <h6>Voice-over</h6>
                                                <audio controls style="width:100%;">
                                                    <source src="{{ $slide['voiceover_audio_url'] ?? '' }}" type="audio/mpeg">
                                                    Your browser does not support audio.
                                                </audio>

                                                {{-- Voice-over Script --}}
                                                <div class="mt-3">
                                                    <h6>Voice Script</h6>
                                                    <p class="text-muted">
                                                        {{ $slide['voiceover_script'] }}
                                                    </p>
                                                </div>
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

        <div class="tab-pane fade" id="quiz">

            @foreach($course['classes'] as $class)
            <h5 class="text-primary mt-3">{{ $class['class_name'] }}</h5>

            {{-- MCQ --}}
            <h6>MCQ</h6>
            @foreach($class['quiz']['mcq'] as $q)
            <div class="mb-2">
                <strong>{{ $q['question_text'] }}</strong>
                <ul>
                    @foreach($q['options'] as $opt)
                    <li>{{ $opt['option_id'] }}. {{ $opt['text'] }}</li>
                    @endforeach
                </ul>
                <span class="badge badge-success">
                    Correct: {{ $q['correct_option_id'] }}
                </span>
            </div>
            @endforeach

            {{-- Short --}}
            <h6 class="mt-3">Short Answers</h6>
            @foreach($class['quiz']['short'] as $q)
            <p><strong>{{ $q['question_text'] }}</strong><br>
                <em>{{ $q['answer'] }}</em>
            </p>
            @endforeach

            @endforeach

        </div>

        <div class="tab-pane fade" id="exam">

            <h5 class="text-danger">Final Examination</h5>

            {{-- MCQ --}}
            <h6>MCQ</h6>
            @foreach($course['final_exam']['mcq'] as $q)
            <div class="mb-2">
                <strong>{{ $q['question_text'] }}</strong>
                <ul>
                    @foreach($q['options'] as $opt)
                    <li>{{ $opt['option_id'] }}. {{ $opt['text'] }}</li>
                    @endforeach
                </ul>
                <span class="badge badge-success">
                    Correct: {{ $q['correct_option_id'] }}
                </span>
            </div>
            @endforeach

            {{-- Long --}}
            <h6 class="mt-3">Long Answers</h6>
            @foreach($course['final_exam']['long'] as $q)
            <p><strong>{{ $q['question_text'] }}</strong><br>
                <em>{{ $q['answer'] }}</em>
            </p>
            @endforeach

        </div>

    </div>
</div>

@endsection