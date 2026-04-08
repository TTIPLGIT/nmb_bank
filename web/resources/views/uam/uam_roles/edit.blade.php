@extends('layouts.adminnav')

@section('content')

<div class="main-content module_space">

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">
            <h5 class="heading_align" style="color:darkblue">Roles Edit</h5>

            {{ Breadcrumbs::render('uam_roles.edit',$rows[0]['role_id']) }}

            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" method="post" name="uam_roles" id="uam_roles"
                                onsubmit="return validateForm()"
                                action="{{ route('uam_roles.update',$rows[0]['role_id']) }}">

                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Role Name <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="role_name" name="role_name"
                                                placeholder="Enter Role Name" value="{{ $rows[0]['role_name'] }}"
                                                autocomplete="off">
                                        </div>
                                        @error('role_name')
                                        <div class="error">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <input class="form-control" type="hidden" id="role_id" name="role_id"
                                        placeholder="Enter Module Name" value="{{ $rows[0]['role_id']}}">
                                </div>

                                @php
                                $assignedScreenIds = collect($uam_role_screens ?? [])
                                ->pluck('screen_id')
                                ->toArray();

                                $assignedModuleIds = collect($uam_role_screens ?? [])
                                ->pluck('module_id')
                                ->unique()
                                ->toArray();

                                $assignedPermissionIds = collect($uam_role_screen_permissions ?? [])
                                ->pluck('screen_permission_id')
                                ->toArray();

                                @endphp

                                <div class="col-md-12">
                                    <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                                        <label class="control-label">
                                            Modules and Screen Permission
                                            <span style="color:red;font-size:16px;">*</span>
                                        </label>

                                        <ul id="treeview" class="hummingbird-base">

                                            @foreach ($parent_module_data as $parent)

                                            <li>
                                                <i class="fa fa-plus"></i>
                                                <label>
                                                    <input type="checkbox" id="node-{{ $parent['module_id'] }}"
                                                        data-id="{{ $parent['module_id'] }}"
                                                        @if(in_array($parent['module_id'], $assignedModuleIds)) checked
                                                        @endif>
                                                    {{ $parent['module_name'] }}
                                                </label>

                                                <ul>
                                                    @foreach ($module_data as $module1)
                                                    @if($module1['parent_module_id'] == $parent['module_id'])

                                                    <li>
                                                        <i class="fa fa-plus"></i>
                                                        <label>
                                                            <input type="checkbox"
                                                                id="node-{{ $module1['parent_module_id'] }}-{{ $module1['module_id'] }}"
                                                                data-id="{{ $module1['parent_module_id'] }}-{{ $module1['module_id'] }}"
                                                                @if(in_array($module1['module_id'], $assignedModuleIds))
                                                                checked @endif>
                                                            {{ $module1['module_name'] }}
                                                        </label>

                                                        <ul>
                                                            @foreach ($screens_data as $screen1)

                                                            @if($screen1['module_id'] == $module1['module_id'])

                                                            <li>
                                                                <label>
                                                                    <input type="checkbox"
                                                                        id="node-{{ $screen1['module_id'] }}-{{ $screen1['screen_id'] }}"
                                                                        data-id="{{ $screen1['module_id'] }}:{{ $screen1['screen_id'] }}"
                                                                        @if(in_array($screen1['screen_id'],
                                                                        $assignedScreenIds)) checked @endif>
                                                                    {{ $screen1['screen_name'] }}
                                                                </label>

                                                                <ul style="display:inline-flex;float:right">
                                                                    @foreach ($permissions_data as $permission)
                                                                    @if($permission['screen_id'] ==
                                                                    $screen1['screen_id'])

                                                                    <li>
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                class="hummingbird-end-node"
                                                                                data-id="node1-{{ $permission['screen_permission_id'] }}-{{ $screen1['module_id'] }}-{{ $screen1['screen_id'] }}"
                                                                                @if(in_array($permission['screen_permission_id'],
                                                                                $assignedPermissionIds)) checked @endif>
                                                                            {{ $permission['permission'] }}
                                                                        </label>
                                                                    </li>

                                                                    @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>

                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>

                                                    @endif
                                                    @endforeach
                                                </ul>
                                            </li>

                                            @endforeach
                                        </ul>

                                        @error('screen_id')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                        </div>

                        <input id="displayItems" name="displayItems" class="form-control" type="hidden">

                        <input id="displayItems1" name="screen_id" class="form-control" type="hidden">

                        <input id="displayItems2" name="permission_id" class="form-control" type="hidden">

                        <div class="para"></div>
                        <div class="row text-center">
                            <div class="col-md-12 btn_update_undo">

                                <button class="btn btn-success btn-space" type="submit">Update</button>&nbsp;
                                <!-- <button class="btn btn-primary" type="reset" onclick="mycheckfunction()"><i
                                        class="fa fa-undo"></i> Undo </button>&nbsp; -->
                                <a class="btn btn-danger footer_btn_cancel" href="{{ route('uam_roles.index') }}"><i
                                        class="fa fa-times"></i> Cancel </a>&nbsp;
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

<div class="container-fluid" style="display: none">
    <div class="row">

        <div class="col-sm-1">
        </div>


        <div class="col-sm-5 text-center">





            <div class="text-left">Override some defaults:</div>
            <form id="override_options_form" method="POST" action="" style="display: none">
                <div class="form-group">
                    <div class="checkbox text-left">
                        <label><input id="checkbox_doubles" name="checkbox_doubles" value="1" type="checkbox"
                                checked>Enable checking for n-tupel (doubles, triplets, ...) nodes</label>
                    </div>
                    <div class="checkbox text-left">
                        <label><input id="checkbox_get_items" name="checkbox_get_items" type="checkbox" value="1"
                                checked>Getting number of checked nodes on the fly</label>
                    </div>
                    <input type="hidden" name="select_tree" value="<br />
              <b>Notice</b>:  Undefined index: select_tree in <b>/storage/ssd4/607/2172607/public_html/hummingbird_v1.php</b> on line <b>317</b><br />
              ">
                    <input type="hidden" name="override_options_form" value="1">
                    <button class="btn btn-responsive btn-block btn-primary" type="submit"
                        id="submit_options">Submit</button>
                </div>
            </form>
            <hr>
        </div>

        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <script type="text/javascript">
        function mycheckfunction() {

            $("#treeview").hummingbird("uncheckAll");

            $("#displayItems").val('');
            $("#displayItems2").val('');
            $("#displayItems2").val('');



        }


        function validateForm() {

            let role_name = document.forms["uam_roles"]["role_name"].value;
            if (role_name == "") {
                bootbox.alert({
                    title: "Uam Role Edit",
                    centerVertical: true,
                    message: "Please enter role name",
                });
                return false;
            }

            let permission_id = document.forms["uam_roles"]["permission_id"].value;
            if (permission_id == "") {
                bootbox.alert({
                    title: "Uam Role Edit",
                    centerVertical: true,
                    message: "Please select module and screen permission",
                });
                return false;
            }

        }


        $(document).ready(function() {

            $("#role_name").keypress(function(event) {
                var inputValue = event.charCode;
                if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
                    event.preventDefault();
                }
            });




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

            // $("#treeview").hummingbird("disableNode",{attr:"id",name: "node-0-1-2-1",state:true});


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
                        "module": []
                    };
                    $("#treeview").hummingbird("getChecked", {
                        list: List1,
                        onlyEndNodes: true
                    });
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


    </div>
</div>

@endsection