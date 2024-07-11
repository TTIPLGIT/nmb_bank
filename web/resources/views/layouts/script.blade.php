<script src="{{ asset('asset/js/app.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>


<script src="{{ asset('asset/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('asset/bundles/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('asset/bundles/apexcharts/apexcharts.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('asset/js/page/index.js') }}"></script>
<script src="{{ asset('asset/js/page/datatables.js') }}"></script>

<script src="{{ asset('asset/bundles/datatables/export-tables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/jszip.min.js') }}"></script>
<!-- <script src="{{ asset('asset/bundles/datatables/export-tables/pdfmake.min.js') }}"></script> -->
<script src="{{ asset('asset/bundles/datatables/export-tables/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/buttons.print.min.js') }}"></script>


<!-- <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script> -->
<script src="{{ asset('js/jquery-ui.js') }}"></script>

<!-- <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script> -->

<!-- timepicker -->
<!-- <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<!-- <script src="{{ asset('js/buttons.html5.min.js') }}"></script> -->

<script src="{{asset('asset/bundles/timepickerjs/jquery.timepicker.min.js')}}"> </script>

<script src="{{ asset('js/buttons.html5.min.js') }}"></script>


<!-- Template JS File -->
<script src="{{ asset('asset/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('js/jquery.cookie.min.js') }}"></script>


<!-- <script type="text/javascript">$('#tableExport').DataTable();</script> -->
<!-- cookies -->

<!-- endcookies -->
<!-- <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>

<!-- <script type="text/javascript">$('#align').DataTable();</script> -->

<script type="text/javascript">
  // $('.savebutton').prop('disabled', true);

  $(document).ready(function() {
    $('#align').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      destroy: true,


    });



    var nav = document.getElementsByClassName("smn");
    for (let i = 0; i < nav.length; i++) {
      let currentnav = window.location.href;
      nav[i].parentElement.parentElement.style.display = (currentnav == nav[i].getAttribute("href")) ? "block" : "none";
      if (currentnav == nav[i].getAttribute("href")) {
        break;
      }
    }
    if (document.querySelector("[type='number']")) {
      document.querySelector("[type='number']").addEventListener("keypress", function(evt) {
        if (!$(this).hasClass('validate')) {
          if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
          }
        }
      });
    }

  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#align2').DataTable({



      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      "destroy": true,


    });

  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#align1').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });

    $('#align3').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });
    $('#align4').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });
    $('#new_align').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });
    $('#align5').DataTable({


      "lengthMenu": [
        [5, 10, 20, 250, -1],
        [5, 10, 20, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });
    $('#align7').DataTable({

      "paging": false,
      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    // $('#tableExport').DataTable({


    //   "lengthMenu": [
    //     [10, 50, 100, 250, -1],
    //     [10, 50, 100, 250, "All"]
    //   ], // page length options

    //   dom: 'lBfrtip',
    //   buttons: [
    //     'copy', 'csv', 'excel', 'pdf', 'print'
    //   ]
    // });

  });
</script>

<script type="text/javascript">
  $(document).ready(function() {

    var email = $('#email').val();
    var password = $('#password').val();

    // set cookies to expire in 14 days
    $.cookie('email', email, {
      expires: 14
    });
    $.cookie('password', password, {
      expires: 14
    });
    $.cookie('remember', true, {
      expires: 14
    });

  });
</script>
<script type="text/javascript">
  $(document).ready(function() {

    $('#example').DataTable({


      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'TABLOID',
        title: 'form Details',
        footer: true,
      }, {
        extend: 'copy',
        title: 'form Details'
      }, {
        extend: 'csv',
        title: 'form Details'
      }, {
        extend: 'excel',
        title: 'form Details'
      }, {
        extend: 'print',
        title: 'form Details'
      }],
    });

  });
</script>



<script type="text/javascript">
  $(document).ready(function() {
    $('#tendertable').DataTable({


      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'TABLOID',
        title: 'form Details',
        footer: true,
      }, {
        extend: 'copy',
        title: 'form Details'
      }, {
        extend: 'csv',
        title: 'form Details'
      }, {
        extend: 'excel',
        title: 'form Details'
      }, {
        extend: 'print',
        title: 'form Details'
      }],
    });

  });
</script>

<script type="text/javascript">
  //Open dropdown when clicking on element
  $(document).on('click', "a[data-dropdown='notificationMenu']", function(e) {
    e.preventDefault();

    var el = $(e.currentTarget);

    $('body').prepend('<div id="dropdownOverlay" style="background: transparent; height:100%;width:100%;position:fixed;"></div>')

    var container = $(e.currentTarget).parent();
    var dropdown = container.find('.dropdown');
    var containerWidth = container.width();
    var containerHeight = container.height();

    var anchorOffset = $(e.currentTarget).offset();

    dropdown.css({
      'right': containerWidth / 2 + 'px',
      'position': 'absolute',
      'z-index': 100
    })

    container.toggleClass('expanded')

  });

  //Close dropdowns on document click

  $(document).on('click', '#dropdownOverlay', function(e) {
    var el = $(e.currentTarget)[0].activeElement;

    if (typeof $(el).attr('data-dropdown') === 'undefined') {
      $('#dropdownOverlay').remove();
      $('.dropdown-container.expanded').removeClass('expanded');
    }
  })

  //Dropdown collapsile tabs
  $('.notification-tab').click(function(e) {
    if ($(e.currentTarget).parent().hasClass('expanded')) {
      $('.notification-group').removeClass('expanded');
    } else {
      $('.notification-group').removeClass('expanded');
      $(e.currentTarget).parent().toggleClass('expanded');
    }
  })
  // $('.savebutton').prop('disabled', true);
</script>

