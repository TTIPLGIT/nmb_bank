@extends('layouts.course')

@section('content')
<style>
    /* remove card bocy shadow */
    .noShadow .card-body {
        box-shadow: none !important;
    }

    .bgTransparent {
        background-color: transparent !important;
    }

    .noBorder {
        border: 0px;
    }

    .subMenuWrapper {
        position: relative;
        width: calc(100% - 30px);
        padding-left: 0px;
        padding-right: 0px;
        /* margin-left: 15px; */
        overflow-x: auto;
    }

    .addNoteCaller {
        position: absolute;
        right: 2%;
        bottom: 15%;
        width: 40px;
        height: 40px;
        box-shadow: 2px 2px 6px 0px #00000080;
        border-radius: 50%;
    }

    .addNoteCallerTip {
        content: 'Add Note';
        position: absolute;
        right: 0%;
        width: 80px;
        height: 100%;
        display: flex;
        align-items: center;
        font-size: 1rem;
        font-weight: 700;
        color: green;
        opacity: 0;
        cursor: pointer;
        transition: all 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .addNoteCaller:hover .addNoteCallerTip {
        right: 100%;
        opacity: 1;
        pointer-events: auto;
        transition: all 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .addNoteCaller img {
        width: 100%;
    }

    .subMenu {
        list-style: none;
        padding-left: 0px;
        width: max-content;
    }

    .subMenuItem {
        position: relative;
        padding: 0.8rem;
    }

    .subMenuLink {
        font-size: 1.2rem;
        font-weight: 700;
        color: #494f54;
    }

    .subMenuLink:hover,
    .subMenuLink.active {
        color: #000 !important;
        font-weight: 800;
        text-decoration: none;
    }

    .subMenuItem.selected:before {
        position: absolute;
        content: '';
        top: calc(100% - 2px);
        width: calc(100% - 1.6rem);
        height: 2px;
        left: 0.8rem;
        background-color: #000;
    }

    .tags {
        display: inline-block;
        padding: 0.5em 0.8em;
        font-size: 80%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        border-radius: 0.25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        position: unset !important;
        margin-right: 0.25rem !important;
    }

    .willLearn {
        padding-right: calc(31% + 20px) !important;
    }

    .willLearn .card {
        min-height: 150px !important;
    }

    .willLearn .card-body {
        height: 100%;
    }

    .willLearn ul {
        line-height: 1.5em;
    }

    .courseGainSkils {
        list-style-position: inside;
        list-style: none;
        width: 50% !important;
    }

    .courseGainSkils::before {
        content: "\2713";
        color: #28a745;
        display: inline-block;
        padding-right: 20px;
        font-weight: 900;
        font-size: 120%;
        height: 14px;
        width: 14px;
    }

    .courseIncludes {
        background-color: transparent !important;
        padding: 40px 20px;
    }

    .courseIncludesHeader {
        background-color: transparent !important;
        border: 0px !important;
    }

    .courseIncludesHeader .card-body {
        background-color: transparent !important;
    }

    .hoursOfVideos.card {
        background-color: transparent !important;
        height: 100% !important;
        border-radius: 5px !important;
        overflow: hidden;
        box-shadow: 0px 2px 8px -4px rgb(0 0 0 / 30%);
    }

    .hoursOfVideos .card-body {
        background-color: transparent !important;
    }

    .hoursOfVideos img {
        width: 15%;
        margin: 25px auto 50px 25px;
    }

    .coursePrerequisites {
        padding-right: calc(31% + 20px) !important;
    }

    .coursePrerequisites .card {
        min-height: 150px !important;
    }

    .coursePrerequisites .card-body {
        height: 100%;
    }

    .coursePrerequisites ul {
        line-height: 1.5em;
    }

    .courseSkillsRequired {
        list-style-position: inside;
        list-style: none;
        width: 50% !important;
    }

    .courseSkillsRequired::before {
        content: "\2713";
        color: #28a745;
        display: inline-block;
        padding-right: 20px;
        font-weight: 900;
        font-size: 120%;
        height: 14px;
        width: 14px;
    }

    /* search section */
    .questionSearchContainer {
        font-weight: 800;
        width: 25%;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }

    .questionSearchContainer button {
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        height: 50px;
        font-size: 1.2rem;
    }

    #qAndAContent .form-control {
        height: 50px !important;
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }

    .questionSearchContainer .form-control::placeholder {
        color: #000000 !important;
        color: #000000 !important;
        font-weight: 700;
    }

    .questionSort {
        font-weight: 700;
        color: #000000 !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        margin-bottom: 1rem;
        height: 50px;
    }

    .questionfollowed {
        font-weight: 700;
        color: #000000 !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        margin-bottom: 1rem;
        height: 50px;
    }

    .askButton {
        font-size: 1rem;
        height: 50px !important;
    }

    .backToForumQuestionView {
        font-size: 1rem;
        height: 50px !important;
        background-color: #fff;
    }

    .profilePic {
        width: 25px;
        height: 25px;
        border-radius: 50%;
    }

    .postedQuestionWrapper {
        padding: 1rem;
        background-color: transparent !important;
    }

    .postedQuestionWrapper:hover {
        background-color: #eee !important;
    }

    .followIcon,
    .replyIcon {
        font-size: 1.4rem;
        margin-bottom: 5px;
    }

    /* editor override styles */
    .addQuestionForm .tox-tinymce {
        border: 1px solid #000 !important;
    }

    .addQuestionForm .tox .tox-editor-container {
        border-bottom: 1px solid #000 !important;
    }

    .addQuestionForm .tox .tox-statusbar {
        border-top: 0px !important;
    }

    .questionDescriptionHolder {
        display: -webkit-box;
        max-width: 100%;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .questionDescriptionHolder strong {
        word-break: break-word;
    }

    #notesContent .form-control {
        height: 50px !important;
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }

    #notesContent .form-control::placeholder {
        color: #000000 !important;
        font-weight: 700;
    }

    .addNote {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0px !important;
        margin-left: -1px;
        background-color: #eee;
        border-radius: 0px !important;
        border: 1px solid #000 !important;
    }

    .addNote i {
        font-size: 30px;
        padding: 12px 10px 6px 13px !important;
        color: #fff;
        background-image: linear-gradient(to right, #2c847a, #2c847a, #2c847a, #2c847a, #2c847a) !important;
    }

    .notepadHolderWrapper {
        position: absolute;
        top: 5px;
        right: 2%;
        z-index: 2;
        display: none;
        width: 300px;
        padding-left: 10px;
        padding-right: 25px;
    }

    .editNotepadHolderWrapper {
        position: relative;
        display: none;
        width: 300px;
        padding-left: 10px;
        padding-right: 25px;
        padding-top: 6%;
    }

    .editNotepadHolderWrapper.empty:before {
        content: 'Edited Note Empty !!';
        font-size: 1rem;
        font-weight: 700;
        color: red;
        position: absolute;
        width: calc(100% - 35px);
        z-index: 3;
        height: 20px;
        top: 6%;
        text-align: center;
    }

    .notepadHolderWrapper.active {
        display: block;
    }

    .notepad {
        width: 100%;
        background-attachment: local;
        background-image:
            linear-gradient(to right, white 10px, transparent 10px),
            linear-gradient(to left, white 10px, transparent 10px),
            repeating-linear-gradient(white, white 29px, #ccc 29px, #ccc 30px, white 30px);
        line-height: 30px;
        padding: 8px 10px;
        min-height: 300px;
    }

    .editNotepad {
        width: 100%;
        background-attachment: local;
        background-image:
            linear-gradient(to right, white 10px, transparent 10px),
            linear-gradient(to left, white 10px, transparent 10px),
            repeating-linear-gradient(white, white 29px, #ccc 29px, #ccc 30px, white 30px);
        line-height: 30px;
        padding: 8px 10px;
        min-height: 300px;
    }

    .notepad::-webkit-scrollbar,
    .editNotepad::-webkit-scrollbar {
        width: 6px;
    }

    .notepad::-webkit-scrollbar-track,
    .editNotepad::-webkit-scrollbar-track {
        background-color: #eee;
    }

    .notepad::-webkit-scrollbar-thumb,
    .editNotepad::-webkit-scrollbar-thumb {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .notepad-before {
        position: absolute;
        top: 1.5%;
        bottom: 3.5%;
        left: -10px;
        width: 20px;
        height: 95%;
        background-image: url("{{asset('asset/image/note-spiral-2.png')}}");
    }

    .editNotepad-before {
        position: absolute;
        top: 1.5%;
        bottom: 3.5%;
        left: -10px;
        width: 20px;
        height: 95%;
        background-image: url("{{asset('asset/image/note-spiral-2.png')}}");
    }

    .notedpad-after {
        position: absolute;
        top: 14px;
        bottom: 3.5%;
        right: -25px;
        width: 30px;
        height: 95%;
        background-image: url("{{asset('asset/image/note-ribbon-2.png')}}");
        max-height: 94px;
        border-left: 1px solid #ddd;
    }

    .editNotedpad-after {
        position: absolute;
        top: 14px;
        bottom: 3.5%;
        right: -25px;
        width: 30px;
        height: 95%;
        background-image: url("{{asset('asset/image/note-ribbon-2.png')}}");
        max-height: 94px;
        border-left: 1px solid #ddd;
    }

    .notepadHolder {
        position: relative;
    }

    .editNotepadHolder {
        position: relative;
    }

    .saveNote {
        position: absolute;
        left: calc(92% - 30px);
        bottom: 3%;
        width: 50%;
        display: flex;
        justify-content: start;
        padding: 0% 3%;
        color: green;
        font-size: 0.8rem;
        overflow: hidden;
    }

    .editSaveNote {
        position: absolute;
        left: calc(92% - 30px);
        bottom: 3%;
        width: 50%;
        display: flex;
        justify-content: start;
        padding: 0% 3%;
        color: green;
        font-size: 0.8rem;
        overflow: hidden;
    }

    .editSaveNote:hover {
        cursor: pointer;
    }

    .saveNote:hover {
        cursor: pointer;
    }

    .saveNoteImg {
        width: 30px;
    }

    .editSaveNoteImg {
        width: 30px;
    }

    .noteSaveText {
        position: absolute;
        display: none;
        bottom: 3%;
        color: #000000;
        font-size: 1rem;
        font-weight: 900;
    }

    .noteTip {
        position: absolute;
        left: 0px;
        font-size: 1rem;
        font-weight: 900;
        opacity: 0;
        pointer-events: none;
        transition: all 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .editNoteTip {
        position: absolute;
        left: 0px;
        font-size: 1rem;
        font-weight: 900;
        opacity: 0;
        pointer-events: none;
        transition: all 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .saveNote:hover .noteTip {
        opacity: 1;
        left: 35px;
        pointer-events: auto;
    }

    .editSaveNote:hover .editNoteTip {
        opacity: 1;
        left: 35px;
        pointer-events: auto;
    }

    .addNoteCaller.success:before {
        position: absolute;
        content: 'Notes Added ✅';
        color: green;
        top: 0px;
        right: calc(100% + 10px);
        display: flex;
        align-items: center;
        width: max-content;
        height: 100%;
        font-size: 1rem;
        font-weight: 700;
    }

    .addNoteCaller.error:before {
        position: absolute;
        content: 'Error Adding Notes ❌';
        color: red;
        top: 0px;
        right: calc(100% + 10px);
        display: flex;
        align-items: center;
        width: max-content;
        height: 100%;
        font-size: 1rem;
        font-weight: 700;
    }

    /* view notes */
    .noteListContainer {
        width: calc(100% - 300px);
        padding: 2%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .noteListWrapper {
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-bottom: 1%;
    }

    .noteActions {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: end;
        gap: 3%;
        padding: 2%;
        font-size: 1rem;
    }

    .notes {
        width: 100%;
        word-break: break-all;
        padding: 10px;
        background-color: #fff;
        min-height: 100px;
        border: 1px solid #449d44 !important;
    }

    #bell {
        position: absolute;
        top: 4px !important;
        right: -7px !important;
    }

    .btn {
        font-weight: 600;
        font-size: 13px !important;
    }

    .questionSearchContainer button {
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        position: relative;
        top: -5px;
        height: 50px;
        font-size: 1.2rem;
    }

    .pdf_complete {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .profilePic {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        margin-top: -10px;
    }

    .isYoursClass {
        color: blue !important;
        /* Set the desired color when is_yours is 1 */
    }

    .card-title {
        margin-bottom: .75rem;
        text-transform: capitalize;
    }

    sup.rounded-pill {
        position: absolute !important;
        top: 3px !important;
        background: red !important;
        color: #ddd !important;

    }

    /* .badge {
        position: absolute;
        top: -11px;
        right: 12px !important;
        padding: 5px 7px !important;
        border-radius: 50%;
        background: paleturquoise !important;
        color: white;
        font-size: 8px !important;
    } */

    .card-title {
        margin-bottom: .75rem;
        text-transform: capitalize;
    }

    .emptyMessage {
        align-items: end;
        font-size: 20px !important;
        color: red !important;
        font-weight: 600;
        padding-top: 179px;
    }

    .quiz {
        font-size: 1rem;
    }

    .audioPlayer {
        width: 1020px;
        height: 450px;

        position: relative;
        background-size: 100% 100%;
        border-radius: 50%;
        background-position: center;

    }




    .mlhud_img {
        width: 20%;
        height: 20%;
    }

    @media (max-width: 767px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 70%;
        }

        .subMenuWrapper {
            position: relative;
            width: calc(100% - 0px) !important;
            padding-left: 0px;
            padding-right: 0px;
            margin-left: 15px;
            overflow-x: auto;
        }

    }

    @media (min-width:320px)and (max-width:374px) {
        .badge {
            position: absolute !important;
            top: -6px !important;
            right: 79px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white !important;
            font-size: 8px !important;
        }

        .pdf-canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            width: 276px !important;
        }

        .pdf-containercompleted {
            overflow-y: scroll;
            /* Add a scrollbar for the container */
            max-height: 600px;
            width: 400px;
            /* Set a maximum height for the container */

        }
    }

    @media(min-width:1360px)and (max-width:1390) {
        .badge {
            position: absolute !important;
            top: -10px !important;
            right: 12px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white !important;
            font-size: 8px !important;
        }
    }

    @media (min-width:767px) and (max-width:1100px) {
        .badge {
            position: absolute !important;
            top: -10px !important;
            right: 1px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white !important;
            font-size: 8px !important;
        }

    }

    @media (min-width:1102px) and (max-width:1390px) {
        .badge {
            position: absolute !important;
            top: -10px !important;
            right: 17px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white !important;
            font-size: 8px !important;
        }

    }


    @media (min-width:767px)and (max-width:1439px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 70%;
        }

        .subMenuWrapper {
            position: relative;
            width: calc(100% - 0px) !important;
            padding-left: 0px;
            padding-right: 0px;
            margin-left: 15px;
            overflow-x: auto;
        }

        .videos {
            width: 55% !important;
        }

        .addNoteCaller {
            position: absolute;
            right: 42%;
            bottom: 15%;
            width: 40px;
            height: 40px;
            box-shadow: 2px 2px 6px 0px #00000080;
            border-radius: 50%;
        }


    }

    @media (min-width:424.96px) {
        .emptyMessage {
            align-items: end;
            font-size: 20px !important;
            color: red !important;
            font-weight: 600;
            padding-top: 179px;
        }

    }

    @media (min-width:1024.96px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 70%;
        }



        .videos {
            width: 100% !important;
        }

        .addNoteCaller {
            position: absolute;
            right: 44%;
            bottom: 15%;
            width: 40px;
            height: 40px;
            box-shadow: 2px 2px 6px 0px #00000080;
            border-radius: 50%;
        }
    }

    @media (min-width:374.96px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 70%;
        }

        /* .subMenuWrapper {
            position: relative;
            width: calc(100% - -40px) !important;
            padding-left: 0px;
            padding-right: 0px;
            margin-left: 15px;
            overflow-x: auto;
        } */
        .editNotepadHolderWrapper {
            position: relative !important;
            /* display: none; */
            width: 300px !important;
            padding-left: 58px !important;
            padding-right: 5px !important;
            padding-top: 6% !important;
        }

    }

    @media (min-width: 319.96px) and (max-width:374.96px) {

        /* .subMenuWrapper {
            position: relative;
            width: calc(100% - -40px) !important;
            padding-left: 0px;
            padding-right: 0px;
            margin-left: 15px;
            overflow-x: auto;
        } */
        .badge {
            position: absolute;
            top: -6px !important;
            right: 79px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white;
            font-size: 8px !important;
        }

        .editNotepadHolderWrapper {
            position: relative !important;
            /* display: none; */
            width: 300px !important;
            padding-left: 58px !important;
            padding-right: 5px !important;
            padding-top: 6% !important;
        }
    }

    @media (min-width: 320px) and (max-width:767px) {
        .subMenuWrapper {
            position: relative;
            width: calc(100% - -100px) !important;
            padding-left: 0px;
            padding-right: 0px;
            /* margin-left: 15px; */
            overflow-x: auto;
        }

        .noteListWrapper {
            width: max-content;
            display: flex;
            flex-direction: column;
            margin-bottom: 1%;
        }

        .pdf-containercompleted {
            overflow-y: scroll;
            /* Add a scrollbar for the container */
            max-height: 600px;
            width: 400px;
            /* Set a maximum height for the container */

        }

    }

    @media (min-width:424.96px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 70%;
        }

        /* .videos {
            width: 100% !important;
        } */

    }

    /* @media (min-width:575.96px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 40%
        }
    } */

    @media (min-width:991.96px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 70%;
        }
    }

    @media (min-width:1199.96px) {
        .audioPlayer audio {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    }
</style>
<style>
    .student_ratings {
        font-size: 16px;
        top: 3.5rem;
        position: relative;

    }

    .rating-num {
        margin-bottom: 0px;
        font-size: 70px;
        font-family: math;
        font-weight: bold;
        color: #b4690e;
    }

    .student_text h3 {
        font-size: 18px;
        font-family: serif;
        font-weight: bold;
        color: #b4690e;
    }

    .ratings {
        margin-right: 10px;
    }

    .ratings i {

        color: #cecece;
        font-size: 32px;
    }

    .rating-color {
        color: #b4690e !important;
    }

    .review-count {
        font-weight: 400;
        margin-bottom: 2px;
        font-size: 24px !important;
    }

    .small-ratings i {
        color: #cecece;
    }

    .review-stat {
        font-weight: 300;
        font-size: 18px;
        margin-bottom: 2px;
    }

    .star {
        position: relative;
        display: inline-block;
    }

    .star .fa-plus {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<style>
    /* Ratings widget */
    .rate {
        display: inline-block;
        border: 0;
    }

    /* Hide radio */
    .rate>input {
        display: none;
    }

    /* Order correctly by floating highest to the right */
    .rate>label {
        float: right;
    }

    /* The star of the show */
    .rate>label:before {
        display: inline-block;
        font-size: 52px;
        padding: .3rem .2rem;
        margin: 0;
        cursor: pointer;
        font-family: FontAwesome;
        content: "\f005 ";
        /* full star */
    }

    /* Half star trick */
    .rate .half:before {
        content: "\f089 ";
        /* half star no outline */
        position: absolute;
        padding-right: 0;
    }

    /* Click + hover color */
    input:checked~label,
    /* color current and previous stars on checked */
    label:hover,
    label:hover~label {
        color: gold;
    }

    /* color previous stars on hover */

    /* Hover highlights */
    input:checked+label:hover,
    input:checked~label:hover,
    /* highlight current and previous stars */
    input:checked~label:hover~label,
    /* highlight previous selected stars for new rating */
    label:hover~input:checked~label

    /* highlight previous selected stars */
        {
        color: #A6E72D;
    }

    .even-row {
        background-color: #F0F0F0;
        /* or any other desired color for even rows */
    }

    .odd-row {
        background-color: #FFFFFF;
        /* or any other desired color for odd rows */
    }

    .review_name {
        border: 1px solid black;
        background-color: #FFFFFF;
        height: 36px;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        width: 36px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .rating_name {
        display: flex;
        justify-content: center;
        padding-top: 15px;
        font-size: 12px !important;
    }

    @media (min-width:1439.96px) {
        .videos {
            width: 100% !important;
        }

        .addNoteCaller {
            position: absolute;
            right: 4%;
            bottom: 15%;
            width: 40px;
            height: 40px;
            box-shadow: 2px 2px 6px 0px #00000080;
            border-radius: 50%;
        }

        .badge {
            position: absolute !important;
            top: -10px !important;
            right: 16px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white !important;
            font-size: 8px !important;
        }
    }

    @media (min-width:375px) and (max-width:430px) {
        .badge {
            position: absolute !important;
            top: -6px !important;
            right: 101px !important;
            padding: 5px 7px !important;
            border-radius: 50% !important;
            background: paleturquoise !important;
            /* background-color: red; */
            color: white !important;
            font-size: 8px !important;
        }
    }

    #pdf-container {
        width: 100%;
        overflow-x: auto;
        /* Enable horizontal scrolling if needed */
    }

    .pdf-canvas {
        display: block;
        margin: 0 auto;
        max-width: 100%;
        height: auto;
    }

    #pdf-canvascompleted {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .pdf-containercompleted {
        overflow-y: scroll;
        /* Add a scrollbar for the container */
        max-height: 600px;
        width: 670px;
        /* Set a maximum height for the container */

    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<div class="container-fluid" id="backToTopLink">

    <div class="col-md-8" style="display:flex;justify-content: space-between;align-items: center;">

        <a href="/elearning/allCourses?sorted=Recently%20Added&tag=false&progress=false&q=false" class="btn btn-primary">Back</a>
        <h5>Course Contents</h5>
    </div>
    <br>
    @if(isset($course_certificate[0]->get_certified) && $course_certificate[0]->get_certified == 1)


    <div class="pdf-container" id="pdf-container">

        <canvas id="pdf-canvas" class="pdf-canvas"></canvas>
    </div>
    @endif

    @foreach($selected_class as $classContent)
    @if($classContent->class_status == 1)

    <input type="hidden" class="course_id" id="course_id" value="{{$classContent->course_id}}">
    <input type="hidden" class="class_id" id="class_id" value="{{$classContent->class_id}}">
    <input type="hidden" class="bookmark" id="bookmark" value="{{$classContent->bookmark}}">


    @endif
    <?php if ($classContent->class_format == 'mp4' && $classContent->class_status == 1) { ?>
        <video class="coursetypes videos" src="../../uploads/class/126/{{$classContent->resource_name}}" data-poster="../..{{$classContent->resource_path}}/{{$classContent->resource_name}}" frameborder="0" allowfullscreen controls width="100%">

        </video>
        <br>


    <?php } elseif ($classContent->class_format == 'mp3' && $classContent->class_status == 1) { ?>

        <div class="audioPlayer">
            <div class="col d-flex justify-content-center">
                <img class="mlhud_img" src="{{asset('assets/images/main.png')}}" alt="">
            </div>
            <audio class="coursetypes" controls='controls'>
                <source src="../../uploads/class/126/{{$classContent->resource_name}}" type='audio/mp3'>
            </audio>
        </div>
        <!-- <audio class="coursetypes" id="music" preload="true">
            <source src="../../uploads/class/126/{{$classContent->resource_name}}" type="audio/mp3">
        </audio> -->

    <?php } elseif ($classContent->class_format == 'pdf' && $classContent->class_status == 1) { ?>

        <center>
            <h1 style="color: green"></h1>
            <h3 style="overflow:hidden !important;">{{$classContent->class_name}}</h3>
            <div class="pdf-containercompleted" id="pdf-containercompleted">

            </div>
            <!-- <object class="coursetypes" data="../../uploads/class/126/{{$classContent->resource_name}}#toolbar=0" width="800" height="500">

            </object> -->

            <br>
            <div class="pdf_complete">
                <button class="btn btn-success" id="completed_doc" onclick="completion_doc(event);">Complete</button>
            </div>
        </center>


    <?php } ?>




    @endforeach

    @foreach($selected_class as $classContent)

    @if($classContent->class_status == 2 && $classContent->quiz_status == 0 && $classContent->class_quiz == "yes" )
    <div class="card quiz_details" id="quiz_details">
        <div class="card-header">
            <h4>Quiz Details</h4>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">Quiz Name:</label><span>{{$quizzesWithKey[$classContent->quiz_id]->quiz_name}}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">No.of Attempts:</label><span>{{isset($quiz_results[$classContent->quiz_id]) ? $quiz_results[$classContent->quiz_id]->attempt : '0'}}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">Score:</label><span>{{isset($quiz_results[$classContent->quiz_id]) ? $quiz_results[$classContent->quiz_id]->score : '-'}}</span>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">Pass mark:</label><span>{{isset($quiz_results[$classContent->quiz_id]) ? $quiz_results[$classContent->quiz_id]->pass_mark : '-'}}</span>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">

                        <a class="btn btn-primary" style="border-radius: 50px !important;background-color: darkblue;" href="{{ route('class.class_quiz', ['course_id' => $classContent->course_id, 'class_id' => $classContent->class_id]) }}">Take Quiz</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(isset($course_certificate[0]->exam_date) && isset($course_certificate[0]->pass_percentage))

    <div class="card exam_details" id="exam_details" style="display:none !important;">
        <div class="card-header">
            <h4>Exam Details</h4>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">Exam Name:</label><span>{{$course_certificate[0]->exam_name}}</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">Score:</label><span></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group quiz">
                            <label class="">Pass mark:</label><span>{{$course_certificate[0]->pass_percentage}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a class="btn btn-primary" style="border-radius: 50px !important;background-color: darkblue;" href="{{ route('course.exam', ['course_id' => $classContent->course_id, 'class_id' => $classContent->class_id]) }}">Take Exam</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    <!-- for pdf -->
    <!-- <iframe src="http://infolab.stanford.edu/pub/papers/google.pdf#toolbar=0&amp;navpanes=0&amp;scrollbar=0" frameborder="0" scrolling="auto" height="100%" width="100%" style="height: 70vh;"></iframe> -->
</div>
<div class="container-fluid border-bottom subMenuWrapper">
    <ul class="d-flex flex-row mb-0 subMenu">
        <li class="subMenuItem">
            <a class="subMenuLink active" id="overview" href="">Overview</a>
        </li>
        <li class="subMenuItem">
            <a class="subMenuLink" id="qAndA" href="">Q & A</a>
        </li>
        <li class="subMenuItem">
            <a class="subMenuLink" id="notes" href="">Notes</a>
        </li>
        <li class="subMenuItem">
            <a class="subMenuLink" id="rating" href="">Rating</a>
        </li>
    </ul>
    <div class="addNoteCaller">
        <span class="addNoteCallerTip">Add Note</span>
        <img src="{{asset('asset/image/New_note_Icon.png')}}" alt="">
    </div>
</div>
<div class="notepadContainer" style="position: relative; height: 0px;">
    <div class="notepadHolderWrapper">
        <div class="notepadHolder">
            <span class="notepad-before"></span>
            <textarea class="notepad"></textarea>
            <span class="notedpad-after"></span>
            <div class="saveNote">
                <span class="noteTip">SAVE</span>
                <img src="{{asset('asset/image/tickMark.png')}}" class="saveNoteImg" width="10px" alt="">
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="isForum" name="isForum" value="{{ $isForum }}">
<div class="container-fluid" id="overviewContent">
    @foreach($courseDetails as $courseDetail)
    <div class="card noShadow noBorder border-bottom classOverviewContent">
        <div class="card-body bgTransparent classOverviewContentBody">
            <h3 style="overflow:hidden !important;" class="card-title">
                {{$courseDetail->course_name}}
            </h3>
            <h6 style="overflow:hidden !important;" class="card-subtitle mb-2 text-muted">
                {{$courseDetail->course_instructor}}
            </h6>
            <p style="overflow:hidden !important;" class="card-text">
                {{$courseDetail->course_description}}
            </p>
            <input type="hidden" name="courseTags" class="courseTags" id="tags_{{$courseDetail->course_id}}" value="{{$courseDetail->course_tags}}" />
            <p class="card-text courseTagsHolder">

            </p>
            <input type="hidden" class="courseStartPeriod" id="startPeriod_{{$courseDetail->course_id}}" value="{{$courseDetail->course_start_period}}">
            <input type="hidden" class="courseEndPeriod" id="endPeriod_{{$courseDetail->course_id}}" value="{{$courseDetail->course_end_period}}">
            <p class="card-text courseDateHolder">

            </p>
        </div>
    </div>
    @endforeach
    <div class="row mb-3 bgTransparent border-bottom pt-3 willLearn">
        <div class="card noShadow noBorder w-100">
            <div class="card-body bgTransparent">
                <h5 class="card-title mb-4">What You will Learn</h5>
                @foreach($courseDetails as $courseDetail)
                <input type="hidden" id="courseGainSkils" value="{{$courseDetail->course_gain_skills}}">
                <ul class="card-text d-flex flex-row justify-content-between align-items-center">
                    <!-- Gain skills will be added here -->
                </ul>
                @endforeach
            </div>
        </div>
    </div>
    @foreach($courseContents as $courseContent)
    <input type="hidden" name="courseDuration" class="courseDuration" id="duration_{{$loop->iteration}}" value="{{$courseContent->class_duration}}">
    @endforeach
    <div class="row border-bottom pt-4 courseIncludes">
        <div class="col-12 mb-3">
            <div class="card noShadow courseIncludesHeader">
                <div class="card-body p-0">
                    <div class="card-title">
                        <h5>
                            This Course Includes
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
            @php $audio_exist=$audio_exist==0 ? 'd-none' :''; @endphp
            @php $video_exist=$video_exist==0 ? 'd-none' :''; @endphp
            @php $pdf_exist=$pdf_exist==0 ? 'd-none' :''; @endphp

            <div class="card noShadow hoursOfVideos img_shadow ">

                <span class="{{$audio_exist}}">
                    <img src="{{asset('asset/image/play.png')}}" class="card-img-top img-size" alt="play-icon">
                </span>
                <span class="$video_exist">
                    <img src="../../uploads/class/126/mp4.png" class="card-img-top img-size" alt="play-icon">
                </span>
                <span class="$pdf_exist">

                    <img src="../../uploads/class/126/pdf.png" class="card-img-top img-size" alt="play-icon">
                </span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
            <div class="card noShadow hoursOfVideos">
                <img src="{{asset('asset/image/play.png')}}" class="card-img-top" alt="play-icon">
                <div class="card-body">
                    <h6 class="card-title" id="totalHours">
                        <!-- total duration  -->
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
            <div class="card noShadow hoursOfVideos">
                <img src="{{asset('asset/image/resource.png')}}" class="card-img-top" alt="play-icon">
                <div class="card-body">
                    <h6 class="card-title">
                        {{$counts}} resources
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 align-items-stretch">
            @foreach($courseDetails as $courseDetail)
            @if($courseDetail->course_certificate=='1')
            <div class="card noShadow hoursOfVideos img_shadow">
                <img src="{{asset('asset/image/completion-certificate.png')}}" class="card-img-top img-size mt-2 mt-md-4" alt="play-icon">
                <div class="card-body">
                    <h6 class="card-title">
                        Certificate of completion
                    </h6>
                </div>
            </div>
            @elseif($courseDetail->course_certificate=='2')
            <div class="card noShadow hoursOfVideos img_shadow" style="display: none;">
                <img src="{{asset('asset/image/completion-certificate.png')}}" class="card-img-top img-size mt-2 mt-md-4" alt="play-icon">
                <div class="card-body">
                    <h6 class="card-title">
                        Certificate of completion
                    </h6>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row mb-3 bgTransparent border-bottom pt-3 coursePrerequisites">
        <div class="card noShadow noBorder w-100">
            <div class="card-body bgTransparent">
                <h5 class="card-title mb-4">Prerequisites</h5>

                @foreach($courseDetails as $courseDetail)
                <input type="hidden" id="courseSkillsRequired" value="{{$courseDetail->course_skills_required}}">
                <ul class="card-text d-flex flex-row justify-content-center align-items-between">
                    <!-- Skills Required will be added here -->
                </ul>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-3 px-5" id="qAndAContent" style="display: none;">

    <div class="forumQuestionView" id="forumQuestionView">
        <div class="row mb-4">

            <div class="col-10 questionSearchContainer">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <input type="search" class="form-control" id="questionSearch" name="questionSearch" placeholder="Search questions">
                    <!-- <button type="submit" id="questionSearchButton" onclick="applyfilter()">
                        <i class="fa fa-search" aria-hidden="true" style="pointer-events: none !important;"></i>
                    </button> -->
                </div>
            </div>
            <div class="col-2 text-center">
                <button class="btn btn-success askButton" id="askQuestionButton">
                    Ask a Question
                </button>
            </div>
            @foreach($askedQuestions as $askedQuestion)

            <input type="hidden" name="question_id" id="question_{{ $askedQuestion->question_id }}" class="question_id" value="{{ $askedQuestion->question_id }}">
            <input type="hidden" name="courseId" class="courseId" value="{{ $askedQuestion->course_id }}">

            @endforeach
            <div class="col-md-4">
                <select class="custom-select questionfollowed" name="questionfollowed">
                    <option value="">Select a Option</option>
                    <option value="Most Recent">Most Recent</option>
                    <option value="Most Followeds">Most Followed</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="custom-select questionSort" name="questionSort">
                    <option value="">Select a Option</option>
                    <option value="allquestions">All Questions</option>
                    <option value="myquestions">My Questions</option>
                </select>
            </div>

            <div class="col-md-12" style="display: flex;justify-content: center;">
                <a class="btn btn-success btn-space" onclick="applyfilter()" id="savebutton">Apply</a>
            </div>

        </div>

        <div class="question_container">

            <div class="col-12 mb-3">
                <div class="card noShadow courseIncludesHeader">
                    <div class="card-body p-0">
                        <div class="card-title">
                            <h5>
                                Questions in this course
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            @if($noQuestionsYet == true)
            <div class="w-100 text-center text-warning">
                No Questions has been asked in this course yet
            </div>
            @endif

            @if($noQuestionsYet == false)
            <!-- <div class="w-100 text-center text-warning">
                No Questions has been asked in this course yet
            </div> -->
            @foreach($askedQuestions as $askedQuestion)


            <div class="card noShadow mx-4 border-0 postedQuestionWrapper" id="question_{{ $askedQuestion->question_id }}">
                <div class="row no-gutters" id="class_{{ $askedQuestion->class_id }}">
                    <div class="col-md-1 d-flex flex-row justify-content-center pt-3">
                        <img class="profilePic" src="{{asset('asset/image/profile1.jpg')}}" alt="">
                    </div>
                    <div class="col-md-10 pt-1">
                        <h3 style="overflow:hidden !important;">
                            @php $exist= $askedQuestion->is_yours==0 ? : ''; @endphp
                            {{ $askedQuestion->question_header}}
                        </h3>
                        <input type="hidden" name="questionDescription" id="description_{{ $askedQuestion->question_id }}" class="questionDescription" value="{{ $askedQuestion->question_description }}">
                        <span style="overflow:hidden !important;" class="questionDescriptionHolder" id="descriptionFor_{{ $askedQuestion->question_id }}">
                            <!-- Description will be appended -->
                        </span>
                        <div class="d-flex flex-row justify-content-start mt-4" style="gap:10px !important;">
                            <span class="userName" style="font-weight: 700 !important;">
                                {{ $askedQuestion->name }}
                            </span>

                            <span class="postDate">
                                {{ \Carbon\Carbon::parse($askedQuestion->created_at)->format('d-m-Y H:i:s') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex flex-column align-items-center">
                        @if($askedQuestion->is_yours==0)
                        <i class="fa fa-plus-square-o followIcon {{$exist}} for_{{ $askedQuestion->question_id }}" onclick="addfollowup('{{ $askedQuestion->question_id }}','{{ $askedQuestion->course_id }}');" aria-hidden="true"><sup class="badge badge-light bell_notification">{{$askedQuestion->number_of_follows}}</sup></i>
                        @else
                        <i class="fa fa-plus-square-o followIcon isYoursClass for_{{ $askedQuestion->question_id }} " onclick="addfollowup('{{ $askedQuestion->question_id }}','{{ $askedQuestion->course_id }}');" aria-hidden="true"><sup class="badge badge-light bell_notification">{{$askedQuestion->number_of_follows}}</sup></i>
                        @endif
                        <i class="fa fa-reply replyIcon" onclick="addreply('{{ $askedQuestion->question_id }}','{{ $askedQuestion->user_id }}')" class="for_{{ $askedQuestion->question_id }}" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        <div class="d-flex flex-row justify-content-center allCoursePagination">
            {{ $askedQuestions->links() }}
        </div>
    </div>

    <div class="forumQuestionCreation" id="forumQuestionCreation" style="display: none;">
        <div class="row no-gutters mb-4">
            <div class="col-12 text-start">
                <button class="btn backToForumQuestionView" id="backToForumQuestionView">
                    Back To Questions
                </button>
            </div>
        </div>
        <div class="row">
            @foreach($courseDetails as $courseDetail)
            @php $id=Crypt::encrypt($courseDetail->course_id); @endphp
            <form class="col-lg-12 addQuestionForm" id="course_add" action="{{ route('addQuestion',$id) }}" method="post">
                @csrf
                @method('GET')
                <div class="form-group">
                    <label class="form-label">Question Heading</label>
                    <input type="text" class="form-control mb-4" name="Question_heading" id="Question_heading">
                </div>
                <div class="form-group">
                    <label class="form-label">Question Description</label>
                    <textarea class="form-control" id="Question_description" name="Question_description"></textarea>
                </div>
                <button class="btn btn-success forumSubmit" type="button" id="submitRedirectButton" onclick="course_submit()">Submit </button>
            </form>
            @endforeach
        </div>
    </div>

    <div id="custom_container_append" class="question_containercustom" style="display:none !important;">

        <div class="col-12 mb-3">
            <div class="card noShadow courseIncludesHeader">
                <div class="card-body p-0">
                    <div class="card-title">
                        <h5>
                            Questions in this course
                        </h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container-fluid d-flex flex-row flex-wrap" id="notesContent" style="display: none;">

    @foreach($courseDetails as $courseDetail)
    <input type="hidden" name="courseId" class="courseId" value="{{ $courseDetail->course_id }}">
    @endforeach
    <div class="noteListContainer pt-5" style="display:none;">
        <div class="w-100 d-flex flex-column justify-content-between" id="data-container"></div>
    </div>
    <div class="editNotepadHolderWrapper">
        <div class="editNotepadHolder">
            <span class="editNotepad-before"></span>
            <textarea class="editNotepad" readOnly></textarea>
            <span class="editNotedpad-after"></span>
            <div class="editSaveNote">
                <span class="editNoteTip">SAVE</span>
                <img src="{{asset('asset/image/tickMark.png')}}" class="editSaveNoteImg" width="10px" alt="">
            </div>
        </div>
    </div>
    <div class="w-100 text-center" id="pagination-container" style="display: none;"></div>
</div>
<div class="card noShadow mx-4 border-0 replypost" id="question_reply" style="display:none">

    <input type="hidden" name="courseId" class="courseId" value="{{ isset($askedQuestion->course_id) ? $askedQuestion->course_id :'' }}">

    <div class="row no-gutters" id="class_{{ isset($askedQuestion->class_id) ? $askedQuestion->class_id :''  }}">
        <div class="col-md-1 d-flex flex-row justify-content-center pt-3">
            <img class="profilePic" src="{{asset('asset/image/profile1.jpg')}}" alt="">
        </div>
        <div class="col-md-10 pt-1">
            <h3 style="overflow:hidden !important;" id="qustion_reply_header">
                {{ isset($askedQuestion->question_header) ? $askedQuestion->question_header : ''  }}
            </h3>
            <input type="hidden" name="questionDescription" id="qustion_reply_description" class="questionDescription" value="{{ isset($askedQuestion->question_description) ? $askedQuestion->question_description : '' }}">
            <span style="overflow:hidden !important;" class="qustion_reply_description" id="descriptionFor_{{ isset($askedQuestion->question_id) ? $askedQuestion->question_id : '' }}">
                <!-- Description will be appended -->
                {{ isset($askedQuestion->question_description) ? $askedQuestion->question_description : '' }}

            </span>
            <div class="container-fluid">

                <div class="replies" style="line-height: 27px !important;">


                </div>
            </div>

            <div>
                <textarea class="form-control" id="Question_reply" name="Question_reply"></textarea>
                <a class="btn btn-success" onclick="replysubmit('{{ isset($askedQuestion->question_id) ? $askedQuestion->question_id : '' }}','{{ isset($askedQuestion->course_id) ? $askedQuestion->course_id  :'' }}');">Submit</a>
                <a href="{{ URL::previous() }}" class="btn btn-primary">Cancel</a>
            </div>
        </div>

    </div>
</div>
<!--  -->

<div class="container-fluid" id="ratingContent" style="display: none;">
    <div style="display: flex;justify-content: space-between;align-items: center;">
        <h2 class="student_feedback">Ratings for {{$courseDetail->course_name}}</h2>
        <button class="btn btn-warning" type="button" style="border-radius: 20%;" data-toggle="modal" data-target="#addModal2"><i class="fa fa-star-o"></i><strong>Rating</strong></button>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-xs-12 col-md-3 text-center">
                            <h1 class="rating-num">
                                {{ $average_ratting['total_countstar'] }}
                            </h1>

                            <!-- <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div> -->

                            <div class="student_text">
                                <h3>Course Rating</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <div class="row rating-desc">

                                <div class="col-xs-8 col-md-9">
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $average_ratting['five_star'] }}%">
                                            <span class="sr-only">{{ $average_ratting['five_star'] }}</span>
                                        </div>
                                        <span class="percentage_data" style="font-weight: bolder;position: absolute;left: 50%;">{{ $average_ratting['five_star'] }}%</span>

                                    </div>


                                </div>
                                <div class="col-xs-8 col-md-3">
                                    <div class="small-ratings">
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                    </div>

                                </div>
                                <!-- end 5 -->

                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $average_ratting['four_star'] }}%">
                                            <span class="sr-only">{{ $average_ratting['four_star'] }}</span>
                                        </div>
                                        <span class="percentage_data" style="font-weight: bolder;position: absolute;left: 50%;">{{ $average_ratting['four_star'] }}%</span>

                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-3">
                                    <div class="small-ratings">
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>
                                <!-- end 4 -->

                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $average_ratting['three_star'] }}%">
                                            <span class="sr-only">{{ $average_ratting['three_star'] }}</span>
                                        </div>
                                        <span class="percentage_data" style="font-weight: bolder;position: absolute;left: 50%;">{{ $average_ratting['three_star'] }}%</span>

                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-3">
                                    <div class="small-ratings">
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>
                                <!-- end 3 -->

                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ $average_ratting['two_star'] }}%">
                                            <span class="sr-only">{{ $average_ratting['two_star'] }}</span>
                                        </div>
                                        <span class="percentage_data" style="font-weight: bolder;position: absolute;left: 50%;">{{ $average_ratting['two_star'] }}%</span>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-3">
                                    <div class="small-ratings">
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>

                                </div>
                                <!-- end 2 -->

                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: {{ $average_ratting['one_star'] }}%%">
                                            <span class="sr-only">{{ $average_ratting['one_star'] }}%</span>
                                        </div>
                                        <span class="percentage_data" style="font-weight: bolder;position: absolute;left: 50%;">{{ $average_ratting['one_star'] }}%</span>

                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-3">
                                    <div class="small-ratings">
                                        <i class="fa fa-star rating-color"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <!-- end 1 -->
                            </div>
                            <!-- end row -->
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">

        <div id="card-container">
            <div id="loader">
                @php $counter = 0; @endphp
                @foreach($ratings as $rating)
                <div class="row {{ $counter % 2 == 0 ? 'even-row' : 'odd-row' }}">
                    <div class="col-xs-12 col-md-2" style="display: flex;justify-content: space-evenly;align-items: center;">
                        <div class="review_name">
                            <h3 class="rating_name m-0 p-0" style="font-size: 12px !important;">{{$rating->name}}</h3>
                        </div>
                        <span class="reviewer_name">{{$rating->fullname}}</span>

                    </div>

                    <div class="col-xs-12 col-md-9">

                        <div class="margin_top_15">
                            <span class="small-ratings ratingsset1">
                                @php $ratings=$rating->rating_point*2;
                                $actual_rating=intval($ratings/2);

                                @endphp
                                @for($i=1;$i<=5;$i++) @if($i<=$actual_rating) <i class="fa fa-star rating-color"></i>
                                    @else
                                    <i class="fa fa-star unfilled-star"></i>
                                    @endif
                                    @endfor
                                    @if($ratings%2 !=0)
                                    <script>
                                        var fa_list = document.querySelector('.ratingsset1 .unfilled-star');
                                        fa_list.classList.remove('fa-star');
                                        fa_list.classList.add('fa-star-half-o');
                                        fa_list.classList.add('rating-color');
                                    </script>
                                    @endif

                            </span>
                            <span class="review_days">
                                {{$rating->created_at}}
                            </span>
                        </div>
                        <span>
                            <p>{{$rating->review}}</p>
                        </span>


                    </div>
                    <div class="col-xs-12 col-md-1"></div>

                    <div class="row">
                        <div class="col-xs-12 col-md-11 border_bottom"></div>

                    </div>

                </div>
                @php $counter++; @endphp
                @endforeach
            </div>

            <div class="card-actions">
                <span>Showing
                    <span id="card-count"></span> of
                    <span id="card-total"></span> cards
                </span>
            </div>


        </div>
    </div>
    <div class="modal fade modalreset" id="addModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Ratings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h5 style="display: flex;justify-content: center;margin-top: 20px !important;">
                    {{$courseDetail->course_name}}
                </h5>
                <div class="modal-body" style="display:flex;justify-content: center;">
                    <input type="hidden" class="course_id" id="course_id" value="{{$classContent->course_id}}">
                    <input type="hidden" class="ratings_point" id="ratings_point">

                    <div class="rate">
                        <input type="radio" class="ratting_class" id="rating10" name="rating" value="5.0" /><label for="rating10" title="5 stars"></label>
                        <input type="radio" class="ratting_class" id="rating9" name="rating" value="4.5" /><label class="half" for="rating9" title="4 1/2 stars"></label>
                        <input type="radio" class="ratting_class" id="rating8" name="rating" value="4.0" /><label for="rating8" title="4 stars"></label>
                        <input type="radio" class="ratting_class" id="rating7" name="rating" value="3.5" /><label class="half" for="rating7" title="3 1/2 stars"></label>
                        <input type="radio" class="ratting_class" id="rating6" name="rating" value="3.0" /><label for="rating6" title="3 stars"></label>
                        <input type="radio" class="ratting_class" id="rating5" name="rating" value="2.5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
                        <input type="radio" class="ratting_class" id="rating4" name="rating" value="2.0" /><label for="rating4" title="2 stars"></label>
                        <input type="radio" class="ratting_class" id="rating3" name="rating" value="1.5" /><label class="half" for="rating3" title="1 1/2 stars"></label>
                        <input type="radio" class="ratting_class" id="rating2" name="rating" value="1.0" /><label for="rating2" title="1 star"></label>
                        <input type="radio" class="ratting_class" id="rating1" name="rating" value="0.5" /><label class="half" for="rating1" title="1/2 star"></label>

                    </div>

                </div>
                <div class="col-md-12 rating_comments" style="display: none !important;">
                    <div class="form-group">
                        <label class="form-label">Comments</label>
                        <textarea class="form-control" id="rating_comments" name="rating_comments"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="ratings" onclick="rating_store(event);">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the button element
        var submitRedirectButton = document.querySelector('.noteTip');

        // Get the Q&A sub-menu link
        var notes = document.getElementById('notes');

        // Add a click event listener to the button
        submitRedirectButton.addEventListener('click', function(event) {
            // Show the Q&A tab by triggering a click on its link
            notes.click();
        });
    });
