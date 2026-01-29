@extends('layouts.adminnav')

@section('content')

<div class="main-content">
@php $index =1; $sIndex=1; @endphp

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="text-primary"></h4>
            <p></p>

            <div class="row">
                <div class="col-md-3"><strong>Category:</strong> </div>
                <div class="col-md-3"><strong>Role:</strong> </div>
                <div class="col-md-3"><strong>Designation:</strong> </div>
                <div class="col-md-3"><strong>Duration:</strong> </div>
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

                
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-link" data-toggle="collapse"
                            data-target="#class{{ $index }}">
                            
                        </button>
                    </div>

                    <div id="class{{ $index }}" class="collapse">
                        <div class="card-body">

                            <p></p>

                            <h6>Slides</h6>
                            <ul class="list-group">
                                
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span></span>
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
                                                <h5 class="modal-title"></h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                {{-- Render slide HTML --}}
                                                <div class="p-3 border">
                                                    
                                                </div>

                                                {{-- Voice-over Player --}}
                                                <hr>
                                                <h6>Voice-over</h6>
                                                <audio controls style="width:100%;">
                                                    <source src="" type="audio/mpeg">
                                                    Your browser does not support audio.
                                                </audio>

                                                {{-- Voice-over Script --}}
                                                <div class="mt-3">
                                                    <h6>Voice Script</h6>
                                                    <p class="text-muted">
                                                        
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </ul>


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="quiz">

            <h5 class="text-primary mt-3"></h5>

            {{-- MCQ --}}
            <h6>MCQ</h6>
            
            <div class="mb-2">
                <strong></strong>
                <ul>
                    
                    <li></li>
                </ul>
                <span class="badge badge-success">
                    Correct: 
                </span>
            </div>

            {{-- Short --}}
            <h6 class="mt-3">Short Answers</h6>
           
            <p><strong></strong><br>
                <em></em>
            </p>


        </div>

        <div class="tab-pane fade" id="exam">

            <h5 class="text-danger">Final Examination</h5>

            {{-- MCQ --}}
            <h6>MCQ</h6>
           
            <div class="mb-2">
                <strong></strong>
                <ul>
                    
                    <li></li>
                </ul>
                <span class="badge badge-success">
                    Correct: test answer
                </span>
            </div>

            {{-- Long --}}
            <h6 class="mt-3">Long Answers</h6>
            
            <p><strong></strong><br>
                <em></em>
            </p>

        </div>

    </div>
</div>

@endsection