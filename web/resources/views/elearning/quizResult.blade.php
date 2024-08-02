@extends('layouts.elearningmain')

@section('content')

<style>
    /* remove card bocy shadow */
    .noShadow .card-body{
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

    #quizQuitModal .modal-header {
        background-color: #2c847a !important;
    }

    #quizQuitModalLabel {
        position: static;
    }

    #quizQuitModal .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        opacity: 0.9;
    }

    #quizQuitModal .btn-danger:hover {
        color: #fff !important;
        opacity: 1;
    }

    .answerInput {
        border: 0px !important;
        border-bottom: 1px solid #eee !important;
        border-radius: 2px !important;
    }

    @media (min-width:1024.96px) {
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
                <h2 class="col-12 mb-4 text-center">
                    {{ $quizName }}
                </h2>
                @php
                $id = $quizId;
                @endphp
                <form id="quizForm" action="{{ route('elearningQuizResults', $quizId) }}" method="post">
                    @csrf
                    @method('GET')
                    @php $id=Crypt::encrypt($quizId); @endphp
                    <input type="hidden" id="quizId" name="quizId" value="{{ $id }}">
                    @foreach($questionDetails as $questionDetail)
                    <input type="hidden" id="questionIds" name="questionIds" value="{{ $qIds }}">
                    @if($questionDetail->question_type == "boolean")
                    <div class="col-12 mx-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio_{{ $questionDetail->question_id }}_true" name="customRadio_{{ $questionDetail->question_id }}" value="true" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio_{{ $questionDetail->question_id }}_true">True</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio_{{ $questionDetail->question_id }}_false" name="customRadio_{{ $questionDetail->question_id }}" value="false" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio_{{ $questionDetail->question_id }}_false">False</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($questionDetail->question_type == "mcq")
                    <div class="col-12 mx-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="mcqChoicesContainer">
                                    @foreach($questionDetail->choices as $choice)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_{{ $questionDetail->question_id }}" id="customCheck_{{ $choice }}">
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
                    <div class="col-12 mx-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                {{$loop->iteration}}.&nbsp;&nbsp;{{ $questionDetail->question }}
                            </div>
                            <div class="card-body">
                                <div class="col-7 p-0">
                                    <input type="text" id="short_{{ $questionDetail->question_id }}" class="form-control answerInput" placeholder="Enter Your Answer">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </form>
            </div>
            <div class="d-flex flex-row justify-content-center mt-3">
                <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#quizQuitModal">
                    Cancel
                </button>
                <!-- <a href="{{ URL::previous() }}" class="btn btn-warning mr-3">Cancel</a> -->
                <a href="" id="quizSubmit" class="btn btn-success">Submit</a>
            </div>
        </div>
    </section>
</div>

<!-- quit verify modal -->
<div class="modal fade" id="quizQuitModal" tabindex="-1" role="dialog" aria-labelledby="quizQuitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3">
                <h5 class="modal-title" id="quizQuitModalLabel">Confirm</h5>
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

<script>
    let questionIds = document.querySelector('#questionIds');
    const questionsString = questionIds.value.split(", ");
    let index = 0;
    const questionsArray = [];
    for (let questionString of questionsString) {
        let questionDetail = questionString.split("-");
        questionsArray[index] = questionDetail;
        index++;
    }

    let quizSubmit = document.querySelector('#quizSubmit');
    let quizForm = document.querySelector('#quizForm');

    function quizformSubmit(e) {
        e.preventDefault();
        // quizForm.submit();
    }
    quizSubmit.addEventListener("click", quizformSubmit);
</script>
@endsection