</script>


<script>
    // appending tags
    let courseTags = document.querySelector('.courseTags');
    let courseTagsHolder = document.querySelector('.courseTagsHolder');
    let tags = courseTags.value;
    const tagList = tags.split(", ");
    for (let tag of tagList) {
        let span = document.createElement('span');
        span.classList.add('badge-success');
        span.classList.add('tags');
        span.innerHTML = `${tag}`;
        courseTagsHolder.appendChild(span);
    }
    // appending course period
    let courseStartPeriod = document.querySelector('.courseStartPeriod');
    let courseEndPeriod = document.querySelector('.courseEndPeriod');
    let courseDateHolder = document.querySelector('.courseDateHolder');
    if (courseStartPeriod.value != "" && courseEndPeriod.value != "") {
        const [startDateValue, startTimeValue] = courseStartPeriod.value.split(' ');
        const [endDateValue, endTimeValue] = courseEndPeriod.value.split(' ');
        let Date = document.createElement('span');
        Date.innerText = `${startDateValue} - ${endDateValue}`;
        courseDateHolder.appendChild(Date);
    }
    // appending Gain Skills
    let courseGainSkils = document.querySelector('#courseGainSkils');
    let courseGainSkilsContainer = document.querySelector('#courseGainSkils + ul');
    let gainSkills = courseGainSkils.value;
    const gainSkillsList = gainSkills.split(", ");
    for (let gainskill of gainSkillsList) {
        let gainLi = document.createElement('li');
        gainLi.innerHTML = `${gainskill}`;
        gainLi.classList.add('courseGainSkils');
        courseGainSkilsContainer.appendChild(gainLi);
    }
    // Hours calculation
    function getExtension(url) {
        var file = url.split('.');
        return file[file.length - 1];
    }

    function secondsToHms(second) {
        if (second == 0) {
            return "0 Seconds";
        }
        d = Number(second);
        var h = Math.floor(second / 3600);
        var m = Math.floor(second % 3600 / 60);
        var s = Math.floor(second % 3600 % 60);

        var hDisplay = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";
        var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
        return hDisplay + mDisplay + sDisplay;
    }

    function convertToSeconds(minutes, seconds, hours = 0) {
        return Number(hours) * 60 * 60 + Number(minutes) * 60 + Number(seconds);
    }

    let courseDurations = document.querySelectorAll('.courseDuration');
    let totalHours = document.querySelector('#totalHours');
    let second = 0;
    for (let courseDuration of courseDurations) {
        duration = courseDuration.value;
        // const [hours, minutes, seconds] = duration.split('.');
        const timeArr = duration.split('.');
        let minutes = timeArr[0];
        let seconds = timeArr[1];
        let time = convertToSeconds(minutes, seconds);
        second = second + time;
    }
    let totalDuration = secondsToHms(second);
    console.log(totalDuration);
    document.querySelector('#totalHours').innerHTML = totalDuration;
    // appending Skills Required
    let courseSkillsRequired = document.querySelector('#courseSkillsRequired');
    let courseSkillsRequiredContainer = document.querySelector('#courseSkillsRequired + ul');
    let SkillsRequired = courseSkillsRequired.value;
    const SkillsRequiredList = SkillsRequired.split(", ");
    for (let SkillRequired of SkillsRequiredList) {
        let requiredLi = document.createElement('li');
        requiredLi.innerHTML = `${SkillRequired}`;
        requiredLi.classList.add('mb-2');
        requiredLi.classList.add('courseSkillsRequired');
        courseSkillsRequiredContainer.appendChild(requiredLi);
    }
    // active
    let activeSubMenu = document.querySelector('.subMenuLink.active').parentElement;
    activeSubMenu.classList.add('selected');

    let overview = document.querySelector('#overview');
    let qAndA = document.querySelector('#qAndA');
    let notes = document.querySelector('#notes');
    let rating = document.querySelector('#rating');
    let courseId = document.querySelector('.courseId');

    function subMenuNavigation(e) {
        //alert(e);
        e.preventDefault();
        let activeMenu = e.target;
        let subMenus = document.querySelectorAll('.subMenuLink');
        for (let subMenu of subMenus) {
            subMenu.classList.remove('active');
            subMenu.parentElement.classList.remove('selected');
            document.querySelector(`#${subMenu.id}Content`).style.display = "none";
        }
        document.querySelector('.editNotepadHolderWrapper').style.display = "none";
        document.querySelector('.noteListContainer').style.display = "none";
        document.querySelector('#notesContent #pagination-container').style.display = "none";
        if (activeMenu.id == "notes") {
            // alert('clicked');
            $.ajax({
                url: "{{ url('/viewNote') }}",
                type: 'GET',
                data: {
                    'courseId': courseId.value,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data.notes);

                    if (data.notes.length < 1) {
                        //  alert("0");
                        // let emptyMessage = document.createElement('div');
                        // emptyMessage.classList.add('emptyMessage');
                        // emptyMessage.innerText = "There is no notes added for this course yet";

                        document.querySelector(`#${activeMenu.id}Content #data-container`).innerHTML = `<div class="col-md-12"><div  style="width: max-content;color:red;">There is no notes added for this course yet</div></div>`;
                        // document.querySelector(`#${activeMenu.id}Content`).innerHTML = emptyMessage;

                        document.querySelector(`#${activeMenu.id}Content`).style.display = "flex";
                        document.querySelector(`.noteListContainer`).style.display = "block";
                        activeMenu.classList.add('active');
                        let activeSubMenu = document.querySelector('.subMenuLink.active').parentElement;
                        activeSubMenu.classList.add('selected');
                    } else {
                        document.querySelector('.editNotepadHolderWrapper').style.display = "block";
                        document.querySelector('.noteListContainer').style.display = "flex";
                        document.querySelector('#notesContent #pagination-container').style.display = "block";
                        document.querySelector(`#${activeMenu.id}Content`).style.display = "block";
                        activeMenu.classList.add('active');
                        let activeSubMenu = document.querySelector('.subMenuLink.active').parentElement;
                        activeSubMenu.classList.add('selected');
                    }
                },
                error: function(error) {
                    console.log('error; ' + eval(error));
                    let errorMessage = document.createElement('div');
                    errorMessage.classList.add('notesError');
                    errorMessage.innerText = "Some error occured";
                    document.querySelector(`#${activeMenu.id}Content`).innerHTML = errorMessage;
                    document.querySelector(`#${activeMenu.id}Content`).style.display = "block";
                    activeMenu.classList.add('active');
                    let activeSubMenu = document.querySelector('.subMenuLink.active').parentElement;
                    activeSubMenu.classList.add('selected');
                }
            })
        } else {
            document.querySelector(`#${activeMenu.id}Content`).style.display = "block";
            activeMenu.classList.add('active');
            let activeSubMenu = document.querySelector('.subMenuLink.active').parentElement;
            activeSubMenu.classList.add('selected');
        }
    }

    overview.addEventListener("click", subMenuNavigation);
    qAndA.addEventListener("click", subMenuNavigation);
    notes.addEventListener("click", subMenuNavigation);
    rating.addEventListener("click", subMenuNavigation);
    // Forum active check 
    let isForum = document.querySelector('.isForum').value;
    if (isForum == "True") {
        let subMenus = document.querySelectorAll('.subMenuLink');
        for (let subMenu of subMenus) {
            subMenu.classList.remove('active');
            subMenu.parentElement.classList.remove('selected');
            document.querySelector(`#${subMenu.id}Content`).style.display = "none";
        }
        document.querySelector(`#qAndAContent`).style.display = "block";
        qAndA.classList.add('active');
        qAndA.parentElement.classList.add('selected');
    }
    // new question
    let askQuestionButton = document.querySelector('#askQuestionButton');
    let forumQuestionCreation = document.querySelector('#forumQuestionCreation');
    let forumQuestionView = document.querySelector('#forumQuestionView');
    let backToForumQuestionView = document.querySelector('#backToForumQuestionView');

    function addQuestionScreen(e) {
        e.preventDefault();
        forumQuestionCreation.style.display = "block";
        forumQuestionView.style.display = "none";
    }

    function backToQuestionsScreen(e) {
        e.preventDefault();
        forumQuestionCreation.style.display = "none";
        forumQuestionView.style.display = "block";
    }

    askQuestionButton.addEventListener("click", addQuestionScreen);
    backToForumQuestionView.addEventListener("click", backToQuestionsScreen);


    let forumSubmit = document.querySelector('.forumSubmit');
    let questionHeading = document.querySelector('#Question_heading');
    let isSummitable = false;
    //  forumSubmit.addEventListener("click", backToQuestionsScreen);
    // forumSubmit.addEventListener("click", (e) => {
    //     if (isSummitable == false || questionHeading.value == '') {
    //         e.preventDefault();
    //     }
    // });
    // appending question descriptions
    let questionDescription = document.querySelectorAll('.questionDescription');
    for (let iterator of questionDescription) {
        let data = iterator.id.split('description_');
        if (document.querySelector(`#descriptionFor_${data[1]}`)) {
            document.querySelector(`#descriptionFor_${data[1]}`).innerHTML = iterator.value;
        }
    }
    // add note toggle
    let addNoteCaller = document.querySelector('.addNoteCaller');
    let notepadHolderWrapper = document.querySelector('.notepadHolderWrapper');
    addNoteCaller.addEventListener('click', (e) => {
        notepadHolderWrapper.classList.toggle('active');
    });
    // Save Note
    let saveNoteImg = document.querySelector('.saveNoteImg');
    let notepadArea = document.querySelector('.notepad');

    function saveNotes(e) {
        //alert(courseId.value);
        //var courseId = document.querySelector().value;
        if (notepadArea.value.length != 0) {
            let note = notepadArea.value;
            // Class name needs to be dynamic
            let classId = 30;
            $.ajax({
                url: "{{ url('/addNote') }}",
                type: 'GET',
                data: {
                    'courseId': courseId.value,
                    'classId': classId,
                    'note': note,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data == "Success") {
                        document.querySelector('.addNoteCallerTip').style.display = "none";
                        addNoteCaller.classList.add('success');
                        notepadArea.value = "";
                        notepadHolderWrapper.classList.remove('active');
                        setTimeout(function() {
                            document.querySelector('.addNoteCallerTip').style.display = "flex";
                            addNoteCaller.classList.remove('success');
                        }, 3000);
                        window.location.reload();
                    }
                },
                error: function(error) {
                    console.log('error; ' + eval(error));
                    document.querySelector('.addNoteCallerTip').style.display = "none";
                    addNoteCaller.classList.add('error');
                    setTimeout(function() {
                        document.querySelector('.addNoteCallerTip').style.display = "flex";
                        addNoteCaller.classList.remove('error');
                    }, 3000);
                }
            })
        }
    }
    saveNoteImg.addEventListener("click", saveNotes);
