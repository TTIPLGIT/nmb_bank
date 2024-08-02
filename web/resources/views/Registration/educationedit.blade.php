@extends('layouts.adminnav') @section('content')
<style>
  button i {
    pointer-events: none !important;
  }

  #tabs {
    overflow: hidden;
    width: 100%;
    margin: 0;

    padding: 0;
    list-style: none;
    font-size: 16px !important;
  }

  #tabs li {
    float: left;
    margin: 0 0.5em 0 0;
  }

  .fa-exchange {
    color: white !important;
    width: max-content !important;
  }

  #tabs a {
    position: relative;
    background: #d8ddd3;
    /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
    padding: 0.4em 1.5em;
    float: left;
    text-decoration: none;
    color: #444;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
    border-radius: 5px 0 0 0;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
  }

  #tabs a:hover,
  #tabs a:hover::after,
  #tabs a:focus,
  #tabs a:focus::after {
    background: #a9cadb;
  }

  #tabs a:focus {
    outline: 0;
  }

  #tabs a::after {
    content: "";
    position: absolute;
    z-index: 1;
    top: 0;
    right: -0.5em;
    bottom: 0;
    width: 1em;
    background: inherit;
    /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
    box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
    transform: skew(10deg);
    border-radius: 0 5px 0 0;
  }

  #tabs #addition-tab::after {
    content: "";
    position: absolute;
    z-index: 1;
    top: 0;
    right: -0.5em;
    bottom: 0;
    width: 1em;
    background: inherit;
    /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
    box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.4);
    transform: skew(10deg);
    border-radius: 0 5px 0 0;
  }

  #tabs #current a,
  #tabs #current a::after {
    background: #265077;
    z-index: 3;
    color: white !important;
  }

  body,
  .main-footer {
    background: white !important;
  }

  #content {
    background: #e9fffc;
    padding: 2em;
    position: relative;
    z-index: 1;
    border-radius: 0 5px 5px 5px;
    /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
    box-shadow: -4px 4px 4px rgb(0 0 0 / 50%),
      inset 1px 0px 0px rgb(255 255 255 / 40%);
  }

  .navv {
    -ms-flex-preferred-size: 0;
    flex-basis: none !important;
    -ms-flex-positive: 1;
    -webkit-box-flex: 1;
    flex-grow: 0 !important;
  }

  .switch-field {
    display: flex;
  }

  .switch-field input {
    position: absolute !important;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    width: 1px;
    border: 0;
    overflow: hidden;
  }

  .switch-field label {
    background-color: #e4e4e4;
    color: rgba(0, 0, 0, 0.6);
    font-size: 14px;
    line-height: 1;
    text-align: center;
    padding: 8px 16px;
    margin-right: -1px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3),
      0 1px rgba(255, 255, 255, 0.1);
    transition: all 0.1s ease-in-out;
  }

  .switch-field label:hover {
    cursor: pointer;
  }

  .switch-field input:checked+label {
    background-color: #a5dc86;
    box-shadow: none;
  }

  .switch-field label:first-of-type {
    border-radius: 4px 0 0 4px;
  }

  .switch-field label:last-of-type {
    border-radius: 0 4px 4px 0;
  }

  .ad {
    background-color: #2725a4 !important;
  }

  .educat {
    padding: 8px 10px !important;
  }
