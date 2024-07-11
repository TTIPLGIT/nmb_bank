@extends('layouts.elearningmain')

@section('content')


<style>
    /* remove card bocy shadow */

    #quizHeader {
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
                    Ethics  Test1
                </h2>
                <form id="quizForm" action="http://localhost:60159/elearningQuizResults?47" method="post">
                    <input type="hidden" name="_token" value="RSaHgxHp5GUsTw0CrBde830Pvi84Thx8BBdhmtPU"> <input type="hidden" name="_method" value="GET"> <input type="hidden" id="quizId" name="quizId" value="eyJpdiI6IkgyNTArbGUxOUJ5WUFxNlU0N0lKVnc9PSIsInZhbHVlIjoick9yTWYyTnFLTEw0TUtxZzNyRFVWUT09IiwibWFjIjoiNDAwMWQ3MzhiOTJjZjFiNWI0M2ExMTlhOTc2NDY3Njc2NjNmMjcyOTEzZTBiN2RhNTY1YTIzMDQ3ZDEwMDliZSIsInRhZyI6IiJ9">
                    <input type="hidden" id="questionIds" name="questionIds" value="43-short, 45-mcq, 42-boolean">
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                1.&nbsp;&nbsp;What are the eligibility norms, qualification and experience required for an
                                Individual to be registered as a valuer?
                            </div>
                            <div class="card-body">
                                <div class="col-12 col-md-7 p-0 shortResultContainer" id="shortResultContainer_43">
                                    <input type="text" id="short_43" class="form-control answerInput" placeholder="Enter Your Answer">
                                </div>
                                <input type="hidden" name="error" class="error short_error" id="short_43_error" value="*This field is required" disabled>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="questionIds" name="questionIds" value="43-short, 45-mcq, 42-boolean">
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                2.&nbsp;&nbsp;What are the conditions of Registration?
                            </div>
                            <div class="card-body">
                                <div class="mcqChoicesContainer">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_option">
                                        <label class="custom-control-label" id="mcq_45_1" for="customCheck_option">
                                            option
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_alternative">
                                        <label class="custom-control-label" id="mcq_45_2" for="customCheck_alternative">
                                            alternative
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_possibility">
                                        <label class="custom-control-label" id="mcq_45_3" for="customCheck_possibility">
                                            possibility
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_premier">
                                        <label class="custom-control-label" id="mcq_45_4" for="customCheck_premier">
                                            premier
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_best">
                                        <label class="custom-control-label" id="mcq_45_5" for="customCheck_best">
                                            best
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_finest">
                                        <label class="custom-control-label" id="mcq_45_6" for="customCheck_finest">
                                            finest
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_rude">
                                        <label class="custom-control-label" id="mcq_45_7" for="customCheck_rude">
                                            rude
                                        </label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mcq_45" id="customCheck_offensive">
                                        <label class="custom-control-label" id="mcq_45_8" for="customCheck_offensive">
                                            offensive
                                        </label>
                                    </div>
                                    <input type="hidden" name="error" class="error mcq_error" id="mcq_45_error" value="*Select atleast one option" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                3.&nbsp;&nbsp;What does 'equivalent' mean with respect to educational qualification?

                            </div>
                            <div class="card-body">
                                <div class="col-12 col-md-7 p-0 shortResultContainer" id="shortResultContainer_43">
                                    <input type="text" id="short_43" class="form-control answerInput" placeholder="Enter Your Answer">
                                </div>
                                <input type="hidden" name="error" class="error short_error" id="short_43_error" value="*This field is required" disabled>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="questionIds" name="questionIds" value="43-short, 45-mcq, 42-boolean">
                    <div class="col-12 px-3 mb-4 questions">
                        <div class="card noShadow px-2 py-3">
                            <div class="card-header">
                                4.&nbsp;&nbsp;Will an applicant who has been shown as an employee in a family-owned
                                business, but does not undertake any activity related to the family business, be
                                considered to be in employment?  is true/false.
                            </div>
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio_42_true" name="customRadio_42" value="true" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio_42_true">True</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio_42_false" name="customRadio_42" value="false" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio_42_false">False</label>
                                </div>
                                <input type="hidden" name="error" class="error boolean_error" id="boolean_42_error" value="*Select any one option" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex flex-row justify-content-center mt-3">
                <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#quizQuitModal">
                    Cancel
                </button>
                <!-- <a href="http://localhost:60159/elearningethnictest" class="btn btn-warning mr-3">Cancel</a> -->
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