@extends('layouts.elearningmain')

@section('content')

<style>
    /* remove card bocy shadow */

    #quizHeader{
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

    #submitSuccess .modal-header {
        background-color: #2c847a !important;
    }

    #submitSuccessLabel {
        position: static;
    }

    #submitSuccess .text-sucess {
        color: #54ca68 !important;
    }

    #submitSuccess .btn-primary {
        color: #fff !important;
        background-color: #007bff !important;
        border-color: #007bff !important;
        opacity: 0.9;
    }

    #submitSuccess .btn-primary:hover {
        color: #fff !important;
        opacity: 1;
    }

    #totalScore .modal-header {
        background-color: #2c847a !important;
    }

    #totalScoreLabel {
        position: static;
    }

    #totalScore .text-sucess {
        color: #54ca68 !important;
    }

    #totalScore .btn-primary {
        color: #fff !important;
        background-color: #007bff !important;
        border-color: #007bff !important;
        opacity: 0.9;
    }

    #totalScore .btn-primary:hover {
        color: #fff !important;
        opacity: 1;
    }

    .answerInput {
        border: 0px !important;
        border-bottom: 1px solid #eee !important;
        border-radius: 2px !important;
    }

    #quizTotalScore {
        color: #6777ef !important;
        background-color: transparent !important;
        border: 0px !important;
    }

    #quizTotalScore:hover {
        cursor: pointer !important;
        background-color: transparent !important;
        border: 0px !important;
    }

    .shortResultContainer.shortFull::after {
        content: '✅✅';
        position: absolute;
        top: 0px;
        left: calc(100% + 10px);
        width: fit-content;
        height: 100%;
        line-height: 100%;
        display: flex;
        align-items: center;
    }

    .shortResultContainer.shortPartial::after {
        content: '✅';
        position: absolute;
        top: 0px;
        left: calc(100% + 10px);
        width: fit-content;
        height: 100%;
        line-height: 100%;
        display: flex;
        align-items: center;
    }

    .shortResultContainer.shortNone::after {
        content: '❌';
        position: absolute;
        top: 0px;
        left: calc(100% + 10px);
        width: fit-content;
        height: 100%;
        line-height: 100%;
        display: flex;
        align-items: center;
    }

    .error {
        color: #ff0c0c;
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        border: 0px;
        outline: 0px;
        background-color: transparent !important;
    }

    .error:disabled {
        background-color: transparent !important;
    }

    /* progress circle */
    /* .totalScoreBody{

    } */
    /* .wrap-circles {
        display: flex;
        width: fit-content;
        in-height: 100%;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 1rem 1rem;
        background: #ddd;
    } */

    .circle {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0.5rem;
        border-radius: 50%;
        background: #ffcdb2;
        overflow: hidden;
    }

    .circle .inner {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 150px;
        height: 150px;
        background: #eee;
        border-radius: 50%;
        font-size: 1.85em;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.75);
    }

    .bg-eee {
        background-color: #eee !important;
    }

    

    /* end */

    @media (min-width:320px) and (max-width:575px) {
        .questions .card-header {

            font-size: 0.8rem !important;
        }

        .questions .card-body {
     
        font-size: 0.8rem !important;
    }

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
                <h2 id="quizHeader" class="col-12 mb-4 text-center">
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
                    <div class="col-12 px-3 mb-4 questions">
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
                                <input type="hidden" name="error" class="error boolean_error" id="boolean_{{ $questionDetail->question_id }}_error" value="*Select any one option" disabled>
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
                                        <input type="checkbox" class="custom-control-input mcq_{{ $questionDetail->question_id }}" id="customCheck_{{ $choice }}">
                                        <label class="custom-control-label" id="mcq_{{ $questionDetail->question_id }}_{{$loop->iteration}}" for="customCheck_{{ $choice }}">
                                            {{ $choice }}
                                        </label>
                                    </div>
                                    @endforeach
                                    <input type="hidden" name="error" class="error mcq_error" id="mcq_{{ $questionDetail->question_id }}_error" value="*Select atleast one option" disabled>
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
                                <div class="col-12 col-md-7 p-0 shortResultContainer" id="shortResultContainer_{{ $questionDetail->question_id }}">
                                    <input type="text" id="short_{{ $questionDetail->question_id }}" class="form-control answerInput" placeholder="Enter Your Answer">
                                </div>
                                <input type="hidden" name="error" class="error short_error" id="short_{{ $questionDetail->question_id }}_error" value="*This field is required" disabled>
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
                Are you Sure,you want to exit the quiz?
            </h4>
            <div class="modal-footer justify-content-center">
                <a type="button" href="{{ URL::previous() }}" class="btn btn-danger">Yes</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- submit success modal -->
<div class="modal fade" id="submitSuccess" tabindex="-1" role="dialog" aria-labelledby="submitSuccessLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3">
                <h5 class="modal-title" id="submitSuccessLabel">Success</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="modal-body text-center text-sucess p-4 mb-0">
                Submitted Successfully
            </h4>
            <div class="modal-footer justify-content-center">
                <a type="button" href="" class="btn btn-primary" id="viewQuizResults">View Reults</a>
            </div>
        </div>
    </div>
</div>

<!-- score modal -->
<div class="modal fade" id="totalScore" tabindex="-1" role="dialog" aria-labelledby="totalScoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3">
                <h5 class="modal-title" id="totalScoreLabel">Success</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="modal-body d-flex flex-row justify-content-center text-sucess bg-eee p-4 mb-0 totalScoreBody">
                <div class="circle">
                    <div class="inner">25%</div>
                </div>
            </h4>
            <!-- <div class="modal-footer justify-content-center bg-eee">
                <a type="button" href="" class="btn btn-primary" id="viewQuizResults">View Reults</a>
            </div> -->
        </div>
    </div>
</div>

<script>
    let quizResultData = [];
    let viewQuizResults = document.querySelector('#viewQuizResults');
    let quizHeader = document.querySelector('#quizHeader');
    let quizSubmit = document.querySelector('#quizSubmit');
    let quizForm = document.querySelector('#quizForm');
    let quizId = document.querySelector('#quizId').value;
    let questionIds = document.querySelector('#questionIds');
    const questionsString = questionIds.value.split(", ");
    let index = 0;
    const questionsArray = [];
    for (let questionString of questionsString) {
        let questionDetail = questionString.split("-");
        questionsArray[index] = questionDetail;
        index++;
    }

    function answerArray(e) {
        let answerIndex = 0;
        const answersArray = [];
        for (let questionArray of questionsArray) {
            if (questionArray[1] == "boolean") {
                let trueSelector = document.querySelector(`#customRadio_${questionArray[0]}_true`).checked;
                let falseSelector = document.querySelector(`#customRadio_${questionArray[0]}_false`).checked;
                let boolean = "";
                if (trueSelector == true) {
                    boolean = "True";
                    document.querySelector(`#boolean_${questionArray[0]}_error`).type = "hidden";
                    answersArray[answerIndex] = {
                        "questionId": `${questionArray[0]}`,
                        "questionType": `${questionArray[1]}`,
                        "answer": `${boolean}`
                    };
                    answerIndex++;
                } else if (falseSelector == true) {
                    boolean = "False";
                    document.querySelector(`#boolean_${questionArray[0]}_error`).type = "hidden";
                    answersArray[answerIndex] = {
                        "questionId": `${questionArray[0]}`,
                        "questionType": `${questionArray[1]}`,
                        "answer": `${boolean}`
                    };
                    answerIndex++;
                } else if (trueSelector == "" && falseSelector == "") {
                    document.querySelector(`#boolean_${questionArray[0]}_error`).type = "text";
                    return false;
                }
            } else if (questionArray[1] == "short") {
                let selector = `short_${questionArray[0]}`;
                let short = document.querySelector(`#${selector}`).value;
                if (short == "") {
                    document.querySelector(`#short_${questionArray[0]}_error`).type = "text";
                    return false;
                } else {
                    document.querySelector(`#short_${questionArray[0]}_error`).type = "hidden";
                    answersArray[answerIndex] = {
                        "questionId": `${questionArray[0]}`,
                        "questionType": `${questionArray[1]}`,
                        "answer": `${short}`
                    };
                    answerIndex++;
                }
            } else if (questionArray[1] == "mcq") {
                let selector = `mcq_${questionArray[0]}`;
                let choices = document.querySelectorAll(`.${selector}`);
                let choiceIndex = 0;
                let selections = [];
                for (let choice of choices) {
                    let isSelected = choice.checked;
                    let choiceLabel = document.querySelectorAll(`.${selector} + label`)[choiceIndex].innerText;
                    if (isSelected == true) {
                        selections = `${selections}, ${choiceLabel}`;
                    }
                    choiceIndex++;
                }

                if (selections.length == 0) {
                    document.querySelector(`#mcq_${questionArray[0]}_error`).type = "text";
                    return false;
                } else {
                    document.querySelector(`#mcq_${questionArray[0]}_error`).type = "hidden";
                    answersArray[answerIndex] = {
                        "questionId": `${questionArray[0]}`,
                        "questionType": `${questionArray[1]}`,
                        "answer": `${selections}`
                    };
                    answerIndex++;
                }
            }
        }
        $.ajax({
            url: "{{ url('/elearningQuizResults') }}",
            type: 'GET',
            data: {
                'id': quizId,
                'answers': answersArray,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                quizResultData = data;
                quizSubmit.setAttribute('disabled', true);
                $('#submitSuccess').modal('show');
                console.log(data);
            },
            error: function(error) {
                console.log('error; ' + eval(error));
            }
        })
    }

    function totalScoreEval(e) {
        $('#totalScore').modal('show');

    }

    function quizformSubmit(e) {
        e.preventDefault();
        if (quizSubmit.disabled != 'true') {
            answerArray();
        }
        // quizForm.submit();
    }

    function disabled(e) {
        e.preventDefault();
    }

    function quizResult(e) {
        e.preventDefault();
        $('#submitSuccess').modal('hide');
        let viewScoreLink = document.createElement('a');
        viewScoreLink.setAttribute('id', 'quizTotalScore');
        viewScoreLink.innerHTML = "&nbsp;-&nbsp;Score";
        viewScoreLink.addEventListener("click", totalScoreEval);
        quizHeader.appendChild(viewScoreLink);
        document.querySelector('.totalScoreBody .circle').style.backgroundImage = `conic-gradient(from 180deg, #28a745 ${Math.floor((quizResultData.totalPointsEarned*100)/quizResultData.totalAvailablePoints)}%, #fff 0)`;
        document.querySelector('.totalScoreBody .inner').innerHTML = `${quizResultData.totalPointsEarned}/${quizResultData.totalAvailablePoints}`;
        for (let answerDetail of quizResultData.answerDetails) {
            if (answerDetail.questionType == "boolean") {
                document.querySelector(`#customRadio_${answerDetail.questionId}_true + label`).addEventListener('click', disabled);
                document.querySelector(`#customRadio_${answerDetail.questionId}_false + label`).addEventListener('click', disabled);
                if (answerDetail.answerStatus == "1" && answerDetail.answerGiven == "True") {
                    document.querySelector(`#customRadio_${answerDetail.questionId}_true + label`).innerHTML = "True&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#9989;";
                } else if (answerDetail.answerStatus == "0" && answerDetail.answerGiven == "True") {
                    document.querySelector(`#customRadio_${answerDetail.questionId}_true + label`).innerHTML = "True&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#10060;";
                } else if (answerDetail.answerStatus == "1" && answerDetail.answerGiven == "False") {
                    document.querySelector(`#customRadio_${answerDetail.questionId}_false + label`).innerHTML = "False&nbsp;&nbsp;&nbsp;&nbsp;&#9989;";
                } else if (answerDetail.answerStatus == "0" && answerDetail.answerGiven == "False") {
                    document.querySelector(`#customRadio_${answerDetail.questionId}_false + label`).innerHTML = "False&nbsp;&nbsp;&nbsp;&nbsp;&#10060;";
                }
            } else if (answerDetail.questionType == "short") {
                document.querySelector(`#short_${answerDetail.questionId}`).setAttribute('disabled', '');
                if (answerDetail.answerStatus == "none") {
                    document.querySelector(`#shortResultContainer_${answerDetail.questionId}`).classList.add('shortNone');
                } else if (answerDetail.answerStatus == "Partial") {
                    document.querySelector(`#shortResultContainer_${answerDetail.questionId}`).classList.add('shortPartial');
                } else if (answerDetail.answerStatus == "Full") {
                    document.querySelector(`#shortResultContainer_${answerDetail.questionId}`).classList.add('shortFull');
                }
            } else if (answerDetail.questionType == "mcq") {
                let options = document.querySelectorAll(`.mcq_${answerDetail.questionId} + label`);
                for (let i = 0; i < options.length; i++) {
                    document.querySelectorAll(`.mcq_${answerDetail.questionId} + label`)[i].addEventListener('click', disabled);
                }
                document.querySelectorAll(`.mcq_${answerDetail.questionId} + label`)
                let selectedIds = [];
                let index = 0;
                for (let option of options) {
                    if (answerDetail.answerGiven.indexOf(`${option.innerText}`) != "-1") {
                        selectedIds[index] = option.id;
                        index++;
                        console.log(selectedIds);
                    }
                }
                for (let selectedId of selectedIds) {
                    let optionValue = document.querySelector(`#${selectedId}`).innerText;
                    if (answerDetail.correctAnswer.indexOf(`${optionValue}`) != "-1") {
                        document.querySelector(`#${selectedId}`).innerHTML = `${optionValue}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#9989;`;
                    } else {
                        document.querySelector(`#${selectedId}`).innerHTML = `${optionValue}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#10060;`;
                    }
                }
            }
            quizSubmit.removeEventListener("click", quizformSubmit);
            quizSubmit.addEventListener("click", disabled);
        }
    }

    quizSubmit.addEventListener("click", quizformSubmit);

    viewQuizResults.addEventListener("click", quizResult);
</script>
@endsection