</style>
<div class="main-content">
  <div class="row justify-content-center">
    <div class="col-lg-12 col-md-12">
      <div class="" style="height: 100%; padding: 15px">
        <form action="{{ route('Registration.update',$user_id) }}" method="POST" id="eduedit_form" enctype="multipart/form-data">
          @csrf @method('put')
          <input type="hidden" class="form-control" id="user_details" name="user_details" value="educate" />
          <div class="tile" id="tile-1" style="margin-top: 10px !important">
            <!-- Nav tabs -->

            <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist" style="background-image: none">
              <li class="nav-items navv" class="active" style="flex-basis: 1 !important">
                <a class="nav-link" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> Diploma</b>
                  <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="
                      background-color: solid green !important;
                      color: green !important;
                      visibility: hidden !important;
                    " />
                  <div class="check"></div>
                </a>
              </li>
              <li class="nav-items navv" class="" style="flex-basis: 1 !important">
                <a class="nav-link" id="addition-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="addition" aria-selected="false"><i class="fas fa-map-signs"></i> <b>Under Graduation</b>
                  <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="
                      background-color: solid green !important;
                      color: green !important;
                      visibility: hidden !important;
                    " /></a>
              </li>
              <li class="nav-items navv" class="" style="flex-basis: 1 !important">
                <a class="nav-link" id="pg-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="pg" aria-selected="false"><i class="fas fa-map-signs"></i> <b>Post Graduation</b>
                  <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="
                      background-color: solid green !important;
                      color: green !important;
                      visibility: hidden !important;
                    " /></a>
              </li>
            </ul>
          </div>
          <!-- Tab panes -->

          <div id="content">
            <div id="tab1">
              <section class="section">
                <div class="section-body mt-1">
                  <div id="dynamic_fielddip"></div>
                  <button type="button" name="adddip" id="adddip" class="btn btn-primary ad">
                    <i class="fas fa-plus" style="color: white"></i>
                  </button>

                  <input type="hidden" name="attachment_countdip" id="attachment_countdip" value="0" />
                </div>
                <div style="display: flex; justify-content: center; width: 100%">
                  <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab2');" title="next" style="
                      background: #4d94ff !important;
                      border-color: #4d94ff !important;
                      color: white !important;
                    ">
                    <span class="btn-label" style="font-size: 13px !important"><i class="fa fa-arrow-right"></i></span>Next</a>
                </div>
              </section>
            </div>
            <div id="tab2">
              <section class="section">
                <div class="section-body mt-1">
                  <div id="dynamic_fieldug"></div>
                  <button type="button" name="addug" id="addug" class="btn btn-primary ad">
                    <i class="fas fa-plus" style="color: white"></i>
                  </button>
                </div>
                <input type="hidden" name="attachment_countug" id="attachment_countug" value="0" />
              </section>
              <div style="
                  display: flex;
                  justify-content: center;
                  width: 100%;
                  gap: 3.2px;
                ">
                <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab1');" title="next" style="
                    background: red !important;
                    border-color: red !important;
                    color: white !important;
                    margin-top: 10px !important;
                  ">
                  <span class="btn-label" style="font-size: 13px !important"><i class="fa fa-arrow-left"></i></span>Previous</a>
                <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab3');" title="next" style="
                    background: #4d94ff !important;
                    border-color: #4d94ff !important;
                    color: white !important;
                    margin-top: 10px !important;
                  ">
                  <span class="btn-label" style="font-size: 13px !important"><i class="fa fa-arrow-right"></i></span>Next</a>
              </div>
            </div>
            <div id="tab3">
              <section class="section">
                <div class="section-body mt-0">
                  <div id="dynamic_fieldpg"></div>
                  <button type="button" name="addpg" id="addpg" class="btn btn-primary ad ml-3 mb-1">
                    <i class="fas fa-plus" style="color: white"></i>
                  </button>
                  <input type="hidden" name="attachment_countpg" id="attachment_countpg" value="0" />
                  <!-- final submit button -->

                  <!-- final submit button -->

                  <div class="col-lg-12" id="register">
                    <div class="col-md-12 text-center">
                      <input type="hidden" class="form-control" id="reg_status" name="reg_status" value="" />
                      <input type="hidden" class="form-control" id="user_id" name="user_id" value="" />
                      <input type="hidden" class="form-control" name="registration_status" value="Registered" />

                      <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab2');" title="next" style="
                          background: red !important;
                          border-color: red !important;
                          color: white !important;
                        ">
                        <span class="btn-label" style="font-size: 13px !important"><i class="fa fa-arrow-left"></i></span>Previous</a>
                    </div>
                  </div>

                  <div class="col-lg-12" id="registr">
                    <div class="col-md-12 text-center">
                      <input type="hidden" class="form-control" id="reg_status" name="reg_status" value="" />
                      <input type="hidden" class="form-control" id="user_id" name="user_id" value="" />
                      <input type="hidden" class="form-control" name="registration_status" value="Registered" />
                    </div>
                  </div>

                  <div class="col-md-12 text-center">
                    <input type="hidden" class="form-control" id="reg_status" name="reg_status" value="" />
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="" />
                    <input type="hidden" class="form-control" name="registration_status" value="Registered" />
                  </div>
                </div>
              </section>
            </div>
          </div>
          <div style="display: flex; justify-content: center; width: 100%">
            <a type="button" class="btn btn-labeled btn-info" href="{{url('education_index')}}" title="next" style="
                background: red !important;
                border-color: red !important;
                color: white !important;
                margin-top: 15px !important;
              ">
              <span class="btn-label" style="font-size: 13px !important"><i class="fa fa-arrow-left"></i></span>Back</a>
            <button type="submit" onclick="eduedit()" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="
                background: green !important;
                border-color: green !important;
                color: white !important;
                margin-top: 15px !important;
                margin-left: 15px;
              ">
              <span class="btn-label" style="font-size: 13px !important"><i class="fa fa-check"></i></span>Update
            </button>
          </div>
          <div style="display: flex; justify-content: center; margin-top: 4px">
            <label style="color: black"><i><b>Please Click Submit to Complete Valuer/Surveyor/Assessor
                  Registration
                </b></i></label><br />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function month_validator() {

    const monthPickers = document.querySelectorAll('.month_date');

    for (const monthPicker of monthPickers) {
      const currentDate = new Date();
      const currentYear = currentDate.getFullYear();
      const currentMonth = currentDate.getMonth() + 1; // Adding 1 because months are zero-indexed

      // Create a string with the maximum allowed year and month
      const maxDate = `${currentYear}-${currentMonth.toString().padStart(2, '0')}`;

      // Set the max attribute of the input field
      monthPicker.setAttribute('max', maxDate);

    }

    // Get the current year and month

  }

  $(document).ready(function() {


    $("#content").find("[id^='tab']").hide(); // Hide all content
    $("#tabs li:first").addClass("active"); // Activate the first tab
    $("#tab1").fadeIn(); // Show first tab's content

    $('#tabs a').click(function(e) {
      e.preventDefault();
      if ($(this).closest("li").attr("id") == "current") { //detection for current tab
        return;
      } else {
        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $(this).parent().addClass("active"); // Activate this
        $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab
      }
    });
    var i = 0;
    var j = 0;
    var k = 0;
    var l = 0;
    var education = {
      !!json_encode($education) !!
    };
    var eul = education['ug'].length;
    if (education['ug'][0]['graduation'] == null) {
      eul = 0;
    }
    var epl = education['pg'].length;
    if (education['pg'][0]['graduation'] == null) {
      epl = 0;

    }
    var edl = education['dip'].length;
    if (education['dip'][0]['graduation'] == null) {
      edl = 0;

    }
    for (i = 0; i < eul;) {
      $('#addug').hide();
      var r = i + 1;
      var consolidate_markug = "'consolidate_markug'";
      var garduation_certificateug = "'garduation_certificateug'";
      var ugc = "'ugc'";
      var ugci = "ugc";
      var ugg = "'ugg'";
      var uggi = "ugg";

      var docugc = "'" + education['ug'][i]['cfp'] + '/' + education['ug'][i]['cfn'] + "'";
      var docugg = "'" + education['ug'][i]['gfp'] + '/' + education['ug'][i]['gfn'] + "'";
      var r = i + 1;
      var ugcd = "'ug" + r + "'";
      var ugrow = "rowug" + r + "";
      var ug = "ug";
      var remove = " (removeFunction(" + ugcd + ",'" + ug + "'))";
      $('#dynamic_fieldug').append('<section class="input-box ug" name="a" id="' + ugrow + '"><div class="educationug"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradug" id="graduationug" name="ug[' + i + '][graduation]" value="Under Graduate" readonly> </div></div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniug" id="university_nameug" name="ug[' + i + '][university_name]" value="' + education['ug'][i]['university_name'] + '"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsug" id="course_nameug" name="ug[' + i + '][course_name]"> <option value="' + education['ug'][i]['course_name'] + '">' + education['ug'][i]['course_name'] + '</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypug month_date" maxlength="18" id="yopug" name="ug[' + i + '][yop]" value="' + education['ug'][i]['yop'] + '"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> CGPA %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkug" id="m_percentageug" name="ug[' + i + '][m_percentage]" value="' + education['ug'][i]['m_percentage'] + '"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate: <span class="error-star" style="color:red;">*</span></label> <label>' + education['ug'][i]['cfn'] + '</label></div></div></div> <div class="row"> <div class="col-md-2"> <div class="form-group "> <label class="icon_attribute" style="gap:5px"> <a type="button" class="btn btn-success " title="Download Documents" href="' + education['ug'][i]['cfp'] + '/' + education['ug'][i]['cfn'] + '" download><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary btn_flex" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument(' + docugc + ')"><i class="fa fa-eye" style="color:white!important"></i></a></div></div><div class="col-md-2">  <button type="button" class="btn btn-info " id="' + ugc + 'f' + r + '" title="change Documents" value="' + r + '" onclick="changefile1(this,' + consolidate_markug + ',' + ugc + ')"><input type="hidden" id="ougcfn' + r + '" name="ug[' + i + '][ocfn]" value="' + education['ug'][i]['cfn'] + '"><input type="hidden" id="ougcfp' + r + '" name="ug[' + i + '][ocfp]" value="' + education['ug'][i]['cfp'] + '"><input type="hidden" id="' + ugci + 'i' + r + '" name="f' + r + '" value="1"><input type="hidden" id="' + ugci + 'yn' + r + '" name="' + ugci + 'yn' + r + '" value="1"><i class="fa fa-exchange" id="' + ugci + 'fi' + r + '" style="color:white!important">Change file</i></button></div><div class="col-md-3 dccug"  id="dconsolidate_markug' + r + '"><input type="file"  accept=".pdf, .doc, .png,"  class="form-control ccug educat"  id="consolidate_markug' + r + '" name="ug[' + i + '][consolidate_mark]"> <strong style="color: red;">Following files could be uploaded pdf,doc,png</strong></div> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Other Documents:</label><label>' + education['ug'][i]['gfn'] + '</label></div></div></div> <div class="row"> <div class="col-md-2"> <div class="form-group "> <label class="icon_attribute" style="gap:5px"> <a type="button" class="btn btn-success " title="Download Documents" href="' + education['ug'][i]['gfp'] + '/' + education['ug'][i]['gfn'] + '" download><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary btn_flex" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument(' + docugg + ')"><i class="fa fa-eye" style="color:white!important"></i></a></div></div><div class="col-md-7 icon_attribute"> <div class="">  <button type="button" class="btn btn-info " id="' + ugg + 'f' + r + '" title="change Documents" value="' + r + '" onclick="changefile1(this,' + garduation_certificateug + ',' + ugg + ')"><input type="hidden" id="ouggfn' + r + '" name="ug[' + i + '][ogfn]" value="' + education['ug'][i]['gfn'] + '"><input type="hidden" id="ouggfp' + r + '" name="ug[' + i + '][ogfp]" value="' + education['ug'][i]['gfp'] + '"><input type="hidden" id="' + uggi + 'i' + r + '" name="f' + r + '" value="1"><input type="hidden" id="' + uggi + 'yn' + r + '" name="' + uggi + 'yn' + r + '" value="1"><i class="fa fa-exchange" id="' + uggi + 'fi' + r + '" style="color:white!important">Change file</i></button></div> <div class="col-md-6 dgcug"  id="dgarduation_certificateug' + r + '"> <input type="file" accept=".pdf, .doc, .png," class="form-control gcug educat"  id="garduation_certificateug' + r + '" name="ug[' + i + '][garduation_certificate]"></div><div><button  type="button" name="remove" onclick="' + remove + '" id="' + ugcd + '" value=' + i + ' class="btn btn-danger btn_removeug">X</button></div> </div> </div></div>  </div></div></section>');
      i++;
      $("#attachment_countug").val(i);
    }
    for (j = 0; j < epl;) {
      $('#addpg').hide();
      var r = j + 1;
      var consolidate_markpg = "'consolidate_markpg'";
      var garduation_certificatepg = "'garduation_certificatepg'";
      var pgc = "'pgc'";
      var pgci = "pgc";
      var pgg = "'pgg'";
      var pggi = "pgg";
      var docpgc = "'" + education['pg'][j]['cfp'] + '/' + education['pg'][j]['cfn'] + "'";
      var docpgg = "'" + education['pg'][j]['gfp'] + '/' + education['pg'][j]['gfn'] + "'";
      var pgcd = "'pg" + r + "'";
      var pgrow = "rowpg" + r + "";
      var pg = "pg";
      var remove = " (removeFunction(" + pgcd + ",'" + pg + "'))";
      $('#dynamic_fieldpg').append('<section class="input-box pg" id="' + pgrow + '"><div class="educationpg"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradpg" id="graduationpg" name="pg[' + j + '][graduation]" value="Post Graduation" readonly> </div></div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unipg" id="university_namepg" name="pg[' + j + '][university_name]" value="' + education['pg'][j]['university_name'] + '"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crspg" id="course_namepg" name="pg[' + j + '][course_name]"> <option value="' + education['pg'][j]['course_name'] + '">' + education['pg'][j]['course_name'] + '</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year  <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control yppg month_date" maxlength="18" id="yoppg" name="pg[' + j + '][yop]" value="' + education['pg'][j]['yop'] + '"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> CGPA %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkpg" id="m_percentagepg" name="pg[' + j + '][m_percentage]" value="' + education['pg'][j]['m_percentage'] + '"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate: <span class="error-star" style="color:red;">*</span></label> <label>' + education['pg'][j]['cfn'] + '</label></div></div></div> <div class="row"> <div class="col-md-2"> <div class="form-group"> <label class="icon_attribute" style="gap:5px"> <a type="button" class="btn btn-success " title="Download Documents" href="' + education['pg'][j]['cfp'] + '/' + education['pg'][j]['cfn'] + '" download><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument(' + docpgc + ')"><i class="fa fa-eye" style="color:white!important"></i></a></div></div><div class="col-md-2">  <button type="button" class="btn btn-info " id="' + pgc + 'f' + r + '" title="change Documents" value="' + r + '" onclick="changefile1(this,' + consolidate_markpg + ',' + pgc + ')"><input type="hidden" id="opgcfn' + r + '" name="pg[' + j + '][ocfn]" value="' + education['pg'][j]['cfn'] + '"><input type="hidden" id="opgcfp' + r + '" name="pg[' + j + '][ocfp]" value="' + education['pg'][j]['cfp'] + '"><input type="hidden" id="' + pgci + 'i' + r + '" name="f1" value="1"><input type="hidden" id="' + pgci + 'yn' + r + '" name="' + pgci + 'yn' + r + '" value="1"><i class="fa fa-exchange" id="' + pgci + 'fi' + r + '" style="color:white!important">Change file</i></button></div><div class="col-md-2 dccpg"  id="dconsolidate_markpg' + r + '"> <input type="file" accept=".pdf, .doc, .png," class="form-control ccpg educat"  id="consolidate_markpg' + r + '" name="pg[' + j + '][consolidate_mark]"> <strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div></div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Other Documents:</label> <label>' + education['pg'][j]['gfn'] + '</label></div></div></div> <div class="row"> <div class="col-md-2"> <div class="form-group "> <label class="icon_attribute" style="gap:5px"> <a type="button" class="btn btn-success " title="Download Documents" href="' + education['pg'][j]['gfp'] + '/' + education['pg'][j]['gfn'] + '" download><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary btn_flex" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument(' + docpgg + ')"><i class="fa fa-eye" style="color:white!important"></i></a></div></div><div class="col-md-2"> <div class=""> <button type="button" class="btn btn-info " id="' + pgg + 'f' + r + '" title="change Documents" value="' + r + '" onclick="changefile1(this,' + garduation_certificatepg + ',' + pgg + ')"><input type="hidden" id="opggfn' + r + '" name="pg[' + j + '][ogfn]" value="' + education['pg'][j]['gfn'] + '"><input type="hidden" id="opggfp' + r + '" name="pg[' + j + '][ogfp]" value="' + education['pg'][j]['gfp'] + '"><input type="hidden" id="' + pggi + 'i' + r + '" name="f1' + r + '" value="1"><input type="hidden" id="' + pggi + 'yn' + r + '" name="' + pggi + 'yn' + r + '" value="1"><i class="fa fa-exchange" id="' + pggi + 'fi' + r + '" style="color:white!important">Change file</i></button><div class="col-md-2 dgcpg"  id="dgarduation_certificatepg' + r + '"> <input type="file" accept=".pdf, .doc, .png, class="form-control gcpg educat"  id="garduation_certificatepg' + r + '" name="pg[' + j + '][garduation_certificate]"></div><button  type="button" name="remove" id="' + pgcd + '" onclick="' + remove + '" value=' + j + ' class="btn btn-danger btn_removepg">X</button></div></div> </div> </div>  </div></div></section>');
      j++;
      $("#attachment_countpg").val(j);
    }
    for (k = 0; k < edl;) {
      $('#adddip').hide();
      var r = k + 1;
      var consolidate_markdip = "'consolidate_markdip'";
      var garduation_certificatedip = "'garduation_certificatedip'";
      var dipc = "'dipc'";
      var dipci = "dipc";
      var dipg = "'dipg'";
      var dipgi = "dipg";
      var docdipc = "'" + education['dip'][k]['cfp'] + '/' + education['dip'][k]['cfn'] + "'";
      var docdipg = "'" + education['dip'][k]['gfp'] + '/' + education['dip'][k]['gfn'] + "'";
      var dipcd = "'dip" + r + "'";
      var diprow = "rowdip" + r + "";
      var dip = "dip";
      var remove = " (removeFunction(" + dipcd + ",'" + dip + "'))";
      $('#dynamic_fielddip').append('<section class="input-box dip" id="' + diprow + '"><div class="educationdip"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Course Type:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control graddip" id="graduationdip" name="dip[' + k + '][graduation]" value="Diploma" readonly> </div></div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unidip"  id="university_namedip" name="dip[' + k + '][university_name]" value="' + education['dip'][k]['university_name'] + '"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsdip"  id="course_namedip" name="dip[' + k + '][course_name]"> <option value="' + education['dip'][k]['course_name'] + '">' + education['dip'][k]['course_name'] + '</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year  <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypdip month_date" maxlength="18"  id="yopdip" name="dip[' + k + '][yop]" value="' + education['dip'][k]['yop'] + '"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> CGPA %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkdip"  id="m_percentagedip" name="dip[' + k + '][m_percentage]" value="' + education['dip'][k]['m_percentage'] + '"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-12"> <div class="form-group mb-0"> <label> Graduation Certificate: <span class="error-star" style="color:red;">*</span></label> <label>' + education['dip'][k]['cfn'] + '</label></div></div></div> <div class="row"> <div class="col-md-2"> <div class="form-group "> <label class="icon_attribute" style="gap:5px"> <a type="button" class="btn btn-success " title="Download Documents" href="' + education['dip'][k]['cfp'] + '/' + education['dip'][k]['cfn'] + '" download><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument(' + docdipc + ')"><i class="fa fa-eye" style="color:white!important"></i></a></div></div><div class="col-md-2">  <button type="button" class="btn btn-info " id="' + dipc + 'f' + r + '" title="change Documents" value="' + r + '" onclick="changefile1(this,' + consolidate_markdip + ',' + dipc + ')"><input type="hidden" id="dipcfn' + r + '" name="dip[' + k + '][ocfn]" value="' + education['dip'][k]['cfn'] + '"><input type="hidden" id="odipcfp' + r + '" name="dip[' + k + '][ocfp]" value="' + education['dip'][k]['cfp'] + '"><input type="hidden" id="' + dipci + 'i' + r + '" name="f' + r + '" value="1"><input type="hidden" id="' + dipci + 'yn' + r + '" name="' + dipci + 'yn' + r + '" value="1"><i class="fa fa-exchange" id="' + dipci + 'fi' + r + '" style="color:white!important">Change file</i></button></div><div class="col-md-2 dccdip"  id="dconsolidate_markdip' + r + '">  <input type="file" accept=".pdf, .doc, .png," class="form-control ccdip educat"  id="consolidate_markdip' + r + '" name="dip[' + k + '][consolidate_mark]"> <strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div> </div> <div class="row"> <div class="col-md-12"> <div class="form-group"> <label> Other Documents: </label><label>' + education['dip'][k]['gfn'] + '</label></div></div></div> <div class="row"> <div class="col-md-2"> <div class="form-group "> <label class="icon_attribute" style="gap:5px"> <a type="button" class="btn btn-success " title="Download Documents" href="' + education['dip'][k]['gfp'] + '/' + education['dip'][k]['gfn'] + '" download><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument(' + docdipg + ')"><i class="fa fa-eye" style="color:white!important"></i></a></div></div><div class="col-md-2"><div class="">  <button type="button" class="btn btn-info " id="' + dipg + 'f' + r + '" title="change Documents" value="' + r + '" onclick="changefile1(this,' + garduation_certificatedip + ',' + dipg + ')"><input type="hidden" id="odipgfn' + r + '" name="dip[' + k + '][ogfn]" value="' + education['dip'][k]['gfn'] + '"><input type="hidden" id="odipgfp' + r + '" name="dip[' + k + '][ogfp]" value="' + education['dip'][k]['gfp'] + '"><input type="hidden" id="' + dipgi + 'i' + r + '" name="f' + r + '" value="1"><input type="hidden" id="' + dipgi + 'yn' + r + '" name="' + dipgi + 'yn' + r + '" value="1"><i class="fa fa-exchange" id="' + dipgi + 'fi' + r + '" style="color:white!important">Change file</i></button></div><div class="col-md-2 dgcdip"  id="dgarduation_certificatedip' + r + '">  <input type="file" accept=".pdf, .doc, .png," class="form-control gcdip educat"  id="garduation_certificatedip' + r + '" name="dip[' + k + '][garduation_certificate]"></div></div>  </div> </div> </div></div></section>');
      k++;
      $("#attachment_countdip").val(k);
    }
    var a = document.getElementsByClassName('dccdip');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('dccdip')[z].style.display = "none";
      document.getElementsByClassName('dccdip')[z].removeAttribute('required');

    }
    var a = document.getElementsByClassName('dgcdip');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('dgcdip')[z].style.display = "none";
      document.getElementsByClassName('dgcdip')[z].removeAttribute('required');

    }
    var a = document.getElementsByClassName('dccug');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('dccug')[z].style.display = "none";
      document.getElementsByClassName('dccug')[z].removeAttribute('required');

    }
    var a = document.getElementsByClassName('dgcug');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('dgcug')[z].style.display = "none";
      document.getElementsByClassName('dgcug')[z].removeAttribute('required');

    }
    var a = document.getElementsByClassName('dccpg');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('dccpg')[z].style.display = "none";
      document.getElementsByClassName('dccpg')[z].removeAttribute('required');

    }
    var a = document.getElementsByClassName('dgcpg');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('dgcpg')[z].style.display = "none";
      document.getElementsByClassName('dgcpg')[z].removeAttribute('required');

    }
    month_validator();


  });

  function DoActions(id) {

    $("#content").find("[id^='tab']").hide(); // Hide all content
    $("#tabs li").removeClass("active"); //Reset id's
    $("#tabs a").removeClass("active"); //Reset id's
    $("a[name='" + id + "']").parent().addClass("active");
    $('#' + (id)).fadeIn(); // Show content for the current tab

  }

  function submit() {

    document.getElementById('educreate_form').submit();
  }

  function changefile1(a, b, c) {
    var a = a.value;
    var yn = document.getElementById(c + 'yn' + a).value
    if (yn == "1") {
      document.getElementById(b + a).setAttribute('required', 'required');
      document.getElementById('d' + b + a).style.display = "inline-block";
      document.getElementById(c + 'yn' + a).value = "0";
      document.getElementById(c + 'i' + a).value = "0";
      document.getElementById(c + 'fi' + a).innerText = " Stay The Same";
    } else {
      document.getElementById(b + a).removeAttribute('required');
      document.getElementById('d' + b + a).style.display = "none";
      document.getElementById(c + 'yn' + a).value = "1";
      document.getElementById(c + 'i' + a).value = "1";
      document.getElementById(c + 'fi' + a).innerText = " Change File";
    }
  };
  var user_id = "<?php echo $user_id; ?>"
  document.getElementById('user_id').value = user_id;

  $("#addug").click(function(e) {
    e.target.style.display = "none";
    var ugci = "ugc";
    var uggi = "ugg";
    var i = $("#attachment_countug").val();
    i = parseInt(i);
    var r = i + 1;
    var ugcd = "'ug" + r + "'";
    var ugrow = "rowug" + r + "";
    var ug = "ug";
    var remove = " (removeFunction(" + ugcd + ",'" + ug + "'))";
    // $('#dynamic_field').append('<div id="rowphd"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');
    $('#dynamic_fieldug').append('<section class="input-box ug" name="a" id="' + ugrow + '"><div class="educationug"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradug"  id="graduationug" name="ug[' + i + '][graduation]" value="Under Graduate" readonly> </div></div> </div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniug"  id="university_nameug" name="ug[' + i + '][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsug"  id="course_nameug" name="ug[' + i + '][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year  <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypug month_date" maxlength="18"  id="yopug" name="ug[' + i + '][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> CGPA %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkug"  id="m_percentageug" name="ug[' + i + '][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h> </div><div class="row"><div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate: <span class="error-star" style="color:red;">*</span></label> <input type="file" accept=".pdf, .doc, .png," class="form-control ccug educat"  id="consolidate_markug" name="ug[' + i + '][consolidate_mark]"> 	<strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Other Documents:</label><input type="hidden" id="' + ugci + 'yn' + r + '" name="' + ugci + 'yn' + r + '" value="0"> <input type="hidden" id="' + uggi + 'yn' + r + '" name="' + uggi + 'yn' + r + '" value="0"> <input type="file" accept=".pdf, .doc, .png," class="form-control gcug educat"  id="garduation_certificateug" name="ug[' + i + '][garduation_certificate]"> 	<strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" onclick="' + remove + '" id="' + ugcd + '" value=' + i + ' class="btn btn-danger btn_removeug">X</button></div> </div></div></section>');
    i++;
    $("#attachment_countug").val(i);

    month_validator();
  });
  $("#addpg").click(function(e) {
    e.target.style.display = "none";
    var pgci = "pgc";
    var pggi = "pgg";
    var j = $("#attachment_countpg").val();
    j = parseInt(j);
    var r = j + 1;
    var pgcd = "'pg" + r + "'";
    var pgrow = "rowpg" + r + "";
    var pg = "pg";
    var remove = " (removeFunction(" + pgcd + ",'" + pg + "'))";
    // $('#dynamic_field').append('<div id="rowpg"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');
    $('#dynamic_fieldpg').append('<section class="input-box pg" id="' + pgrow + '"><div class="educationpg"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradpg"  id="graduationpg" name="pg[' + j + '][graduation]" value="Post Graduation" readonly> </div></div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unipg"  id="university_namepg" name="pg[' + j + '][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crspg"  id="course_namepg" name="pg[' + j + '][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year  <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control yppg month_date" maxlength="18"  id="yoppg" name="pg[' + j + '][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> CGPA %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkpg"  id="m_percentagepg" name="pg[' + j + '][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate: <span class="error-star" style="color:red;">*</span></label> <input type="file" accept=".pdf, .doc, .png," class="form-control ccpg educat"  id="consolidate_markpg" name="pg[' + j + '][consolidate_mark]"> 	<strong style="color: red;">Following files could be uploaded pdf,doc,png</strong></div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Other Documents:</label><input type="hidden" id="' + pgci + 'yn' + r + '" name="' + pgci + 'yn' + r + '" value="0"><input type="hidden" id="' + pggi + 'yn' + r + '" name="' + pggi + 'yn' + r + '" value="0"> <input type="file" accept=".pdf, .doc, .png," class="form-control gcpg educat"  id="garduation_certificatepg" name="pg[' + j + '][garduation_certificate]"> 	<strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="' + pgcd + '" onclick="' + remove + '" value=' + j + ' class="btn btn-danger btn_removepg">X</button></div> </div></div></section>');
    j++;
    $("#attachment_countpg").val(j);
    month_validator();
  });
  $("#adddip").click(function(e) {
    e.target.style.display = "none";
    var dipci = "dipc";
    var dipgi = "dipg";
    var k = $("#attachment_countdip").val();
    k = parseInt(k);
    var r = k + 1;
    var dipcd = "'dip" + r + "'";
    var diprow = "rowdip" + r + "";
    var dip = "dip";
    var remove = " (removeFunction(" + dipcd + ",'" + dip + "'))";
    // $('#dynamic_field').append('<div id="rowdip"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');
    $('#dynamic_fielddip').append('<section class="input-box dip" id="' + diprow + '"><div class="educationdip"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Course Type:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control graddip"  id="graduationdip" name="dip[' + k + '][graduation]" value="Diploma" readonly> </div></div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unidip"  id="university_namedip" name="dip[' + k + '][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsdip"  id="course_namedip" name="dip[' + k + '][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year  <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypdip month_date" maxlength="18"  id="yopdip" name="dip[' + k + '][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> CGPA %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkdip"  id="m_percentagedip" name="dip[' + k + '][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-4"> <div class="form-group"> Graduation Certificate:</label> <input type="file" class="form-control ccdip educat"  id="consolidate_markdip" name="dip[' + k + '][consolidate_mark]">	<strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Other Documents:</label><input type="hidden" id="' + dipci + 'yn' + r + '" name="' + dipci + 'yn' + r + '" value="0"><input type="hidden" id="' + dipgi + 'yn' + r + '" name="' + dipgi + 'yn' + r + '" value="0">   <input type="file" accept=".pdf, .doc, .png," class="form-control gcdip educat"  id="garduation_certificatedip" name="dip[' + k + '][garduation_certificate]">	<strong style="color: red;">Following files could be uploaded pdf,doc,png</strong> </div> </div> <div><button  style="margin-top:30px" type="button" name="remove" onclick="' + remove + '" id="' + dipcd + '" value=' + k + ' class="btn btn-danger btn_removedip">X</button></div> </div></div></section>');
    k++;
    $("#attachment_countdip").val(k);
    month_validator();
  });

  function removeFunction(bid, id) {

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this respective Data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {

        if (isConfirm) {
          var button_id = bid;

          i = $('#attachment_count' + id + '').val();
          button_id = "#row" + button_id + "";
          $(button_id).remove();
          --i;
          $('#attachment_count' + id + '').val;
          var a = document.getElementsByClassName(id);
          for (var z = 0; z < a.length; z++) {
            var grad = 'grad' + id + "";
            var clg = 'clg' + id + "";
            var uni = 'uni' + id + "";
            var crs = 'crs' + id + "";
            var yp = 'yp' + id + "";
            var mk = 'mk' + id + "";
            var gc = 'gc' + id + "";
            var cc = 'cc' + id + "";
            document.getElementsByClassName(grad)[z].setAttribute('name', "" + id + "[" + z + "][graduation]");
            document.getElementsByClassName(clg)[z].setAttribute('name', "" + id + "[" + z + "][college_name]");
            document.getElementsByClassName(uni)[z].setAttribute('name', "" + id + "[" + z + "][university_name]");
            document.getElementsByClassName(crs)[z].setAttribute('name', "" + id + "[" + z + "][course_name]");
            document.getElementsByClassName(yp)[z].setAttribute('name', "" + id + "[" + z + "][yop]");
            document.getElementsByClassName(mk)[z].setAttribute('name', "" + id + "[" + z + "][m_percentage]");
            document.getElementsByClassName(gc)[z].setAttribute('name', "" + id + "[" + z + "][consolidate_mark]");
            document.getElementsByClassName(cc)[z].setAttribute('name', "" + id + "[" + z + "][garduation_certificate]");
          }

          swal({
            title: "Deleted!",
            text: "Respective Data are deleted successfully!",
            icon: "success",
          }, function(isConfirm) {
            if (isConfirm) {
              location.reload();
            }
          });



        } else {
          swal("Cancelled", "Your respective Data is safe :)", "info");
        }
      });
  }


  $(document).on('click', '.btn_removepg', function() {


    var button_id = $(this).attr("id");
    j = $('#attachment_count' + button_id + '').val();
    $('#row' + button_id + '').remove();
    --j;
    $('#attachment_count' + button_id + '').val(j);
    var a = document.getElementsByClassName('pg');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('gradpg')[z].setAttribute('name', "pg[" + z + "][graduation]");
      document.getElementsByClassName('clgpg')[z].setAttribute('name', "pg[" + z + "][college_name]");
      document.getElementsByClassName('unipg')[z].setAttribute('name', "pg[" + z + "][university_name]");
      document.getElementsByClassName('crspg')[z].setAttribute('name', "pg[" + z + "][course_name]");
      document.getElementsByClassName('yppg')[z].setAttribute('name', "pg[" + z + "][yop]");
      document.getElementsByClassName('mkpg')[z].setAttribute('name', "pg[" + z + "][m_percentage]");
      document.getElementsByClassName('gcpg')[z].setAttribute('name', "pg[" + z + "][consolidate_mark]");
      document.getElementsByClassName('ccpg')[z].setAttribute('name', "pg[" + z + "][garduation_certificate]");
    }
  });
  $(document).on('click', '.btn_removedip', function() {

    var button_id = $(this).attr("id");
    k = $('#attachment_count' + button_id + '').val();
    $('#row' + button_id + '').remove();
    --k;
    $('#attachment_count' + button_id + '').val(k);
    var a = document.getElementsByClassName('dip');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('graddip')[z].setAttribute('name', "dip[" + z + "][graduation]");
      document.getElementsByClassName('clgdip')[z].setAttribute('name', "dip[" + z + "][college_name]");
      document.getElementsByClassName('unidip')[z].setAttribute('name', "dip[" + z + "][university_name]");
      document.getElementsByClassName('crsdip')[z].setAttribute('name', "dip[" + z + "][course_name]");
      document.getElementsByClassName('ypdip')[z].setAttribute('name', "dip[" + z + "][yop]");
      document.getElementsByClassName('mkdip')[z].setAttribute('name', "dip[" + z + "][m_percentage]");
      document.getElementsByClassName('gcdip')[z].setAttribute('name', "dip[" + z + "][consolidate_mark]");
      document.getElementsByClassName('ccdip')[z].setAttribute('name', "dip[" + z + "][garduation_certificate]");
    }
  });
  $(document).on('click', '.btn_removephd', function() {
    var button_id = $(this).attr("id");
    l = $('#attachment_count' + button_id + '').val();
    $('#row' + button_id + '').remove();
    --l;
    $('#attachment_count' + button_id + '').val(l);
    var a = document.getElementsByClassName('phd');
    for (var z = 0; z < a.length; z++) {
      document.getElementsByClassName('gradphd')[z].setAttribute('name', "phd[" + z + "][graduation]");
      document.getElementsByClassName('clgphd')[z].setAttribute('name', "phd[" + z + "][college_name]");
      document.getElementsByClassName('uniphd')[z].setAttribute('name', "phd[" + z + "][university_name]");
      document.getElementsByClassName('crsphd')[z].setAttribute('name', "phd[" + z + "][course_name]");
      document.getElementsByClassName('ypphd')[z].setAttribute('name', "phd[" + z + "][yop]");
      document.getElementsByClassName('mkphd')[z].setAttribute('name', "phd[" + z + "][m_percentage]");
      document.getElementsByClassName('gcphd')[z].setAttribute('name', "phd[" + z + "][consolidate_mark]");
      document.getElementsByClassName('ccphd')[z].setAttribute('name', "phd[" + z + "][garduation_certificate]");
    }
  });

  function getproposaldocument(id) {
    var id = (id);

    $.ajax({
      url: "{{url('view_proposal_documents')}}",
      type: 'post',
      data: {
        id: id,
        _token: '{{csrf_token()}}'
      },
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {
        if (data.length > 0) {
          $("#loading_gif").hide();
          var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
          $('.removeclass').remove();
          var document = $('#template').append(proposaldocuments);

        }
      }
    });
  };