</script>

<script>
    $("#pagination-container").pagination({
        dataSource: function(done) {
            $.ajax({
                url: "{{ url('/viewNote') }}",
                type: 'GET',
                data: {
                    'courseId': courseId.value,
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                    let sampleArray = [];
                    let sampleIndex = 0;
                    for (let note of response.notes) {
                        let noteListWrapper = document.createElement('div');
                        noteListWrapper.classList.add('noteListWrapper');
                        noteListWrapper.setAttribute('data-note', `${note.note_id}`);
                        let editIcon = document.createElement('i');
                        editIcon.classList.add('fa');
                        editIcon.classList.add('fa-pencil');
                        editIcon.classList.add('edit');
                        editIcon.setAttribute('aria-hidden', 'true');
                        editIcon.style.color = "#449d44";
                        let deleteIcon = document.createElement('i');
                        deleteIcon.classList.add('fa');
                        deleteIcon.classList.add('fa-trash');
                        deleteIcon.classList.add('delete');
                        deleteIcon.setAttribute('aria-hidden', 'true');
                        deleteIcon.style.color = "#F92F60";
                        let noteActions = document.createElement('div');
                        noteActions.classList.add('noteActions');
                        noteActions.appendChild(editIcon);
                        noteActions.appendChild(deleteIcon);
                        let noteList = document.createElement('div');
                        noteList.classList.add('notes');
                        noteList.innerText = note.note;
                        noteListWrapper.appendChild(noteActions);
                        noteListWrapper.appendChild(noteList);
                        sampleArray[sampleIndex] = noteListWrapper;
                        sampleIndex++;
                    }
                    done(sampleArray);
                }
            });
        },
        pageSize: 2,
        className: "paginationjs-theme-green flex-column-reverse justify-content-center align-items-center",
        showNavigator: true,
        formatNavigator: '<%= rangeStart %>-<%= rangeEnd %> of <%= totalNumber %> notes',
        callback: function(data, pagination) {
            // template method of yourself
            // var html = data;
            if (data.length < 1) {
                $("#data-container").html("No Notes Added");
            } else {
                $("#data-container").html(data);
            }
            //$("#data-container").html(data);
        },
    });
    // notes edit and delete
    let noteListContainer = document.querySelector('.noteListContainer');

    function editNoteparser(e) {
        let noteId = e.target.parentElement.parentElement.getAttribute('data-note');
        if (e.target.classList.contains("edit")) {
            let content = e.target.parentElement.parentElement.querySelector('.notes').innerText;
            let editNoteArea = document.querySelector('.editNotepad');
            editNoteArea.value = content;
            editNoteArea.readOnly = false;
            document.querySelector('.editSaveNoteImg').parentElement.setAttribute('data-note', noteId);
        } else if (e.target.classList.contains("delete")) {
            //alert('delete');
            let notes = document.querySelectorAll('.noteListWrapper');
            for (let note of notes) {
                if (note.getAttribute('data-note') == noteId) {
                    //alert(noteId);
                    //note.style.display = 'none';
                    // delete note ajax function
                    $.ajax({
                        url: "{{ url('/deleteNote') }}",
                        type: 'GET',
                        data: {
                            'note_id': noteId,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(data) {
                            console.log(data);
                            if (data != 0) {
                                Swal.fire("Success!", "Note Deleted Successfully!", "success").then((result) => {

                                    location.reload();

                                })
                            }

                        }
                    });
                }
            }
        }
    }
    noteListContainer.addEventListener('click', editNoteparser);
    let editSaveNoteImg = document.querySelector('.editSaveNoteImg');

    function updateNote(e) {
        let updateNote = document.querySelector('.editNotepad').value;
        if (document.querySelector('.editSaveNote').getAttribute('data-note') == null) {
            // do nothing
        } else if (updateNote == '' || updateNote == '\n') {
            document.querySelector('.editNotepadHolderWrapper').classList.add('empty');
            setTimeout(() => {
                document.querySelector('.editNotepadHolderWrapper').classList.remove('empty');
            }, 3000);
        } else if (updateNote != '') {
            let noteId = document.querySelector('.editSaveNote').getAttribute('data-note');
            // alert('in');
            $.ajax({
                url: "{{ url('/updateNote') }}",
                type: 'GET',
                data: {
                    'noteId': noteId,
                    'updatedNote': updateNote,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data != 0) {
                        Swal.fire("Success!", "Note Update Successfully!", "success").then((result) => {

                            window.location.reload();

                        })
                    }
                }
            });
        }

    }

    editSaveNoteImg.addEventListener('click', updateNote);
