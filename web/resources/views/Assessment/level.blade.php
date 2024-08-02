@extends('layouts.adminnav')

@section('content')
<style>
    /* .nav-tabs {
        border-bottom: 4px solid #50cd89;
    } */

    .card-body {
        font-family: Poppins, Helvetica, sans-serif;
    }

    .level {
        margin-top: 5px;
        width: 60%;
        border-radius: 14px !important;
    }

    .level-body {
        border-radius: 14px !important;
    }

    .level-1 {
        width: 40%;
        padding: 0 7%;
        padding-top: 5%;
        border-radius: 14px;
    }

    .para-text {
        text-align: center;
    }
</style>

<div class="main-content">

    <section class="section">

        <div class="card">
            <div class="card-body">
                @php
                function findTab($id) {
                return ($id === "mandatory") ? "tab1" : (($id === "professional-core") ? "tab2" : null);
                }
                @endphp
                <div>
                    <a type="button" class="btn btn-labeled btn-info" href="/Professional/Competence?tab={{findtab($rows[0]['type'])}}" title="next">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                </div>

                <div class="row">
                    <h5 style="margin-left:28%"> {{$rows[0]['title']}}</h5>
                </div>
                <div class="row" style="border:2px solid #eee">
                    <div class="col-lg-12">
                        <div class="tabbable-panel">
                            <div class="tabbable-line">
                                <div class="row">
                                    <ul class="nav nav-tabs" style="width:100%;text-align:center;font-size:30px;display:flex;">
                                        <input type="hidden" name="levels" id="levels" value="{{$rows[0]['no_levels']}}">
                                        <li style="width:50%">
                                            <a id="level_tab1" href="#level1">
                                                <p style="font-size:18px">Level 1</p>
                                            </a>
                                        </li>
                                        <li style="width:50%">
                                            <a id="level_tab2" href="#level2">
                                                <p style="font-size:18px">Level 2</p>
                                            </a>

                                        </li>
                                        <li style="width:50%">
                                            <a id="level_tab3" href="#level3">
                                                <p style="font-size:18px">Level 3</p>
                                            </a>

                                        </li>
                                    </ul>
                                    <div class="row" id="level1">
                                        <div class="card level">
                                            <div class="card-body level-body">
                                                <p style="color:#a1a5b7!important">competency</p>
                                                <p>{{$rows[0]['title']}}</p>
                                                <p style="color:#a1a5b7!important">Level One Information</p>
                                                <p style="color:#a1a5b7!important"> {{$rows[0]['description']}}.</p>
                                                <hr style="border:2px solid #eee">
                                                <form action="{{route('level_store')}}" method="POST" id="assessment_store">
                                                    @csrf
                                                    <div>
                                                        @if(!isset($rows2[0]['notes']))
                                                        <textarea name="valuer_comments" style="color:white" class="form-control" id="cgvapprove" rows="6"></textarea>
                                                        @else
                                                        <textarea name="valuer_comments" style="color:white" class="form-control" id="cgvapprove" rows="6">{!! $rows2[0]['notes'] !!}</textarea>

                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="is_submitted" id="is_submitted" value="">
                                                    <input type="hidden" name="assessment_id" id="assessment_id" value="{{$rows[0]['id']}}">
                                                    <input type="hidden" name="level" id="level" value="1">
                                                    <input type="hidden" name="word_count" id="word_count" value="">
                                                    <div style="margin-top:4%">
                                                        <a type="" onclick="is_submitted(0);" class="btn btn-flat btn-sm btn-fill btn-primary" style="background-color:#009ef7">Save and continue</a>
                                                        <!-- <a onclick="is_submitted(1);" class="btn btn-flat btn-sm btn-fill btn-success float-right save_data">Submit for Review</a> -->

                                                        <a onclick="is_submitted(1);" class="btn btn-flat btn-sm btn-fill btn-success float-right save_data">{{(!isset($rows2[0]['is_submitted'])||$rows2[0]['is_submitted'] == 0)?"Submit for Review" : "Re-Submit"}}</a>


                                                    </div>
                                                </form>

                                                <br><br>
                                                <hr>
                                                <!-- <div>
                                                <i class="fa fa-bullhorn" aria-hidden="true" style="font-size:20px"></i>
                                                <p>Feedback</p>
                                            </div> -->
                                            </div>
                                        </div>
                                        <div class="level-1">
                                            <div class="card">
                                                <div class="card-body" style="border-radius:14px">
                                                    <div>
                                                        <i class="fa fa-info-circle" aria-hidden="true" style="color:#7239ea;font-size:30px;"></i>
                                                        <p class="para-text">Target Level</p>
                                                        <p class="para-text" style="color:#7239ea">level one</p>
                                                        <p class="para-text">Type {{$rows[0]['type']}}</p>
                                                        <p class="para-text">Level Status</p>
                                                        @if(!isset($rows2[0]['is_submitted']))
                                                        <p class="para-text" style="color:red">Not Started</p>
                                                        @elseif(isset($rows2[0]['is_submitted']) && ($rows2[0]['is_submitted'] == '0' ))
                                                        <p class="para-text" style="color:red">Started</p>
                                                        @else
                                                        <p class="para-text" style="color:red">Submitted</p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" required id="user_id" name="assessment_id" value="{{$rows[0]['type']}}">
                                            <!-- <div class="card" style="margin-top:3%">
                                            <div class="card-body" style="border-radius:14px">
                                                <div style="text-align:center">
                                                    <i class="fa fa-download" aria-hidden="true" style="color:#a1a5b7;font-size:30px;"></i><br><br>
                                                    <p>Apc Downloads</p>
                                                    <p style="color:#7239ea">Not available</p>
                                                </div>
                                            </div>
                                        </div> -->
                                        </div>

                                    </div>
                                    <div class="row d-none" id="level2">
                                        <div class="card level">
                                            <div class="card-body level-body">
                                                <p style="color:#a1a5b7!important">competency</p>
                                                <p>{{$rows[0]['title']}}</p>
                                                <p style="color:#a1a5b7!important">Level One Information</p>
                                                <p style="color:#a1a5b7!important">{{$rows[0]['description']}}</p>
                                                <hr style="border:2px solid #eee">
                                                <div>
                                                    <textarea name="valuer_comments" style="color:white" class="form-control" id="cgvapprove" rows="6"></textarea>
                                                </div>
                                                <div style="margin-top:4%">
                                                    <button class="btn btn-flat btn-sm btn-fill btn-primary" style="background-color:#009ef7">Save and continue</button>
                                                    <button class="btn btn-flat btn-sm btn-fill btn-success float-right save_data">Submit for Review</button>
                                                </div>
                                                <br><br>
                                                <hr>
                                                <!-- <div>
                                                <i class="fa fa-bullhorn" aria-hidden="true" style="font-size:20px"></i>
                                                <p>Feedback</p>
                                            </div> -->
                                            </div>
                                        </div>
                                        <div class="level-1">
                                            <div class="card">
                                                <div class="card-body" style="border-radius:14px">
                                                    <div>
                                                        <i class="fa fa-info-circle" aria-hidden="true" style="color:#7239ea;font-size:30px;"></i>
                                                        <p class="para-text">Target Level</p>
                                                        <p class="para-text" style="color:#7239ea">level one</p>
                                                        <p class="para-text">Type Mandatory</p>
                                                        <p class="para-text">Level Status</p>
                                                        <p class="para-text" style="color:red">Not Started</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="card" style="margin-top:3%">
                                            <div class="card-body" style="border-radius:14px">
                                                <div style="text-align:center">
                                                    <i class="fa fa-download" aria-hidden="true" style="color:#a1a5b7;font-size:30px;"></i><br><br>
                                                    <p>Apc Downloads</p>
                                                    <p style="color:#7239ea">Not available</p>


                                                </div>
                                            </div>
                                        </div> -->
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>
<script>
    function is_submitted(value) {
        if (tinymce.activeEditor.getContent() == "") {
            swal("Please Enter the notes", "", "error");
            return false;
        }
        if (value == 1) {
            var text = tinymce.activeEditor.getContent().replace(/<[^>]+>/g, ''); // remove HTML tags
            var wordCount = text.trim().split(/\s+/).length; // count words
            if (wordCount < 150) {
                // validation fails
                swal("The text must be at least 150 words long to submit.", "", "error");
                return false;
            }
        }
        var text = tinymce.activeEditor.getContent().replace(/<[^>]+>/g, '');
        var wordCount = text.trim().split(/\s+/).length;
        $('#word_count').val(wordCount);

        $('#is_submitted').val(value);
        $("#assessment_store").submit();



    }
    $(document).ready(function() {
        $('#level_tab1').hide();
        $('#level_tab2').hide();
        $('#level_tab3').hide();
        var levels = $('#levels').val();
        for (let index = 1; index <= levels; index++) {
            $(`#level_tab${index}`).show();
        }
        tinymce.init({
            selector: 'textarea#cgvapprove',
            height: 180,
            menubar: 'table',
            branding: false,
            plugins: 'table',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
    });
</script>
<script>
    if (id == 'level1') {
        document.getElementById('level1').classList.remove('d-none');
        document.getElementById('level2').classList.add('d-none');
    }
    if (id == 'level2') {
        document.getElementById('level2').classList.remove('d-none');
        document.getElementById('level1').classList.add('d-none');
    }
</script>

<script>
    // function() {



    //     var sav = $("#").val();
    //     if (sav == '') {
    //         swal("Please Enter the notes", "", "error");
    //         return false;
    //     }

    //     var sub = $("#").val();
    //     if (sub == '') {
    //         swal("Please Enter the notes", "", "error");
    //         return false;
    //     } else {
    //         document.getElementById('').submit();
    //     }

    // }
</script>


@endsection