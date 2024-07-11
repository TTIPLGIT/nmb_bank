@extends('layouts.elearningmain')

@section('content')

<style>
    /* remove card bocy shadow */
   .header_align{
    font-size: 1.8rem;
   }
   
   
    .noShadow .card-body {
        box-shadow: none !important;
    }

    .questions .card {
        background-color: #fff !important;
        border: 0px;
        border-radius: 10px !important;
        overflow: hidden !important;
    }

    .questions .card-header {
        background-color: #fff !important;
        border-bottom: 0px !important;
        font-size: 1.1rem;
    }

    .questions .card-body {
        background-color: #fff !important;
        font-size: 1.1rem;
    }

    .questions .form-control {
        background-color: #fff !important;
        box-shadow: none !important;
    }

    #assessmentQuitModal .modal-header {
        background-color: #2c847a !important;
    }

    #assessmentQuitModalLabel {
        position: static;
    }

    #assessmentQuitModal .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        opacity: 0.9;
    }

    #assessmentQuitModal .btn-danger:hover {
        color: #fff !important;
        opacity: 1;
    }

    #assessmentsuccessModal .modal-header {
        background-color: #2c847a !important;
    }

    #assessmentsuccessModalLabel {
        position: static;
    }

    #assessmentsuccessModal .btn-primary {
        background-color: #007bff !important;
        border-color: #007bff !important;
        opacity: 0.9;
    }

    #assessmentsuccessModal .btn-primary:hover {
        color: #fff !important;
        opacity: 1;
    }

    input.answerInput {
        border: 0px !important;
        border-bottom: 1px solid #eee !important;
        border-radius: 2px !important;
    }

    textarea.answerInput {
        height: auto !important;
        resize: none;
    }

    @media (min-width:320px) and (max-width:575px) 
    {
        .questions .card-header {

            font-size: 0.8rem !important;
        }

        .questions .card-body {
     
        font-size: 0.8rem !important;
    }

    }




    @media (min-width:1024.96px)
     {
        .main-content {
            padding-left: 220px !important;
        }

        .sidebar-mini .main-content {
            padding-left: 85px !important;
        }
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">
            <div class="row">
                <h2 class="col-12 mb-4 text-center header_align">
                    {{ $assessmentName }}
                </h2>
                <form id="quizForm" action="{{ route('elearningAssessmentSubmit') }}" method="post">
                    @csrf
                    @method('GET')
                    <input type="hidden" name="quizId" value="{{ $assessmentId }}">
                    @foreach($questionDetails as $questionDetail)
                    @if($questionDetail->question_type == "boolean")
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio_{{ $questionDetail->question_id }}_true" name="customRadio_{{ $questionDetail->question_id }}" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio_{{ $questionDetail->question_id }}_true">True</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio_{{ $questionDetail->question_id }}_false" name="customRadio_{{ $questionDetail->question_id }}" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio_{{ $questionDetail->question_id }}_false">False</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($questionDetail->question_type == "mcq")
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="mcqChoicesContainer">
                                    @foreach($questionDetail->choices as $choice)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck_{{ $choice }}">
                                        <label class="custom-control-label" for="customCheck_{{ $choice }}">
                                            {{ $choice }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($questionDetail->question_type == "short")
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="col-7 p-0">
                                    <input type="text" class="form-control answerInput" placeholder="Enter Your Answer">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($questionDetail->question_type == "long")
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="col-7 p-0">
                                    <textarea class="form-control answerInput" placeholder="Enter Your Answer" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </form>
            </div>
            <div class="d-flex flex-row justify-content-center mt-3">
                <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#assessmentQuitModal">
                    Cancel
                </button>
                <!-- <a href="" id="quizSubmit" class="btn btn-success">Submit</a> -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#assessmentsuccessModal">
                    Submit
                </button>
            </div>
        </div>
    </section>
</div>

<!-- quit verify modal -->
<div class="modal fade" id="assessmentQuitModal" tabindex="-1" role="dialog" aria-labelledby="assessmentQuitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3">
                <h5 class="modal-title" id="assessmentQuitModalLabel">Confirm</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="modal-body text-center text-danger p-4 mb-0">
                Are you Sure want to exit quiz?
            </h4>
            <div class="modal-footer justify-content-center">
                <a type="button" href="{{ URL::previous() }}" class="btn btn-danger">Yes</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- submit success poppup -->
<div class="modal fade" id="assessmentsuccessModal" tabindex="-1" role="dialog" aria-labelledby="assessmentsuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3">
                <h5 class="modal-title" id="assessmentsuccessModalLabel">Success Message</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="modal-body text-center text-success p-4 mb-0">
                Assessment Submitted Successfully
            </h4>
            <div class="modal-footer justify-content-center">
                <a type="button" href="{{ URL::previous() }}" class="btn btn-primary">Ok</a>
            </div>
        </div>
    </div>
</div>

<script>
    let quizSubmit = document.querySelector('#quizSubmit');
    let quizForm = document.querySelector('#quizForm');

    function quizformSubmit(e) {
        e.preventDefault();

        // quizForm.submit();
    }
    // quizSubmit.addEventListener("click", quizformSubmit);
</script>
@endsection