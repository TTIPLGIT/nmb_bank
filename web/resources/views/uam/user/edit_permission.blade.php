
@extends('layouts.adminnav')
@section('content')

<div class="main-content">

  <!-- Main Content -->
  <section class="section">
    
  
    <div class="section-body mt-1">

<div class="row">
  <div class="col-md-12 col-lg-12 mlr-auto">
    <div class="tile my-4">
      <h3 class="tile-title">User Role Screen Mapping Edit <span style="color:red" >( {{ $role_name }} )</span></h3>
        <div class="tile-body">
          <form class="form-horizontal" method="post" name ="uam_roles"  action="{{ route('user.update_data_permission') }}">
            @csrf
            <div class="row">
      
              <input type="hidden" name="user_id" id="user_id"  value="{{$user_id}}">
  
              <div class="col-md-12">
                <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                  <ul id="treeview" class="hummingbird-base">
              
                    <label class="control-label">Modules and Screen Permission <span style="color: red;font-size: 16px;">*</span></label>
                
                      @if($module_data !="")
                      @foreach ($module_data as $key => $module_data_value)
                      <li><i class="fa fa-plus"></i> <label> <input id="node--{{$module_data_value['module_id'] }}" data-id="{{$module_data_value['module_id'] }}"  module="{{$module_data_value['module_id'] }}" type="checkbox"> {{$module_data_value['module_name'] }}</label><ul>

                      @if($screens_data !="")
                      @foreach ($screens_data as $key => $screen_data_value)
                      @if($module_data_value['module_id'] == $screen_data_value['module_id'])
                      <li> <label><input  id="node-{{$screen_data_value['module_id'] }}-{{$screen_data_value['screen_id'] }}" data-id="{{$screen_data_value['module_id'] }}:{{$screen_data_value['screen_id'] }}"  type="checkbox"> {{$screen_data_value['screen_name'] }} </label><ul style="display:inline-flex;float:right">

                       @if($permissions_data !="")
                      @foreach ($permissions_data as $key => $permissions_data_value)
                      @if($screen_data_value['screen_id'] == $permissions_data_value['screen_id'])
                      <li> <label><input class="hummingbird-end-node" data-id="node1-{{$permissions_data_value['screen_permission_id'] }}-{{$screen_data_value['module_id'] }}-{{$screen_data_value['screen_id'] }}" id="{{$screen_data_value['module_id'] }}:{{$permissions_data_value['screen_id'] }}"  type="checkbox"> {{$permissions_data_value['permission'] }} </label></li>

                  
                       @endif
                       @endforeach
                       @endif

                      </ul>

                       @endif
                       @endforeach
                       @endif

                      </ul></li>
                 
                
                      @endforeach
                      @endif
               
                    </ul>      

              @error('screen_id')
                     <div class="error">{{ $message }}</div>
                     @enderror
                </div>
              </div>
            </div>
        
            <input id="displayItems" class="form-control" type="hidden">
            <input id="displayItems1"  name="screen_id" class="form-control" type="hidden">
            <input id="displayItems2"  name="permission_id"  class="form-control" type="hidden">

            <div class="para"></div>
            <div class="row text-center">
              <div class="col-md-12">
 
                <button class="btn btn-success" type="submit" > Update</button>&nbsp;
                <!-- <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp; -->

                  <a class="btn btn-danger" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
              </div>                
            </div>
          </form>
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
     <div class="text-left" >Override some defaults:</div>
     <form id="override_options_form" method="POST" action="" style="display: none">
      <div class="form-group">
       <div class="checkbox text-left">
        <label><input id="checkbox_doubles" name="checkbox_doubles" value="1" type="checkbox" checked>Enable checking for n-tupel (doubles, triplets, ...) nodes</label>          
      </div>
      <div class="checkbox text-left">
        <label><input id="checkbox_get_items" name="checkbox_get_items" type="checkbox" value="1" checked>Getting number of checked nodes on the fly</label>          
      </div>
      <input type="hidden" name="select_tree" value="<br />
      <b>Notice</b>:  Undefined index: select_tree in <b>/storage/ssd4/607/2172607/public_html/hummingbird_v1.php</b> on line <b>317</b><br />
      ">
      <input type="hidden" name="override_options_form" value="1">
      <button class="btn btn-responsive btn-block btn-primary" type="submit" id="submit_options">Submit</button>
    </div>
  </form>
  <hr>