</script>

<script>
  // Diploma Course choosing Validation //

  function eduedit() {
    // var coll = $("#college_namedip").val();
    // if (coll == "") {
    //   swal("Please Enter the College Name", "", "error");
    //   event.preventDefault();
    //   return false;
    // }

    var uni = $("#university_namedip").val();
    if (uni == "") {
      swal("Please Enter the University Name", "", "error");
      event.preventDefault();
      return false;
    }

    var cou = $("#course_namedip").val();
    if (cou == "0") {
      swal("Please Select the Course Name", "", "error");
      event.preventDefault();
      return false;
    }

    var year = $("#yopdip").val();
    if (year == "") {
      swal("Please Select the Completion Year ", "", "error");
      event.preventDefault();
      return false;
    }

    var percent = $("#m_percentagedip").val();
    if (percent == "") {
      swal("Please Enter the CGPA", "", "error");
      event.preventDefault();
      return false;
    }

    var marks = $("#consolidate_markdip").val();

    if (marks == "") {
      swal("Please Upload the Consolidate Marksheet", "", "error");
      event.preventDefault();
      return false;
    }

    var grad = $("#garduation_certificatedip").val();
    if (grad == "") {
      swal("Please Upload the Other Documents", "", "error");
      event.preventDefault();
      return false;
    }

    //   Undergraduated Course Choosing Validation //

    // var coll = $("#college_nameug").val();
    // if (coll == "") {
    //   swal("Please Enter the College Name", "", "error");
    //   event.preventDefault();
    //   return false;
    // }

    var uni = $("#university_nameug").val();
    if (uni == "") {
      swal("Please Enter the University Name", "", "error");
      event.preventDefault();
      return false;
    }

    var cou = $("#course_nameug").val();
    if (cou == "0") {
      swal("Please Select the Course Name", "", "error");
      event.preventDefault();
      return false;
    }

    var year = $("#yopug").val();
    if (year == "") {
      swal("Please Select the Completion Year ", "", "error");
      event.preventDefault();
      return false;
    }

    var percent = $("#m_percentageug").val();
    if (percent == "") {
      swal("Please Enter the CGPA", "", "error");
      event.preventDefault();
      return false;
    }

    var marks = $("#consolidate_markug").val();

    if (marks == "") {
      swal("Please Upload the Consolidate Marksheet", "", "error");
      event.preventDefault();
      return false;
    }

    var grad = $("#garduation_certificateug").val();
    if (grad == "") {
      swal("Please Upload the Other Documents", "", "error");
      event.preventDefault();
      return false;
    }

    //   Post Graduation Course choosing Validation //

    // var coll = $("#college_namepg").val();
    // if (coll == "") {
    //   swal("Please Enter the College Name", "", "error");
    //   event.preventDefault();
    //   return false;
    // }

    var uni = $("#university_namepg").val();
    if (uni == "") {
      swal("Please Enter the University Name", "", "error");
      event.preventDefault();
      return false;
    }

    var cou = $("#course_namepg").val();
    if (cou == "0") {
      swal("Please Select the Course Name", "", "error");
      event.preventDefault();
      return false;
    }

    var year = $("#yoppg").val();
    if (year == "") {
      swal("Please Select the Completion Year ", "", "error");
      event.preventDefault();
      return false;
    }

    var percent = $("#m_percentagepg").val();
    if (percent == "") {
      swal("Please Enter the CGPA", "", "error");
      event.preventDefault();
      return false;
    }

    var marks = $("#consolidate_markpg").val();

    if (marks == "") {
      swal("Please Upload the Consolidate Marksheet", "", "error");
      event.preventDefault();
      return false;
    }

    var grad = $("#garduation_certificatepg").val();
    if (grad == "") {
      swal("Please Upload the Other Documents", "", "error");
      event.preventDefault();
      return false;
    } else {
      document.getElementById("eduedit_form").submit();
    }
  }
</script>

@include('Registration.formmodal') @endsection