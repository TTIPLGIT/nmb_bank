@extends('layouts.adminnav')

@section('content')

<style type="text/css">
    .form-control {
        text-transform: none !important;
    }

    .main-sidebar .sidebar-menu li a.has-dropdown:hover {

        background-color: none;
    }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">
        <div class="section-body mt-1">
            <h5 class="heading_align"  style="color:darkblue">Users Create</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" name="uam_modules" method="POST" action="{{ route('user.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">User Name <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter User Name">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Email <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email">
                                            @error('email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Password <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="password" name="password" placeholder="Enter Password">
                                            @error('password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Confirm Password <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter Password">
                                            @error('confirm_password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Screen Roles <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="roles_id">
                                                <option value="">Please Select Role</option>
                                                @foreach($rows as $key=>$row)
                                                <option value="{{ $row->id}}">{{ $row->role_name }}</option>
                                                @endforeach
                                            </select>

                                            @error('roles_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror


                                        </div>




                                        <!-- <div class="form-group">
                                            <label class="control-label">Designation <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="designation">
                                                <option value="">Please Select Designation</option>
                                                @foreach($designation as $key=>$row)
                                                <option value="{{ $row->id }}">{{ $row->designation_name }}</option>
                                                @endforeach
                                            </select>

                                            @error('designation')
                                            <div class="error">{{ $message }}</div>
                                            @enderror


                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Dashboard List <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="js-select5 form-control dashboard_list_id" multiple="multiple" name="dashboard_list_id[]">

                                                @foreach($dashboard as $key=>$row)
                                                <option value="{{ $row->id }}">{{ $row->dashboard_list_name }}</option>
                                                @endforeach
                                            </select>

                                            @error('dashboard_list_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror


                                        </div> -->
                                    </div>
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="control-label">Directorate and Department <span style="color: red;font-size: 16px;">*</span></label>


                                            <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">

                                                <ul id="treeview" class="hummingbird-base">
                                                    @if($parent_folder !="")
                                                    @foreach ($parent_folder as $key => $parent_folder_value)
                                                    <li>
                                                        <i class="fa fa-plus"></i> <label> <input id="node-{{ $parent_folder_value->document_folder_structure_id }}" data-id="{{ $parent_folder_value->document_folder_structure_id }}" type="checkbox" module="{{ $parent_folder_value->document_folder_structure_id }}"> {{ $parent_folder_value->folder_name }} P</label>
                                                        <ul>

                                                            @if($directorate !="")
                                                            @foreach ($directorate as $key => $directorate_value)
                                                            @if($parent_folder_value->document_folder_structure_id == $directorate_value->parent_document_folder_structure_id)

                                                            <li><i class="fa fa-plus"></i> <label> <input id="node-{{$directorate_value->parent_document_folder_structure_id }}-{{$directorate_value->id}}" data-id="{{$directorate_value->parent_document_folder_structure_id }}-{{$directorate_value->id }}" module="{{$directorate_value->parent_document_folder_structure_id }}" type="checkbox"> {{$directorate_value->folder_name }} dir</label>
                                                                <ul>

                                                                    @if($department !="")
                                                                    @foreach ($department as $key => $department_value)
                                                                    @if($directorate_value->id == $department_value->parent_document_folder_structure_id)

                                                                    <li><i class="fa fa-plus"></i> <label><input id="node-{{$department_value->parent_document_folder_structure_id}}-{{$department_value->id }}" data-id="{{$department_value->parent_document_folder_structure_id}}:{{$department_value->id }}" type="checkbox"> {{$department_value->folder_name }} dep</label>
                                                                        <ul>


                                                                            @if($sub_department !="")
                                                                            @foreach ($sub_department as $key => $sub_department_value_one)
                                                                            @if($department_value->id == $sub_department_value_one->parent_document_folder_structure_id)

                                                                            <li> <i class="fa fa-plus"></i> <label><input id="node1-{{$sub_department_value_one->parent_document_folder_structure_id }}-{{$sub_department_value_one->id }}" data-id="{{$sub_department_value_one->parent_document_folder_structure_id }}:{{$sub_department_value_one->id }}" type="checkbox"> {{$sub_department_value_one->folder_name }} s_dep</label>
                                                                                <!-- sub -->
                                                                                <ul>
                                                                                    @if($sub_department !="")
                                                                                    @foreach ($sub_department as $key => $sub_department_value_two)
                                                                                    @if($sub_department_value_one->documentfolderid == $sub_department_value_two->parent_document_folder_structure_id)

                                                                                    <li> <label><input id="node1-{{$sub_department_value_two->parent_document_folder_structure_id }}-{{$sub_department_value_two->id }}" data-id="{{$sub_department_value_two->parent_document_folder_structure_id }}:{{$sub_department_value_two->id }}" type="checkbox"> {{$sub_department_value_two->folder_name }} s_dep-2</label>

                                                                                        @endif
                                                                                        @endforeach
                                                                                        @endif

                                                                                </ul>
                                                                                <!-- sub -->
                                                                            </li>

                                                                            @endif
                                                                            @endforeach
                                                                            @endif

                                                                        </ul>
                                                                    </li>

                                                                    @endif
                                                                    @endforeach
                                                                    @endif

                                                                </ul>
                                                            </li>

                                                            @endif
                                                            @endforeach
                                                            @endif
                                                        </ul>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @error('directorate_department')
                                        <div class="error">{{ $message }}</div>
                                        @enderror

                                    </div>


                                    <input id="displayItems" name="displayItems" class="form-control" type="hidden">

                                    <input id="displayItems1" name="directorate_department" class="form-control" type="hidden">

                                    <input id="displayItems2" name="displayItems2" class="form-control" type="hidden">

                                    <div class="para"></div>


                                    <input class="form-control" type="hidden" id="parent_node_id" name="parent_node_id" placeholder="Enter Password" value="{{ $document_folder_structure_id }}">


                                    <input class="form-control" type="hidden" id="user_type" name="user_type" placeholder="Enter Password" value="AD">



                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">

                                        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
                                        <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                                        <a class="btn btn-danger" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>


<div class="container-fluid" style="display: none;">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-5 text-center">
            <div class="text-left">Override some defaults:</div>
            <form id="override_options_form" method="POST" action="" style="display: none;">
                <div class="form-group">
                    <div class="checkbox text-left">
                        <label><input id="checkbox_doubles" name="checkbox_doubles" value="1" type="checkbox" checked />Enable checking for n-tupel (doubles, triplets, ...) nodes</label>
                    </div>
                    <div class="checkbox text-left">
                        <label><input id="checkbox_get_items" name="checkbox_get_items" type="checkbox" value="1" checked />Getting number of checked nodes on the fly</label>
                    </div>
                    <input type="hidden" name="select_tree" value="<br />
                      <b>Notice</b>:  Undefined index: select_tree in <b>/storage/ssd4/607/2172607/public_html/hummingbird_v1.php</b> on line <b>317</b><br />
                      " />
                    <input type="hidden" name="override_options_form" value="1" />
                    <button class="btn btn-responsive btn-block btn-primary" type="submit" id="submit_options">Submit</button>
                </div>
            </form>
            <hr />
        </div>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <script type="text/javascript">
            $("input#name").on({
                keydown: function(e) {
                    if (e.which === 32)
                        return false;
                },
                change: function() {
                    this.value = this.value.replace(/\s/g, "");
                }
            });




            $(".js-select2").select2({
                closeOnSelect: false,
                placeholder: " Please Select Roles ",
                allowHtml: true,
                allowClear: true,
                tags: true // создает новые опции на лету
            });



            // $(".js-select3").select2({
            //                     closeOnSelect : false,
            //                     placeholder : " Please Select Directorate ",
            //                     allowHtml: true,
            //                     allowClear: true,
            //             tags: true // создает новые опции на лету
            //         });


            // $(".js-select4").select2({
            //                     closeOnSelect : false,
            //                     placeholder : " Please Select Department ",
            //                     allowHtml: true,
            //                     allowClear: true,
            //             tags: true // создает новые опции на лету
            //         });



            $(".js-select5").select2({
                closeOnSelect: false,
                placeholder: " Please Select Dashboard List ",
                allowHtml: true,
                allowClear: true,
                tags: true // создает новые опции на лету
            });
        </script>

        <script type="text/javascript">






        </script>



        <script type="text/javascript">
            $(document).ready(function() {




                $("#treeview_example_code_button").on("click", function() {
                    var that_code = $("#treeview_example_code");
                    that_code.toggle();
                    //console.log($("#treeview_example_code").css("display"))
                    var that_code_display = that_code.css("display");
                    if (that_code_display == "none") {
                        $(this).text("Show HTML");
                    } else {
                        $(this).text("Hide HTML");
                    }
                });


                $("#treeview_example_search_html").on("click", function() {
                    var that_code = $("#treeview_example_search_html_display");
                    that_code.toggle();
                    //console.log($("#treeview_example_code").css("display"))
                    var treeview_example_search_html_mode = that_code.css("display");
                    if (treeview_example_search_html_mode == "none") {
                        $(this).text("Show HTML");
                    } else {
                        $(this).text("Hide HTML");
                    }
                });

                $("#treeview_example_search_css").on("click", function() {
                    var that_code = $("#treeview_example_search_css_display");
                    that_code.toggle();
                    //console.log($("#treeview_example_code").css("display"))
                    var treeview_example_search_css_mode = that_code.css("display");
                    if (treeview_example_search_css_mode == "none") {
                        $(this).text("Show CSS");
                    } else {
                        $(this).text("Hide CSS");
                    }
                });


                //---------------------measure time-------------------------------//
                var responseTime = [];
                var actualTime = [];
                var responseTimeSend = false;
                var responseTimeCounter = 0;



                var startTime, endTime;

                function measure_start() {
                    startTime = new Date();
                };

                function measure_end() {
                    endTime = new Date();
                    var timeDiff = endTime - startTime; //in ms
                    // strip the ms
                    timeDiff /= 1000;

                    // get seconds
                    //var seconds = Math.round(timeDiff % 60);
                    var seconds = timeDiff;
                    //console.log(seconds + " sec");
                    $("#time_measure").val(seconds + " sec");
                    //return seconds;
                }
                //------------------------------------------------------------------//

                /* 
                 *        $("#treeview_container").on("mouseover", function() {
                 *      console.log($(this)[0].scrollTop)
                 *        });
                 * */




                //set defaults
                //$.fn.hummingbird.defaults.collapsedSymbol= "fa-arrow-circle-o-right"; //default="fa-plus"
                //$.fn.hummingbird.defaults.expandedSymbol= "fa-arrow-circle-o-down"; //default="fa-minus"
                $.fn.hummingbird.defaults.collapseAll = true; //false //default="true"
                $.fn.hummingbird.defaults.checkboxes = "enabled"; //disabled //default="enabled"
                //$.fn.hummingbird.defaults.checkboxesGroups= "disabled_grayed"; //disabled or disabled_grayed or enabled (default)
                $.fn.hummingbird.defaults.checkDoubles = false; //false //default="false"
                //depreciated
                //$.fn.hummingbird.defaults.checkDisabled= true; //false //default="false"



                //override defaults
                if ($("#checkbox_doubles").prop("checked") == true) {
                    $.fn.hummingbird.defaults.checkDoubles = true; //false //default="false"
                } else {
                    $.fn.hummingbird.defaults.checkDoubles = false; //false //default="false"
                }

                /* if ($("#checkbox_disabled").prop("checked") == true) {
                $.fn.hummingbird.defaults.checkDisabled= true; //false //default="false"
                } else {
                console.log("checkDisabled=false")
                $.fn.hummingbird.defaults.checkDisabled= false; //false //default="false"
                }
                
                */

                //initializing
                $("#treeview").hummingbird();


                //
                $("#treeview2").hummingbird();
                $("#treeview2").hummingbird("expandNode", {
                    attr: "id",
                    name: "xnode-0-1",
                    expandParents: true
                });
                $('#treeview2').css({
                    "pointer-events": "none"
                });


                $("#treeview").hummingbird("expandNode", {
                    attr: "id",
                    name: "node-0",
                    expandParents: true
                });

                //$("#treeview").hummingbird("disableNode",{attr:"id",name: "node-0-1-2-1",state:true});


                $("#CheckAll").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("checkAll");
                    measure_end();
                });


                $("#UnCheckAll").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("uncheckAll");
                    measure_end();
                });


                $("#CollapseAll").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("collapseAll");
                    measure_end();
                });


                $("#ExpandAll").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("expandAll");
                    measure_end();
                });

                $("#checkNode").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("checkNode", {
                        attr: "id",
                        name: $("#checkNodeOnID").val(),
                        expandParents: false
                    });
                    measure_end();
                });

                $("#uncheckNode").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("uncheckNode", {
                        attr: "id",
                        name: $("#uncheckNodeOnID").val(),
                        collapseChildren: false
                    });
                    measure_end();
                });

                $("#expandNode").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("expandNode", {
                        attr: "id",
                        name: $("#expandNodeOnID").val(),
                        expandParents: true
                    });
                    measure_end();
                });

                $("#collapseNode").on("click", function() {
                    measure_start();
                    $("#treeview").hummingbird("collapseNode", {
                        attr: "id",
                        name: $("#collapseNodeOnID").val(),
                        collapseChildren: true
                    });
                    measure_end();
                });

                // $("#disableNode").on("click", function(){
                //   measure_start();
                //   var state = $("#disable_state_true").prop("checked");
                //   var disableChildren = $("#disable_state_true_children").prop("checked");
                //   console.log("disableChildren= " + disableChildren)
                //   $("#treeview").hummingbird("disableNode",{attr:"id",name: $("#disableNodeOnID").val(),state:state,disableChildren:disableChildren});
                //   measure_end();
                // });

                $("#enableNode").on("click", function() {
                    measure_start();
                    var state = $("#enable_state_true").prop("checked");
                    var enableChildren = $("#enable_state_true_children").prop("checked");
                    console.log("enableChildren= " + enableChildren)
                    $("#treeview").hummingbird("enableNode", {
                        attr: "id",
                        name: $("#enableNodeOnID").val(),
                        state: state,
                        enableChildren: enableChildren
                    });
                    measure_end();
                });





                $("#getItems").on("click", function() {
                    measure_start();
                    var List = {
                        "id": [],
                        "dataid": [],
                        "text": [],
                        "module": []
                    };
                    $("#treeview").hummingbird("getChecked", {
                        list: List,
                        onlyParents: true
                    });
                    $("#displayItems").val(List.dataid.join(","));
                    //$("#displayItems1").html(List.text.join("<br>"));
                    var L = List.id.length;
                    if (L == 1) {
                        $("#num").val(L + " item checked");
                    } else {
                        $("#num").val(L + " items checked");
                    }
                });

                $("#getItems").on("click", function() {
                    measure_start();
                    var List1 = {
                        "id": [],
                        "dataid": [],
                        "text": [],
                        "module": []
                    };
                    $("#treeview").hummingbird("getChecked", {
                        list: List1,
                        onlyEndNodes: true
                    });
                    console.log(List1);
                    $("#displayItems1").val(List1.dataid.join("-"));
                    $("#displayItems2").val(List1.id.join(":"));
                    //$("#displayItems1").html(List.text.join("<br>"));
                    var L = List1.id.length;
                    if (L == 1) {
                        $("#num").val(L + " item checked");
                    } else {
                        $("#num").val(L + " items checked");
                    }
                });







                if ($("#checkbox_get_items").prop("checked") == true) {

                    //do it once on initialisation
                    var List = {
                        "id": [],
                        "dataid": [],
                        "text": [],
                        "module": []
                    };
                    $("#treeview").hummingbird("getChecked", {
                        list: List,
                        onlyParents: true
                    });
                    $("#displayItems").val(List.dataid.join(","));
                    var L = List.id.length;
                    if (L == 1) {
                        $("#num").val(L + " item checked");
                    } else {
                        $("#num").val(L + " items checked");
                    }


                    var List1 = {
                        "id": [],
                        "dataid": [],
                        "text": [],
                        "module": []
                    };
                    $("#treeview").hummingbird("getChecked", {
                        list: List1,
                        onlyEndNodes: true
                    });
                    console.log(List1);
                    $("#displayItems1").val(List1.dataid.join("-"));
                    $("#displayItems2").val(List1.id.join(":"));
                    var L = List1.id.length;
                    if (L == 1) {
                        $("#num").val(L + " item checked");
                    } else {
                        $("#num").val(L + " items checked");
                    }


                    $("#treeview").on("CheckUncheckDone", function() {
                        var List = {
                            "id": [],
                            "dataid": [],
                            "text": [],
                            "module": []
                        };
                        $("#treeview").hummingbird("getChecked", {
                            list: List,
                            onlyParents: true
                        });
                        $("#displayItems").val(List.dataid.join(","));
                        var L = List.id.length;
                        if (L == 1) {
                            $("#num").val(L + " item checked");
                        } else {
                            $("#num").val(L + " items checked");
                        }
                    });


                    $("#treeview").on("CheckUncheckDone", function() {
                        var List1 = {
                            "id": [],
                            "dataid": [],
                            "text": [],
                            "dataid1": []
                        };
                        console.log($("#treeview").hummingbird("getChecked", {
                            list: List1,
                            onlyEndNodes: true
                        }));
                        console.log(List1);

                        $("#displayItems1").val(List1.id.join("-"));
                        $("#displayItems2").val(List1.dataid.join(":"));
                        var L = List1.id.length;
                        if (L == 1) {
                            $("#num").val(L + " item checked");
                        } else {
                            $("#num").val(L + " items checked");
                        }
                    });

                }




                $("#treeview").hummingbird("checkNode", {
                    attr: "id",
                    name: ["node-2-29"],
                    expandParents: false
                });


                /* $("#treeview").hummingbird("search",{treeview_container:"body",search_input:"search_input",search_output:"search_output",search_button:"search_button",scrollOffset:0,onlyEndNodes:false});*/

                $("#treeview").hummingbird("search", {
                    treeview_container: "treeview_container",
                    search_input: "search_input",
                    search_output: "search_output",
                    search_button: "search_button",
                    scrollOffset: -515,
                    onlyEndNodes: false
                });

            });
        </script>


        @endsection

        @include('layouts.script')