</div>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
 

  $(document).ready(function(){

//    var user_id = $("#user_id").val();
   
//    function ParantFunction() {
//      var listdata = '<li>';
//      $.ajaxSetup({
//        headers: {
//          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        }
//      });
//      $.ajax({
//        url: '{{ url('/uam_user/modules_parents') }}', 
//        type:"POST",
//        dataType:"json",
//        data: { user_id:user_id,_token: '{{csrf_token()}}'},
//        async: false,
//        success:function(data){

//          console.log(data);

//          if (data.length == 0) {
//          }else{
//           for(i = 0 ; i < data.length; i++){

//             var module_id = data[i].module_id;

//             listdata += '<li><i class="fa fa-plus"></i> <label> <input id="node-'+data[i].module_id+'" data-id="'+data[i].module_id+'" type="checkbox" module="'+data[i].module_id+'"> '+data[i].module_name+'</label><ul>';

//             var module_id = data[i].module_id;
//             var user_id =  data[i].user_id;

//             $.ajaxSetup({
//               headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//               }
//             });
//             $.ajax({
//               url: '{{ url('/uam_user/modules_screen') }}', 
//               type:"POST",
//               dataType:"json",
//               data: {module_id,module_id, user_id:user_id,_token: '{{csrf_token()}}'},
//               async: false,
//               success:function(data){

//                 console.log(data);
//                 var screendata = data;

//                 if (screendata.length == 0) {
//                 }else{
//                   for(j = 0 ; j < screendata.length; j++){
//                     listdata += '<li> <label><input  id="node-'+screendata[j].module_id+'-'+screendata[j].screen_id+'" data-id="'+screendata[j].module_id+':'+screendata[j].screen_id+'"  type="checkbox"> '+screendata[j].screen_name+'</label><ul style="display:inline-flex;float:right">';

//                     var module_id = screendata[j].module_id;
//                     var user_id =  screendata[j].user_id;
//                     var screen_id = screendata[j].screen_id;
//                     $.ajaxSetup({
//                       headers: {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                       }
//                     });
//                     $.ajax({
//                       url: '{{ url('/uam_user/screen_permission') }}', 
//                       type:"POST",
//                       dataType:"json",
//                       data: {module_id,module_id, user_id:user_id,screen_id :screen_id, _token: '{{csrf_token()}}'},
//                       async: false,
//                       success:function(data){

//                         console.log(data);
//                         var permissiondata = data;

//                         if (permissiondata.length == 0) {
//                         }else{
//                          for(l = 0 ; l < permissiondata.length; l++){

//                           listdata += ' <li style="margin-right: 7px;"><label><input class="hummingbird-end-node"  id="node1:'+permissiondata[l].screen_permission_id+':'+permissiondata[l].module_id+':'+permissiondata[l].screen_id+'" data-id="'+permissiondata[l].module_id+':'+permissiondata[l].screen_id+'"   type="checkbox"> '+permissiondata[l].permission+'</label></li>';
//                         }
//                       }
//                       listdata += '</ul>';     
//                     },
//                     error:function(data){
//                       if(data.Success = false){
//                         if (window.confirm('Please check your network ! try again later'))
//                         {
//                           window.location = "/uam_user";
//                         }
//                       }
//                     }

//                   });

//                   }

//                 }

//                 listdata += '</li></ul>'; 
//               },


//               error:function(data){
//                 if(data.Success = false){
//                   if (window.confirm('Please check your network ! try again later'))
//                   {
//                     window.location = "/uam_user";
//                   }
//                 }
//               }

//             });

//           }

//         }

//         listdata += '</li>'; 
//         $('#treeview').html(listdata);
//       },
//       error:function(data){
//        if(data.Success = false){
//         if (window.confirm('Please check your network ! try again later'))
//         {
//           window.location = "/uam_user";
//         }
//       }
//     }
//   });

// }



   //       $.ajaxSetup({
   //         headers: {
   //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //         }
   //       });
   
   //       $.ajax({
   //         url: '{{ url('/uam_roles/childs') }}' + '/' + module_id,    
   //         type:"GET",
   //         dataType:"json",
   //         async: false,
   //         data: {module_id: module_id, _token: '{{csrf_token()}}'},
   //         success:function(data){
   //           var data1= data;
   //                         //console.log(data1);
   //                         if (data1.length == 0) {
   //                         }
   //                         else{
   //                           for(j = 0 ; j < data1.length; j++){
   //                            listdata += '<li><i class="fa fa-plus"></i> <label> <input id="node-'+data1[j].parent_module_id+'-'+data1[j].module_id+'" data-id="'+data1[j].parent_module_id+'-'+data1[j].module_id+'"  module="'+data1[j].parent_module_id+'" type="checkbox"> '+data1[j].module_name+' </label><ul>';
   
   //                            var module_id = data1[j].module_id;
   
   //                            $.ajaxSetup({
   //                             headers: {
   //                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //                             }
   //                           });
   
   //                            $.ajax({
   //                             url: '{{ url('/uam_roles/screens') }}' + '/' + module_id,    
   //                             type:"GET",
   //                             dataType:"json",
   //                             async: false,
   //                             data: {module_id: module_id, _token: '{{csrf_token()}}'},
   //                             success:function(data){
   //                               var screendata = data;
   //                               console.log(screendata);
   //                               if (screendata.length == 0) {
   //                               }else{
   //                                 for(k = 0 ; k < screendata.length; k++){
   //                                  listdata += '<li> <label><input  id="node-'+screendata[k].module_id+'-'+screendata[k].screen_id+'" data-id="'+screendata[k].module_id+':'+screendata[k].screen_id+'"  type="checkbox"> '+screendata[k].screen_name+'</label><ul style="display:inline-flex">';
   
   //                                  var module_id = screendata[k].module_id;
   //                                  var screen_id = screendata[k].screen_id;
   
   //                                  $.ajaxSetup({
   //                                   headers: {
   //                                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //                                   }
   //                                 });
   
   //                                  $.ajax({
   //                                   url: '{{ url('/uam_roles/permissions') }}',    
   //                                   type:"POST",
   //                                   dataType:"json",
   //                                   async: false,
   //                                   data: {module_id: module_id,screen_id:screen_id, _token: '{{csrf_token()}}'},
   //                                   success:function(data){
   //                                     var permissiondata = data;
   //                                     console.log(permissiondata);
   
   //                                     if (permissiondata.length == 0) {
   //                                     }else{
   //                                       for(l = 0 ; l < permissiondata.length; l++){

   //                                         listdata += '<li><label><input class="hummingbird-end-node"  id="node1:'+permissiondata[l].screen_permission_id+':'+permissiondata[l].module_id+':'+permissiondata[l].screen_id+'" data-id="'+permissiondata[l].module_id+':'+permissiondata[l].screen_id+'"   type="checkbox"> '+permissiondata[l].permission+'</label></li>';
   //                                       }
   //                                     }
   //                                     listdata += '</ul>';     
   //                                   },
   //                                   error:function(data){
   //                                     if(data.Success = false){

   //                                       if (window.confirm('Please check your network ! try again later'))
   //                                       {
   //                                         window.location = "/uam_roles";
   //                                       }
   //                                     }
   //                                   }
   //                                 });
   
   
   //                                }
   
   //                              }
   //                              listdata += '</ul></li>'; 
   //                            },
   //                            error:function(data){
   //                             if(data.Success = false){

   //                               if (window.confirm('Please check your network ! try again later'))
   //                               {
   //                                 window.location = "/uam_roles";
   //                               }
   //                             }
   //                           }
   //                         });
   
   //                          }
   
   //                        }
   //                        listdata += '</ul></li>'; 
   
   //                      },
   //                      error:function(data){
   //                       if(data.Success = false){

   //                         if (window.confirm('Please check your network ! try again later'))
   //                         {
   //                           window.location = "/uam_roles";
   //                         }
   //                       }
   //                     }
   //                   });
   // }
   
   
   // }
   
   // $('#treeview').html(listdata);
   // },
   // error:function(data){
   //   if(data.Success = false){

   //     if (window.confirm('Please check your network ! try again later'))
   //     {
   //       window.location = "/uam_roles";
   //     }
   //   }
   // }
   
   // });
   
   
   // }
   
   
   //ParantFunction();
   
   
   //     function ChildFunction($id,$data) {
   //       var module_id = $id;
   //       var parant_module = $data;
   //       $.ajaxSetup({
   //         headers: {
   //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //         }
   //       });
   //       $.ajax({
   //         url: '{{ url('/uam_roles/childs') }}' + '/' + module_id,    
   //         type:"GET",
   //         dataType:"json",
   //         data: {module_id: module_id, _token: '{{csrf_token()}}'},
   //         success:function(data){
   //               if (data.length == 0) {
   //     }else{
   //       //console.log(parent_module);
   //       for(i = 0 ; i < data.length; i++){

   //        // handleData(data); 
   // var parentdata = '<ul><li><i class="fa fa-plus"></i> <label> <input id="node-'+data[i].parent_module_id+'-'+data[i].module_id+'" data-id="custom-'+data[i].parent_module_id+'-'+data[i].module_id+'"  module="'+data[i].parent_module_id+'" type="checkbox"> '+data[i].module_name+' </label></li></ul>';
   //           $('#treeview').append(parentdata);
   //         ScreensFunction(data[i].module_id);
   //       }
   //     }
   //         },
   //         error:function(data){
   //           console.log(data);
   //         }
   //       });
   
   //     }
   
   //  function ScreensFunction($id) {
   //   var module_id = $id;
   //   $.ajaxSetup({
   //     headers: {
   //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //     }
   //   });
   //   $.ajax({
   //     url: '{{ url('/uam_roles/screens') }}' + '/' + module_id,    
   //     type:"GET",
   //     dataType:"json",
   //     data: {module_id: module_id, _token: '{{csrf_token()}}'},
   //     success:function(data){
   //  if (data.length == 0) {
   // }else{
   //   for(i = 0 ; i < data.length; i++){

   //   }
   // }
   //     },
   //     error:function(data){
   //       console.log(data);
   //     }
   //   });
   // }
   
   
   
   
   // $(document).ready(function(){
   //   $.ajaxSetup({
   //     headers: {
   //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //     }
   //   });
   
   //   $role_id = $("#role_id").val();
   
   
   //   $.ajax({
   //     url: '{{ url('/uam_roles/get_roles_screen') }}', 
   //     type:"POST",
   //     dataType:"json",
   
   //     data: {role_id : $role_id, _token: '{{csrf_token()}}' },
   //     success:function(data){
   //           //console.log(data);
   //           if (data.length == 0) {


   //           }else{
   //             for(i = 0 ; i < data.length; i++){
   //               var node = "node";
   
   //               var node1 = "node1";
   //               //console.log(node+'-'+data[i].module_id);
   //               document.getElementById(node+'-'+data[i].module_id+'-'+data[i].screen_id).checked = true;
   
   //               document.getElementById(node1+':'+data[i].screen_permission_id+':'+data[i].module_id+':'+data[i].screen_id).checked = true;
   
   //               document.getElementById(node+'-'+data[i].parent_module_id+'-'+data[i].module_id).checked = true;
   
   //               document.getElementById(node+'-'+data[i].parent_module_id).checked = true;
   
   
   
   
   
   //             }
   //           }
   //         },
   //         error:function(data){
   //          if(data.Success = false){

   //           if (window.confirm('Please check your network ! try again later'))
   //           {
   //             window.location = "/uam_roles";
   //           }
   //         }
   //       }
   //     });
   
   
   // });
   
   
   
   
   
   
   
   
   //          function myFunction() {

   //           $.ajaxSetup({
   //             headers: {
   //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //             }
   //           });
   
   // ///$screen_id = [];
   //     //$screen_id = $("#screen_id").val();
   //     var screen_id = $("#displayItems1").val();
   
   
   //  //var newdea = Object.assign([], screen_id);
   
   //  $screen_id = screen_id.split('-');
   
   //  $role_name = $("#role_name").val();
   //  $role_id = $("#role_id").val();
   
   
   
   //  //alert(usingSplit);
   
   //  $.ajax({
   //   url: '{{ url('/uam_roles/update_data') }}', 
   //   type:"POST",
   //   dataType:"json",
   //   data: {screen_id : $screen_id,role_name : $role_name,role_id: $role_id, _token: '{{csrf_token()}}' },
   //   success:function(data){


   //     window.location = "/uam_roles";
   
   //   },
   //   error:function(data){
   //     console.log(data);
   //   }
   // });
   
   
   // }
   
   
   
   $("#treeview_example_code_button").on("click",function(){
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
   
   
   $("#treeview_example_search_html").on("click",function(){
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
   
   $("#treeview_example_search_css").on("click",function(){
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
   $.fn.hummingbird.defaults.collapseAll= true; //false //default="true"
   $.fn.hummingbird.defaults.checkboxes= "enabled"; //disabled //default="enabled"
   //$.fn.hummingbird.defaults.checkboxesGroups= "disabled_grayed"; //disabled or disabled_grayed or enabled (default)
   $.fn.hummingbird.defaults.checkDoubles= false; //false //default="false"
   //depreciated
   //$.fn.hummingbird.defaults.checkDisabled= true; //false //default="false"
   
   
   
   //override defaults
   if ($("#checkbox_doubles").prop("checked") == true) {
   $.fn.hummingbird.defaults.checkDoubles= true; //false //default="false"
 } else {
   $.fn.hummingbird.defaults.checkDoubles= false; //false //default="false"
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
   $("#treeview2").hummingbird("expandNode",{attr:"id",name:"xnode-0-1",expandParents:true});
   $('#treeview2').css({"pointer-events": "none"});
   
   
   $("#treeview").hummingbird("expandNode",{attr:"id",name:"node-0",expandParents:true});
   
   // $("#treeview").hummingbird("disableNode",{attr:"id",name: "node-0-1-2-1",state:true});
   
   
   $("#CheckAll").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("checkAll");
     measure_end();
   });
   
   
   $("#UnCheckAll").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("uncheckAll");
     measure_end();
   });
   
   
   $("#CollapseAll").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("collapseAll");
     measure_end();
   });
   
   
   $("#ExpandAll").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("expandAll");
     measure_end();
   });
   
   $("#checkNode").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("checkNode",{attr:"id",name: $("#checkNodeOnID").val(),expandParents:false});
     measure_end();
   });
   
   $("#uncheckNode").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("uncheckNode",{attr:"id",name: $("#uncheckNodeOnID").val(),collapseChildren:false});
     measure_end();
   });
   
   $("#expandNode").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("expandNode",{attr:"id",name: $("#expandNodeOnID").val(),expandParents:true});
     measure_end();
   });
   
   $("#collapseNode").on("click", function(){
     measure_start();
     $("#treeview").hummingbird("collapseNode",{attr:"id",name: $("#collapseNodeOnID").val(),collapseChildren:true});
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
   
   $("#enableNode").on("click", function(){
     measure_start();
     var state = $("#enable_state_true").prop("checked");
     var enableChildren = $("#enable_state_true_children").prop("checked");
     console.log("enableChildren= " + enableChildren)
     $("#treeview").hummingbird("enableNode",{attr:"id",name: $("#enableNodeOnID").val(),state:state,enableChildren:enableChildren});
     measure_end();
   });
   
   
   
   
   
   $("#getItems").on("click", function(){
     measure_start();
     var List = {"id" : [], "dataid" : [], "text" : [],"module" :[]};
     $("#treeview").hummingbird("getChecked",{list:List,onlyParents:true});
     $("#displayItems").val(List.dataid.join(","));
   //$("#displayItems1").html(List.text.join("<br>"));
   var L = List.id.length;
   if (L == 1) {
     $("#num").val(L + " item checked");
   } else {
     $("#num").val(L + " items checked");
   }
 });
   
   $("#getItems").on("click", function(){
     measure_start();
     var List1 = {"id" : [], "dataid" : [], "text" : [],"module" :[]};
     $("#treeview").hummingbird("getChecked",{list:List1,onlyEndNodes:true});
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
   var List = {"id" : [], "dataid" : [], "text" : [],"module" :[]};
   $("#treeview").hummingbird("getChecked",{list:List,onlyParents:true});
   $("#displayItems").val(List.dataid.join(","));
   var L = List.id.length;
   if (L == 1) {
     $("#num").val(L + " item checked");
   } else {
     $("#num").val(L + " items checked");
   }
   
   
   var List1 = {"id" : [], "dataid" : [], "text" : [],"module" :[]};
   $("#treeview").hummingbird("getChecked",{list:List1,onlyEndNodes:true});
   $("#displayItems1").val(List1.dataid.join("-"));
   $("#displayItems2").val(List1.id.join(":"));
   var L = List1.id.length;
   if (L == 1) {
     $("#num").val(L + " item checked");
   } else {
     $("#num").val(L + " items checked");
   }
   
   
   $("#treeview").on("CheckUncheckDone", function(){
     var List = {"id" : [], "dataid" : [], "text" : [],"module" :[]};
     $("#treeview").hummingbird("getChecked",{list:List,onlyParents:true});
     $("#displayItems").val(List.dataid.join(","));
     var L = List.id.length;
     if (L == 1) {
       $("#num").val(L + " item checked");
     } else {
       $("#num").val(L + " items checked");
     }
   });
   
   
   $("#treeview").on("CheckUncheckDone", function(){
     var List1 = {"id" : [], "dataid" : [], "text" : [],"module" :[]};
     $("#treeview").hummingbird("getChecked",{list:List1,onlyEndNodes:true});
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

 $("#treeview").hummingbird("search",{treeview_container:"treeview_container",search_input:"search_input",search_output:"search_output",search_button:"search_button",scrollOffset:-515,onlyEndNodes:false});

 @if($rows != "")

  @foreach ($rows as $row)
    
    $("#treeview").hummingbird("checkNode",{attr:"data-id",name: ["{{$row['array_permission']}}"],expandParents:false});
@endforeach

@endif



});
</script>
@endsection