</script>

<script>
    function addreply(question_id, user_id) {

        //alert(question_id);
        $.ajax({
            url: "{{ url('/addreply') }}",
            type: 'GET',
            data: {
                'question_id': question_id,
                'user_id': user_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                // alert(data.replylist.length);


                if (data.replylist.length == 0) {
                    //alert("vhde");
                    const single_reply = ` No Reply found`;
                    $('.replies').append(single_reply);
                    var replycontent = document.querySelector('.replypost');

                    replycontent.style.display = 'block';
                    return false;

                }

                $('#qustion_reply_header').text(data.replylist[0].question_header);
                $('.qustion_reply_description').html(data.replylist[0].question_description);


                var qacontent = document.getElementById('qAndAContent');
                qacontent.style.display = 'none';
                var replycontent = document.querySelector('.replypost');
                replycontent.style.display = 'block';
                $('.replies').children().remove();
                var reply_count = 1;
                for (const row of data.replylist2) {
                    //alert("bjce");
                    if (row.profile_image == null) {
                        row.profile_image = "{{asset('asset/image/profile1.jpg')}}";
                    }
                    const single_reply = ` <div class="col-md-1 d-flex flex-row justify-content-center pt-3" style="gap:9px;display:flex;align-items:end;font-weight:900;">
            <img class="profilePic" src="${row.profile_image}" alt="">
                <span>${row.name}</span>
            </div>
        <div class="d-flex mt-2" style="flex-direction:column;">
            
        <span class="userName" style="margin-left: 33px !important;font-size:16px !important;font-weight:600;">
            ${row.reply_details}</span>  


            <span class="postDate" style="padding-left:29px !important;">
            ${row.created_at}
            </span><span class="reply_data${reply_count}"></span></div> `;




                    $('.replies').append(single_reply);
                    console.log('data.replylist_admin');

                    console.log(data.replylist_admin);
                    for (const row2 of data.replylist_admin) {
                        console.log(row2);
                        if (row2.course_reply_id == row.id) {
                            $(`.reply_data${reply_count}`).append(`<div><img src="{{asset('assets/images/main.png')}}" style="width:35px !important;height:35px !important;"></img><label style="font-weight:700 !important;">admin reply:</label>${row2.reply_details}</div>`);
                        }


                    }
                    reply_count++;

                }




            }
        });



    }

    function replysubmit(question_id, course_id) {

        var reply_details = document.querySelector('#Question_reply').value;

        $.ajax({
            url: "{{ url('/replystore') }}",
            type: 'GET',
            data: {
                'question_id': question_id,
                'course_id': course_id,
                'reply_details': reply_details,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                if (data != 0) {
                    Swal.fire("Success!", "Reply Added Successfully!", "success").then((result) => {

                        location.reload();

                    })
                }



            }
        });





    }
    $(document).on('click', '.subMenuItem', function() {
        $('.replypost').hide();
    })

    function addfollowup(question_id, course_id) {

        // var follow_details = e.target.value;

        $.ajax({
            url: "{{ url('/followstore') }}",
            type: 'GET',
            data: {
                'question_id': question_id,
                'course_id': course_id,

                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                var existing_count = $(`.for_${question_id}`).children().text();
                //alert(existing_count);

                if (data != 0) {
                    $(`.for_${question_id}`).toggleClass('isYoursClass');
                    if (existing_count == '') {
                        $(`.for_${question_id}`).children().text('1');
                    } else {
                        existing_count++;
                        $(`.for_${question_id}`).children().text(`${existing_count}`);
                    }
                    swal.fire({
                        title: "Success",
                        text: "Followed Successfully",
                        icon: "success",
                    });
                }
                if (data == 0) {
                    $(`.for_${question_id}`).toggleClass('isYoursClass');
                    if (existing_count == '') {
                        $(`.for_${question_id}`).children().text('0');
                    } else {
                        existing_count--;
                        // alert(existing_count);
                        //         var existing_count2=3;
                        //         existing_count2--;
                        // alert(existing_count2);



                        $(`.for_${question_id}`).children().text(`${existing_count}`);
                    }
                    swal.fire({
                        title: "Success",
                        text: "UnFollowed Successfully",
                        icon: "success",
                    });
                }



            }
        });





    }

    function applyfilter() {

        // var follow_details = e.target.value;
        var questionSearch = document.getElementById('questionSearch').value;
        // alert(questionSearch);
        var followed = document.querySelector('.questionfollowed').value;
        // alert(followed);
        var questions = document.querySelector('.questionSort').value;
        //alert(questions);
        var course_id = document.querySelector('.courseId').value;
        // alert(course_id);
        var question_id = document.querySelector('.question_id').value;
        //  alert(question_id);


        $.ajax({
            url: "{{ url('/applyfilter') }}",
            type: 'GET',
            data: {
                'question_id': question_id,
                'questionSearch': questionSearch,
                'course_id': course_id,
                'number_of_follows': followed,
                'questions': questions,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                $('#custom_container_append').children().remove();
                var question_container = document.querySelector('.question_container');
                question_container.style.display = "none";
                var question_containercustom = document.querySelector('.question_containercustom');
                question_containercustom.style.display = "block";
                if (data.length == 0) {
                    //  alert(data);
                    var no_result = `<div class="card noShadow mx-4 border-0 postedQuestionWrapper"><div class="w-100 text-center text-warning">
            No Result Found
        </div></div>`;
                    $('#custom_container_append').append(no_result);
                    $('.pagination').css('display', 'none');
                    return false;

                }


                for (const row of data) {
                    console.log(row.question_id);
                    const singledata = `<div class="card noShadow mx-4 border-0 postedQuestionWrapper" id="question_${row.question_id}">
            <div class="row no-gutters" id="${ row.class_id }">
                <div class="col-md-1 d-flex flex-row justify-content-center pt-3">
                    <img class="profilePic" src="{{asset('asset/image/profile1.jpg')}}" alt="">
                </div>
                <div class="col-md-10 pt-1">
                    <h3 style="overflow:hidden !important;">
                    ${row.question_header}                        
                    </h3>
                    <input type="hidden" name="questionDescription" id="description_${row.question_id}" class="questionDescription" value="${row.question_description}">
                    <span style="overflow:hidden !important;" class="questionDescriptionHolder" id="descriptionFor_${row.question_id}"><p>${row.question_description}</p></span>
                    <div class="d-flex flex-row justify-content-start mt-4" style="gap:10px !important;">
                        <span class="userName" style="font-weight: 700 !important;">
                        ${row.name}
                        </span>
                        <span class="postDate">
                        ${row.created_at}
                        </span>
                    </div>
                    
                </div>
                <div class="col-md-1 d-flex flex-column align-items-center">
                    <i class="fa fa-plus-square-o followIcon for_{${row.question_id}} ${row.is_yours==1 ? 'isYoursClass' : ''} " onclick="addfollowup('${row.question_id}','${row.course_id}'); aria-hidden="true"><sup class="badge badge-light bell_notification">${row.number_of_follows !=null ? row.number_of_follows : ''}</sup></i>
                    <i class="fa fa-reply replyIcon" onclick="addreply('${row.question_id}','${row.user_id}')" class="for_{${row.question_id}}" aria-hidden="true"></i>
                </div>
            </div>
        </div>`;

                    $('#custom_container_append').append(singledata);
                    // $('.pagination').css('display', 'block');
                }
            }



        })
    }
</script>

<script>
    let videoInterval
    const coursetypes = document.querySelector('.coursetypes');
    //alert(coursetypes);

    var course_id = document.querySelector('.course_id').value;
    //alert(course_id);
    var class_id = document.querySelector('.class_id').value;
    // alert(class_id);
    coursetypes.addEventListener('play', function() {
        videoInterval = setInterval(() => {
            currentTime = Math.floor(coursetypes.currentTime);

            console.log('Current Time (in seconds):', currentTime);
            $.ajax({
                url: "{{ url('/Course/bookmark') }}",
                type: 'GET',
                data: {
                    'sec': currentTime,
                    'course_id': course_id,
                    'class_id': class_id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {

                }
            });





        }, 1000);
    })


    coursetypes.addEventListener('pause', function() {
        clearInterval(videoInterval);
    })

    window.onload = function() {
        var bookmark = $('#bookmark').val();
        document.querySelector('.coursetypes').currentTime = bookmark;

    }
</script>

<script>
    const coursetypesend = document.querySelector('.coursetypes');
    // alert(coursetypesend);

    var course_id = document.querySelector('.course_id').value;
    // alert(course_id);
    var class_id = document.querySelector('.class_id').value;
    // alert(class_id);

    coursetypesend.addEventListener('ended', function() {

        $.ajax({
            url: "{{ url('/status/update') }}",
            type: 'GET',
            data: {

                'course_id': course_id,
                'class_id': class_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                Swal.fire("Success!", "Class Completed Successfully!", "success").then((result) => {

                    location.reload();
                })


            }
        });






    })
</script>

<script>
    function completion_doc(e) {
        //alert("bjsa");
        if (e.target.id == "completed_doc") {
            Swal.fire({
                title: "Are you sure,you want to complete the class?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/status/update') }}",
                        type: 'GET',
                        data: {
                            'course_id': course_id,
                            'class_id': class_id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(data) {
                            // alert('feef');
                            if (result.value) {
                                Swal.fire("Success!", "Class Completed Successfully!", "success").then((result) => {

                                    location.reload();
                                })
                            }

                        }

                    });

                }

            })
        }

    }
    // document.addEventListener("DOMContentLoaded", function() {
    //     var backToTopLink = document.getElementById("backToTopLink");

    //     window.onscroll = function() {
    //         if (
    //             document.body.scrollTop > 20 ||
    //             document.documentElement.scrollTop > 20
    //         ) {
    //             backToTopLink.style.display = "block";
    //         } else {
    //             backToTopLink.style.display = "none";
    //         }
    //     };
    // });
    function rating_store(e) {

        // var rating_class = $('.ratting_class').val();
        // handleRatingClick();
        var course_id = document.getElementById('course_id').value;
        var comments = document.getElementById('rating_comments').value;
        var ratings = $('#ratings_point').val();

        if (e.target.id == "ratings") {
            Swal.fire({
                title: "Are you sure,you want to add the ratings?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/ratings/store') }}",
                        type: 'GET',
                        data: {
                            'course_id': course_id,
                            'review': comments,
                            'rating_point': ratings,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(data) {
                            // alert('feef');
                            if (result.value) {
                                Swal.fire("Success!", "Ratings Added Successfully!", "success").then((result) => {

                                    location.reload();
                                })
                            }

                        }

                    });

                }

            })
        }
    }

    $(document).ready(function() {
        $(document).on('click', '.ratting_class', function(e) {
            handleRatingClick.call(this, e); // Pass 'this' and 'e' as arguments
        });
    });

    function handleRatingClick(e) {

        var ratings_point = $(this).val();
        $('#ratings_point').val(ratings_point);
        $('.rating_comments').css('display', 'block');
        // rating_store(e, ratings);

    }
</script>

<script>
    function resetModal() {
        // Clear input values
        document.getElementById("rating_comments").value = "";

        // Remove selected radio button
        const radioButtons = document.querySelectorAll(".ratting_class");
        radioButtons.forEach((radio) => {
            radio.checked = false;
        });

        // Hide the comment field (if shown)
        document.querySelector(".rating_comments").style.display = "none";
    }
    // Reset the modal content when it's hidden
    document.getElementById("addModal2").addEventListener("hidden.bs.modal", function(event) {
        // Reset the modal when it's hidden
        resetModal();
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

@if(isset($course_certificate[0]))
<script>
    <?php
    // Assuming $course_certificate[0] is an object with properties
    $user_id = $course_certificate[0]->user_id;
    $course_id = $course_certificate[0]->course_id;

    // Construct the PDF URL using the properties
    $pdfUrl = asset("userdocuments/certificate/$user_id/$course_id/certificate.pdf") . '#toolbar=0&view=fitB&navpanes=0&scrollbar=0';
    ?>
    // PDF.js configuration
    const pdfUrl = '<?php echo $pdfUrl; ?>';
    console.log(pdfUrl);
    // Fetch the PDF document
    pdfjsLib.getDocument(pdfUrl).promise.then(pdfDoc => {
        // Fetch the first page
        pdfDoc.getPage(1).then(page => {
            const canvas = document.getElementById('pdf-canvas');
            const context = canvas.getContext('2d');

            // Set the canvas size according to the PDF page size
            const viewport = page.getViewport({
                scale: 1
            });
            canvas.width = viewport.width;
            canvas.height = viewport.height;

            // Render the PDF page on the canvas
            const renderContext = {
                canvasContext: context,
                viewport: viewport,
            };
            page.render(renderContext);
        });
    });
</script>
@endif

<script>
    const dataAttribute = '<?php echo "../../uploads/class/126/" . $classContent->resource_name; ?>';
    console.log(dataAttribute);

    const pdfUrl1 = dataAttribute;

    // Fetch the PDF document using PDF.js
    pdfjsLib.getDocument(pdfUrl1).promise.then(pdfDoc => {
        const pdfContainer = document.getElementById('pdf-containercompleted');

        // Render each page and add to the container
        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
            const pageContainer = document.createElement('div');
            pageContainer.classList.add('pdf-page-container');
            pdfContainer.appendChild(pageContainer);

            pdfDoc.getPage(pageNum).then(page => {
                // Create a canvas for the page
                const canvas = document.createElement('canvas');
                pageContainer.appendChild(canvas);
                const context = canvas.getContext('2d');

                // Set the canvas size according to the PDF page size
                const viewport = page.getViewport({
                    scale: 1
                });
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                // Render the PDF page on the canvas
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };
                page.render(renderContext);
            });
        }
    });
</script>

<!-- validate -->

<script>
    function course_submit() {
        var question_heading = $("#Question_heading").val();
        if (question_heading == 0) {
            swal.fire({
                title: "Error",
                text: "Please Enter the Question Heading",
                icon: "error",
            });
            return false;
        }
        var question_description = $("#Question_description").val();
        if (question_description == 0) {
            swal.fire({
                title: "Error",
                text: "Please Enter the Question Description",
                icon: "error",
            });
            return false;
        } else {
            swal.fire({
            text: "Do you want to Create a new Question?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('course_add').submit();
            }
        });
        }
    }
</script>
@endsection